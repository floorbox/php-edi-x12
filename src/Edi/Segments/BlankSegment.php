<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class BlankSegment
 * @package Mrstroz\Edi\Segments
 */
class BlankSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => '',
        9 => '',
        10 => '',
        11 => '',
        12 => '',
        13 => '',
        14 => '',
        15 => '',
        16 => '',
        17 => '',
        18 => '',
        19 => '',
        20 => '',
        21 => '',
        22 => '',
        23 => '',
        25 => '',
        26 => '',
        27 => '',
        28 => '',
    ];
}
