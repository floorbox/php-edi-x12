<?php

namespace Mrstroz\Edi;

use Mrstroz\Edi;

/**
 * Class SegmentParser
 * @package Mrstroz\Parse
 */
class SegmentParser
{
    /**
     * @param array $documents
     * @return array
     */
    public static function parseAllSegmentsAsArray(array $documents)
    {
        $documentParsed = array();
        foreach ($documents as $document) {
            foreach ($document->getSegments() as $segment) {

                $key = $segment[0];
                if(is_array($segment[0])) {
                    $key = reset($segment[0]);
                }

                if (isset(Edi::$segmentMapping[$key])) {
                    $className = Edi::$segmentMapping[$key];
                    $documentParsed[] = (new $className)->parse($segment);
                }
            }
        }

        return $documentParsed;
    }
}
