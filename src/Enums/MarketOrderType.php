<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum MarketOrderType: string
{
    case Buy = 'buy';
    case Sell = 'sell';
    case All = 'all';
}
