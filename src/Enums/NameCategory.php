<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum NameCategory: string
{
    case Alliance = 'alliance';
    case Character = 'character';
    case Constellation = 'constellation';
    case Corporation = 'corporation';
    case InventoryType = 'inventory_type';
    case Region = 'region';
    case SolarSystem = 'solar_system';
    case Station = 'station';
    case Faction = 'faction';
}
