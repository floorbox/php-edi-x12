<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class AmtSegment
 * @package Mrstroz\Edi\Segments
 */
class QtySegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY, //To specify basic and most frequently used line item data
        1 => 'quantity_qualifier', //Code to qualify quantity available
        2 => 'quantity', //Quantity available
        3 => 'unit_of_measurement_code', //Code specifying the units in which a value is being expressed
    ];
}