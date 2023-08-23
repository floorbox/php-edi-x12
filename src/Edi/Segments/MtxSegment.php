<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class MtxSegment
 * @package Mrstroz\Edi\Segments
 */
class MtxSegment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => 'note_reference_code',
        2 => 'message_text',
    ];
}
