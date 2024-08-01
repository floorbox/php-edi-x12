<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class AmtSegment
 * @package Mrstroz\Edi\Segments
 */
class SchSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY, //To specify basic and most frequently used line item data
        1 => 'quantity', //Quantity available
        2 => 'unit_of_measurement_code', //Code specifying the units in which a value is being expressed
        3 => 'time_qualifier', //Date/Time Qualifier
        4 => 'date', //Date
    ];
}
