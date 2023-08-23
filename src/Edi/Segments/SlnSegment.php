<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class SlnSegment
 * @package Mrstroz\Edi\Segments
 */
class SlnSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => 'note_reference_code',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => 'relationship_code',
        9 => 'sk',
        10 => 'sku',
        11 => 'up',
        12 => 'upc_code',
        13 => 'mg',
        14 => 'manufacturer_part_number',
        15 => 'st',
        16 => 'style_number',
        17 => 'bk',
        18 => 'backing',
        19 => 'sz',
        20 => 'size_code',
        21 => 'ms',
        22 => 'manufacturer_style_number',
        23 => 'mn',
        24 => 'manufacturer_style_name',
    ];
}
