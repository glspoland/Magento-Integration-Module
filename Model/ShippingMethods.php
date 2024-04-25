<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class ShippingMethods
{
    /**
     * GLS shipping methods
     *
     * @var array
     */
    public const METHODS = [
        'glspoland_gls_courier' => [
            'code' => 'gls_courier',
            'config_path' => 'carriers/glspoland/courier/gls_courier',
            'parcel' => false,
            'sat' => false,
            's10' => false,
            's12' => false,
        ],
        'glspoland_gls_courier_10' => [
            'code' => 'gls_courier_10',
            'config_path' => 'carriers/glspoland/courier/gls_courier_10',
            'parcel' => false,
            'sat' => false,
            's10' => true,
            's12' => false,
        ],
        'glspoland_gls_courier_12' => [
            'code' => 'gls_courier_12',
            'config_path' => 'carriers/glspoland/courier/gls_courier_12',
            'parcel' => false,
            'sat' => false,
            's10' => false,
            's12' => true,
        ],
        'glspoland_gls_courier_sat' => [
            'code' => 'gls_courier_sat',
            'config_path' => 'carriers/glspoland/courier/gls_courier_sat',
            'parcel' => false,
            'sat' => true,
            's10' => false,
            's12' => false,
        ],
        'glspoland_gls_courier_sat_10' => [
            'code' => 'gls_courier_sat_10',
            'config_path' => 'carriers/glspoland/courier/gls_courier_sat_10',
            'parcel' => false,
            'sat' => true,
            's10' => true,
            's12' => false,
        ],
        'glspoland_gls_courier_sat_12' => [
            'code' => 'gls_courier_sat_12',
            'config_path' => 'carriers/glspoland/courier/gls_courier_sat_12',
            'parcel' => false,
            'sat' => false,
            's10' => false,
            's12' => false,
        ],
        'glspoland_gls_parcel_shop' => [
            'code' => 'gls_parcel_shop',
            'config_path' => 'carriers/glspoland/gls_parcel_shop',
            'parcel' => true,
            'sat' => false,
            's10' => false,
            's12' => false,
        ]
    ];
}
