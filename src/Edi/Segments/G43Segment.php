<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class G43Segment
 * @package Mrstroz\Edi\Segments
 */
class G43Segment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => 'market_area_code',
        2 => '',
        3 => 'description',
    ];
}
