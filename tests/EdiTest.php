<?php

use Mrstroz\Edi;
use Mrstroz\Edi\SegmentParser;
use PHPUnit\Framework\TestCase;

final class EdiTest extends TestCase
{
    public function testReadsCatalogWithCarriageReturnTerminators(): void
    {
        $documents = Edi::parseFile(__DIR__.'/Fixtures/catalog-descriptions.832');

        self::assertCount(1, $documents);
        $segments = $documents[0]->getSegments();
        self::assertCount(23, $segments);
        self::assertSame('ISA', $segments[0][0]);
        self::assertSame(':', $segments[0][16]);
        self::assertSame('IEA', $segments[22][0]);
    }

    public function testPreservesLiteralColonsInCatalogDescriptions(): void
    {
        $segments = SegmentParser::parseAllSegmentsAsArray(
            Edi::parseFile(__DIR__.'/Fixtures/catalog-descriptions.832')
        );
        $descriptions = [
            '30852242' => 'STANDARD 7:1 - 10 0Z GUN',
            '30852243' => 'DELUXE 26:1 - 10 0Z GUN',
            '30852244' => 'DELUXE 26:1 - 28 0Z GUN',
            '17843' => 'TITEBOND 25:1 THRUST CAULK GUN',
        ];

        $segments = array_slice($segments, 4, 16);
        foreach ($descriptions as $sku => $description) {
            $line = array_shift($segments);
            self::assertSame('LIN', $line['edi_qualifier']);
            self::assertSame($description, $line['manufacturer_style_name']);
            $descriptionSegment = array_shift($segments);
            self::assertSame('PID', $descriptionSegment['edi_qualifier']);
            self::assertSame('F', $descriptionSegment['item_description_type']);
            self::assertSame('TRN', $descriptionSegment['product_characteristic_code']);
            self::assertSame($description, $descriptionSegment['description']);

            array_shift($segments); // CTP
            $subline = array_shift($segments);
            self::assertSame('SLN', $subline['edi_qualifier']);
            self::assertSame((string) $sku, $subline['sku']);
            self::assertSame($description, $subline['manufacturer_style_name']);
        }
    }

    public function testPreservesCompositeElementsWithoutConvertingScalarElements(): void
    {
        $catalog = file_get_contents(__DIR__.'/Fixtures/composite-unit.832');
        $segments = Edi::parse($catalog)[0]->getSegments();

        self::assertSame(['CTP', '', 'LPR', '1.00', '', ['EA', '1']], $segments[5]);
        $mapped = SegmentParser::parseAllSegmentsAsArray(Edi::parse($catalog));
        self::assertSame('CTP', $mapped[5]['edi_qualifier']);
        self::assertSame(['EA', '1'], $mapped[5]['unit_of_measurement_code']);
    }

    public function testUsesTheEnvelopeComponentSeparator(): void
    {
        $catalog = file_get_contents(__DIR__.'/Fixtures/catalog-descriptions.832');
        $catalog = str_replace(':', '>', $catalog);
        $catalog = str_replace('CTP**LPR*1.00**EA', 'CTP**LPR*1.00**EA>1', $catalog);
        $segments = Edi::parse($catalog)[0]->getSegments();

        self::assertSame('STANDARD 7>1 - 10 0Z GUN', $segments[5][5]);
        self::assertSame(['EA', '1'], $segments[6][5]);
        self::assertSame('CTP', $segments[6][0]);
    }
}
