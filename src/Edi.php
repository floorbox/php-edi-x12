<?php

namespace Mrstroz;

use Mrstroz\Edi\Document;

/**
 * A class to parse ASC X12 EDI documents
 */
class Edi
{
    public const SEGMENT_TERMINATOR_POSITION = 105;
    public const SUBELEMENT_SEPARATOR_POSITION = 104;
    public const ELEMENT_SEPARATOR_POSITION = 3;

    public static $segmentMapping = [
        'AMT' => 'Mrstroz\Edi\Segments\AmtSegment',
        'B4' => 'Mrstroz\Edi\Segments\B4Segment',
        'BCT' => 'Mrstroz\Edi\Segments\BctSegment',
        'BEG' => 'Mrstroz\Edi\Segments\BegSegment',
        'CTT' => 'Mrstroz\Edi\Segments\CttSegment',
        'CTP' => 'Mrstroz\Edi\Segments\CtpSegment',
        'DTM' => 'Mrstroz\Edi\Segments\DtmSegment',
        'FOB' => 'Mrstroz\Edi\Segments\FobSegment',
        'G39' => 'Mrstroz\Edi\Segments\G39Segment',
        'G43' => 'Mrstroz\Edi\Segments\G43Segment',
        'GE' => 'Mrstroz\Edi\Segments\GeSegment',
        'GS' => 'Mrstroz\Edi\Segments\GsSegment',
        'IEA' => 'Mrstroz\Edi\Segments\IeaSegment',
        'ISA' => 'Mrstroz\Edi\Segments\IsaSegment',
        'LIN' => 'Mrstroz\Edi\Segments\LinSegment',
        'MEA' => 'Mrstroz\Edi\Segments\MeaSegment',
        'MSG' => 'Mrstroz\Edi\Segments\MsgSegment',
        'MTX' => 'Mrstroz\Edi\Segments\MtxSegment',
        'N1' => 'Mrstroz\Edi\Segments\N1Segment',
        'N2' => 'Mrstroz\Edi\Segments\N2Segment',
        'N3' => 'Mrstroz\Edi\Segments\N3Segment',
        'N4' => 'Mrstroz\Edi\Segments\N4Segment',
        'N9' => 'Mrstroz\Edi\Segments\N9Segment',
        'PER' => 'Mrstroz\Edi\Segments\PerSegment',
        'PID' => 'Mrstroz\Edi\Segments\PidSegment',
        'PO1' => 'Mrstroz\Edi\Segments\Po1Segment',
        'Q2' => 'Mrstroz\Edi\Segments\Q2Segment',
        'QTY' => 'Mrstroz\Edi\Segments\QtySegment',
        'R4' => 'Mrstroz\Edi\Segments\R4Segment',
        'REF' => 'Mrstroz\Edi\Segments\RefSegment',
        'SAC' => 'Mrstroz\Edi\Segments\SacSegment',
        'SCH' => 'Mrstroz\Edi\Segments\SchSegment',
        'SLN' => 'Mrstroz\Edi\Segments\SlnSegment',
        'SE' => 'Mrstroz\Edi\Segments\SeSegment',
        'ST' => 'Mrstroz\Edi\Segments\StSegment',
        'TC2' => 'Mrstroz\Edi\Segments\Tc2Segment',
        'TD1' => 'Mrstroz\Edi\Segments\Td1Segment',
        'TD4' => 'Mrstroz\Edi\Segments\Td4Segment',
        'TD5' => 'Mrstroz\Edi\Segments\Td5Segment',
    ];

    /**
     * Parse an EDI document. Data will be returned as an array of instances of
     * EDI\Document. Document should contain exactly one ISA/IEA envelope.
     */
    public static function parse($res): array
    {
        $segments = [];

        if (!$res) {
            throw new \Exception('No resource or string passed to parse()');
        }

        $documents = [];
        if (is_resource($res)) {
            $meta = stream_get_meta_data($res);
            if (!$meta['seekable']) {
                throw new \Exception('Stream is not seekable');
            }

            throw new \Exception('Not implemented!');
        } else {
            $data = $res;
            // treat as string.
            if (strcasecmp(substr($data, 0, 3), 'ISA') != 0) {
                throw new \Exception('ISA segment not found in data stream');
            }

            $segment_terminator = substr($data, self::SEGMENT_TERMINATOR_POSITION, 1);
            $element_separator = substr($data, self::ELEMENT_SEPARATOR_POSITION, 1);
            $subelement_separator = substr($data, self::SUBELEMENT_SEPARATOR_POSITION, 1);

            $document = null;
            $raw_segments = explode($segment_terminator, $data);
        }

        $current_isa = null;
        $current_gs = null;
        $current_st = null;

        foreach ($raw_segments as $segment) {
            $elements = array_map('trim', explode($element_separator, $segment));
            $identifier = strtoupper($elements[0]);

            // only inspect each element if the subelement separator is present in the string
            if (strpos($segment, $subelement_separator) !== false && $identifier != 'ISA') {
                foreach ($elements as &$element) {
                    if (strpos($segment, $subelement_separator) !== false) {
                        $element = explode($subelement_separator, $element);
                    }
                }
                unset($element);
            }

            /* This is a ginormous switch statement, but necessarily so.
             * The idea is that the parser will, for each transaction set
             * in the ISA envelope, create a new Document instance with
             * the containing ISA and GS envelopes copied in.
             */
            switch ($identifier) {
                case 'ISA':
                    $current_isa = ['isa' => $elements];
                    break;
                case 'GS':
                    $current_gs = ['gs' => $elements];
                    break;
                case 'ST':
                    $current_st = ['st' => $elements];
                    break;
                case 'SE':
                    assert($current_gs != null, 'GS data structure isset');
                    $current_st['se'] = $elements;
                    if (!isset($current_gs['txn_sets'])) {
                        $current_gs['txn_sets'] = [];
                    }
                    array_push($current_gs['txn_sets'], $current_st);
                    $current_st = null;
                    break;
                case 'GE':
                    assert($current_isa != null, 'ST data structure isset');
                    $current_gs['ge'] = $elements;
                    if (!isset($current_isa['func_groups'])) {
                        $current_isa['func_groups'] = [];
                    }
                    array_push($current_isa['func_groups'], $current_gs);
                    $current_gs = null;
                    break;
                case 'IEA':
                    $current_isa['iea'] = $elements;
                    foreach ($current_isa['func_groups'] as $gs) {
                        foreach ($gs['txn_sets'] as $st) {
                            $segments = array_merge(
                                [
                                    $current_isa['isa'],
                                    $gs['gs'],
                                    $st['st']
                                ],
                                $st['segments'],
                                [
                                    $st['se'],
                                    $gs['ge'],
                                    $current_isa['iea']
                                ]
                            );
                            $document = new Document($segments);
                            array_push($documents, $document);
                        }
                    }
                    break;
                default:
                    if (!isset($current_st['segments'])) {
                        $current_st['segments'] = [];
                    }
                    array_push($current_st['segments'], $elements);
                    break;
            }
        }

        return $documents;
    }

    /**
     * @param $file
     * @return array
     * @throws \Exception
     */
    public static function parseFile($file)
    {
        $contents = file_get_contents($file);
        return self::parse($contents);
    }
}
