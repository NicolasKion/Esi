<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum ContactType: string
{
    case Character = 'character';
    case Corporation = 'corporation';
    case Alliance = 'alliance';
    case Faction = 'faction';
}
