<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class MeaSegment
 * @package Mrstroz\Edi\Segments
 */
class MeaSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => '',
        2 => 'measurement_qualifier',
        3 => 'measurement_value',
        4 => 'unit_of_measurement_code',
    ];
}
