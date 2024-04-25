<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class LabelMode
{
    public const A4_ONE_LABEL_LT_PDF = 'one_label_on_a4_lt_pdf';
    public const A4_ONE_LABEL_RT_PDF = 'one_label_on_a4_rt_pdf';
    public const A4_ONE_LABEL_LB_PDF = 'one_label_on_a4_lb_pdf';
    public const A4_ONE_LABEL_RB_PDF = 'one_label_on_a4_rb_pdf';
    public const A4_ONE_LABEL_PDF = 'one_label_on_a4_pdf';
    public const A4_FOUR_LABEL_PDF = 'four_labels_on_a4_pdf';
    public const A4_FOUR_LABEL_RIGHT_PDF = 'four_labels_on_a4_right_pdf';
    public const ROLL_160X100_PDF = 'roll_160x100_pdf';
    public const ROLL_160X100_VERTICAL_PDF = 'roll_160x100_vertical_pdf';
    public const ROLL_160X100_DATAMAX = 'roll_160x100_datamax';
    public const ROLL_160X100_ZEBRA = 'roll_160x100_zebra';
    public const ROLL_160X100_ZEBRA_300 = 'roll_160x100_zebra_300';
    public const ROLL_160X100_ZEBRA_ELP = 'roll_160x100_zebra_epl';
}
