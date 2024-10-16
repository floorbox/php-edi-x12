<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class CtpSegment
 * @package Mrstroz\Edi\Segments
 */
class CtpSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => '',
        2 => 'price_identifier_code',
        3 => 'unit_price',
        4 => 'quantity',
        5 => 'unit_of_measurement_code',
        6 => '',
        7 => '',
        8 => '',
        9 => 'basis_of_unit_price_code',
        10 => 'condition_value',
    ];
}
