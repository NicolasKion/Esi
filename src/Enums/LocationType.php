<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum LocationType: string
{
    case Station = 'station';
    case Solar_system = 'solar_system';
    case Other = 'other';
    case Item = 'item';
}
