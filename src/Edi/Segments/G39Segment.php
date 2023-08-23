<?php

namespace Mrstroz\Edi\Segments;

use Mrstroz\Edi\Segment;

/**
 * Class G39Segment
 * @package Mrstroz\Edi\Segments
 */
class G39Segment extends Segment
{
    public $segmentMapping = [
        0 => parent::EDI_QUALIFIER_KEY,
        1 => '',
        2 => 'product_or_service_id_qualifier',
        3 => 'product_or_service_id',
        4 => '',
        5 => 'unit_weight_per_base_unit',
        6 => 'weight_qualifier',
        7 => 'weight_unit_code',
        8 => 'height',
        9 => 'height_unit_or_basis_for_measurement_code',
        10 => 'width',
        11 => 'width_unit_or_basis_for_measurement_code',
        12 => 'length',
        13 => 'length_unit_or_basis_for_measurement_code',
        14 => 'volume',
        15 => 'volume_unit_or_basis_for_measurement_code',
        16 => 'size',
        17 => '',
        18 => 'size',
        19 => 'size_unit_or_basis_for_measurement_code',
        20 => '',
        21 => '',
        22 => '',
        23 => '',
        25 => '',
        26 => '',
        27 => '',
        28 => 'packaging_code',
    ];
}
