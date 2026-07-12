<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum RoutePreference: string
{
    case Shorter = 'Shorter';
    case Safer = 'Safer';
    case LessSecure = 'LessSecure';
}
