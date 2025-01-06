<?php

namespace NicolasKion\Esi\Enums;

enum LocationFlag: string
{
    case AssetSafety = 'AssetSafety';
    case AutoFit = 'AutoFit';
    case Bonus = 'Bonus';
    case Booster = 'Booster';
    case BoosterBay = 'BoosterBay';
    case Capsule = 'Capsule';
    case Cargo = 'Cargo';
    case CorpDeliveries = 'CorpDeliveries';
    case CorpSAG1 = 'CorpSAG1';
    case CorpSAG2 = 'CorpSAG2';
    case CorpSAG3 = 'CorpSAG3';
    case CorpSAG4 = 'CorpSAG4';
    case CorpSAG5 = 'CorpSAG5';
    case CorpSAG6 = 'CorpSAG6';
    case CorpSAG7 = 'CorpSAG7';
    case CorporationGoalDeliveries = 'CorporationGoalDeliveries';
    case CrateLoot = 'CrateLoot';
    case Deliveries = 'Deliveries';
    case DroneBay = 'DroneBay';
    case DustBattle = 'DustBattle';
    case DustDatabank = 'DustDatabank';
    case FighterBay = 'FighterBay';
    case FighterTube0 = 'FighterTube0';
    case FighterTube1 = 'FighterTube1';
    case FighterTube2 = 'FighterTube2';
    case FighterTube3 = 'FighterTube3';
    case FighterTube4 = 'FighterTube4';
    case FleetHangar = 'FleetHangar';
    case FrigateEscapeBay = 'FrigateEscapeBay';
    case Hangar = 'Hangar';
    case HangarAll = 'HangarAll';
    case HiSlot0 = 'HiSlot0';
    case HiSlot1 = 'HiSlot1';
    case HiSlot2 = 'HiSlot2';
    case HiSlot3 = 'HiSlot3';
    case HiSlot4 = 'HiSlot4';
    case HiSlot5 = 'HiSlot5';
    case HiSlot6 = 'HiSlot6';
    case HiSlot7 = 'HiSlot7';
    case HiddenModifiers = 'HiddenModifiers';
    case Implant = 'Implant';
    case Impounded = 'Impounded';
    case JunkyardReprocessed = 'JunkyardReprocessed';
    case JunkyardTrashed = 'JunkyardTrashed';
    case LoSlot0 = 'LoSlot0';
    case LoSlot1 = 'LoSlot1';
    case LoSlot2 = 'LoSlot2';
    case LoSlot3 = 'LoSlot3';
    case LoSlot4 = 'LoSlot4';
    case LoSlot5 = 'LoSlot5';
    case LoSlot6 = 'LoSlot6';
    case LoSlot7 = 'LoSlot7';
    case Locked = 'Locked';
    case MedSlot0 = 'MedSlot0';
    case MedSlot1 = 'MedSlot1';
    case MedSlot2 = 'MedSlot2';
    case MedSlot3 = 'MedSlot3';
    case MedSlot4 = 'MedSlot4';
    case MedSlot5 = 'MedSlot5';
    case MedSlot6 = 'MedSlot6';
    case MedSlot7 = 'MedSlot7';
    case MobileDepotHold = 'MobileDepotHold';
    case OfficeFolder = 'OfficeFolder';
    case Pilot = 'Pilot';
    case PlanetSurface = 'PlanetSurface';
    case QuafeBay = 'QuafeBay';
    case QuantumCoreRoom = 'QuantumCoreRoom';
    case Reward = 'Reward';
    case RigSlot0 = 'RigSlot0';
    case RigSlot1 = 'RigSlot1';
    case RigSlot2 = 'RigSlot2';
    case RigSlot3 = 'RigSlot3';
    case RigSlot4 = 'RigSlot4';
    case RigSlot5 = 'RigSlot5';
    case RigSlot6 = 'RigSlot6';
    case RigSlot7 = 'RigSlot7';
    case SecondaryStorage = 'SecondaryStorage';
    case ServiceSlot0 = 'ServiceSlot0';
    case ServiceSlot1 = 'ServiceSlot1';
    case ServiceSlot2 = 'ServiceSlot2';
    case ServiceSlot3 = 'ServiceSlot3';
    case ServiceSlot4 = 'ServiceSlot4';
    case ServiceSlot5 = 'ServiceSlot5';
    case ServiceSlot6 = 'ServiceSlot6';
    case ServiceSlot7 = 'ServiceSlot7';
    case ShipHangar = 'ShipHangar';
    case ShipOffline = 'ShipOffline';
    case Skill = 'Skill';
    case SkillInTraining = 'SkillInTraining';
    case SpecializedAmmoHold = 'SpecializedAmmoHold';
    case SpecializedAsteroidHold = 'SpecializedAsteroidHold';
    case SpecializedCommandCenterHold = 'SpecializedCommandCenterHold';
    case SpecializedFuelBay = 'SpecializedFuelBay';
    case SpecializedGasHold = 'SpecializedGasHold';
    case SpecializedIceHold = 'SpecializedIceHold';
    case SpecializedIndustrialShipHold = 'SpecializedIndustrialShipHold';
    case SpecializedLargeShipHold = 'SpecializedLargeShipHold';
    case SpecializedMaterialBay = 'SpecializedMaterialBay';
    case SpecializedMediumShipHold = 'SpecializedMediumShipHold';
    case SpecializedMineralHold = 'SpecializedMineralHold';
    case SpecializedOreHold = 'SpecializedOreHold';
    case SpecializedPlanetaryCommoditiesHold = 'SpecializedPlanetaryCommoditiesHold';
    case SpecializedSalvageHold = 'SpecializedSalvageHold';
    case SpecializedShipHold = 'SpecializedShipHold';
    case SpecializedSmallShipHold = 'SpecializedSmallShipHold';
    case StructureActive = 'StructureActive';
    case StructureFuel = 'StructureFuel';
    case StructureInactive = 'StructureInactive';
    case StructureOffline = 'StructureOffline';
    case SubSystemBay = 'SubSystemBay';
    case SubSystemSlot0 = 'SubSystemSlot0';
    case SubSystemSlot1 = 'SubSystemSlot1';
    case SubSystemSlot2 = 'SubSystemSlot2';
    case SubSystemSlot3 = 'SubSystemSlot3';
    case SubSystemSlot4 = 'SubSystemSlot4';
    case SubSystemSlot5 = 'SubSystemSlot5';
    case SubSystemSlot6 = 'SubSystemSlot6';
    case SubSystemSlot7 = 'SubSystemSlot7';
    case Unlocked = 'Unlocked';
    case Wallet = 'Wallet';
    case Wardrobe = 'Wardrobe';
    case InfrastructureHangar = 'InfrastructureHangar';
    case CorpseBay = 'CorpseBay';
    case MoonMaterialBay = 'MoonMaterialBay';

    public static function isStructureLocation(LocationFlag $locationFlag): bool
    {
        return in_array($locationFlag, [
            self::Hangar,
            self::ShipHangar,
            self::OfficeFolder,
        ]);
    }

    /**
     * @return LocationFlag[]
     */
    public static function fittingFlags(): array
    {
        return [
            self::DroneBay,
            self::FighterBay,
            self::HiSlot0,
            self::HiSlot1,
            self::HiSlot2,
            self::HiSlot3,
            self::HiSlot4,
            self::HiSlot5,
            self::HiSlot6,
            self::HiSlot7,
            self::LoSlot0,
            self::LoSlot1,
            self::LoSlot2,
            self::LoSlot3,
            self::LoSlot4,
            self::LoSlot5,
            self::LoSlot6,
            self::LoSlot7,
            self::MedSlot0,
            self::MedSlot1,
            self::MedSlot2,
            self::MedSlot3,
            self::MedSlot4,
            self::MedSlot5,
            self::MedSlot6,
            self::MedSlot7,
            self::RigSlot0,
            self::RigSlot1,
            self::RigSlot2,
            self::RigSlot3,
            self::RigSlot4,
            self::RigSlot5,
            self::RigSlot6,
            self::RigSlot7,
        ];
    }
}
