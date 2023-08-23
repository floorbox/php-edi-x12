<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class BctSegment
 * @package Mrstroz\Edi\Segments
 */
class BctSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => 'catalog_purpose_code',
        2 => '',
        3 => 'catalog_version_number',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
        8 => '',
        9 => '',
        10 => 'transaction_set_purpose_codes',
    ];
}
