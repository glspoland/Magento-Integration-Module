<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class ReceiptMode
{
    public const WITH_BARCODES = 'with_barcodes';
    public const CONDENSED = 'condensed';
    public const CONDENSED_DESCRIPTION_OF_PICKUP = 'condensed_description_of_pickup';
}
