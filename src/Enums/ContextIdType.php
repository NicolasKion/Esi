<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum ContextIdType: string
{
    case StructureId = 'structure_id';
    case StationId = 'station_id';
    case MarketTransactionId = 'market_transaction_id';
    case CharacterId = 'character_id';
    case CorporationId = 'corporation_id';
    case AllianceId = 'alliance_id';
    case EveSystem = 'eve_system';
    case IndustryJobId = 'industry_job_id';
    case ContractId = 'contract_id';
    case PlanetId = 'planet_id';
    case SystemId = 'system_id';
    case TypeId = 'type_id';
}
