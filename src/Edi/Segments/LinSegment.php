<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class LinSegment
 * @package Mrstroz\Edi\Segments
 */
class LinSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => '',
        2 => 'general_specification_number',
        3 => 'pricing_group_number',
        4 => 'manufacturer',
        5 => 'manufacturer_original_name',
        6 => 'st',
        7 => 'style_number',
        8 => 'bk',
        9 => 'backing_value',
        10 => 'sz',
        11 => 'size_code',
        12 => 'ms',
        13 => 'manufacturer_style_number',
        14 => 'mn',
        15 => 'manufacturer_style_name',
        16 => 'ux',
        17 => 'unique_product_number',
    ];
}
