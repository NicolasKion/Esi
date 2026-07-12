<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum EsiScope: string
{
    case ReadAssets = 'esi-assets.read_assets.v1';
    case ReadMarketStructures = 'esi-markets.structure_markets.v1';
    case PublicData = 'publicData';
    case OpenWindow = 'esi-ui.open_window.v1';
    case ReadContracts = 'esi-contracts.read_character_contracts.v1';
    case ReadCorporationContracts = 'esi-contracts.read_corporation_contracts.v1';
    case ReadKillmails = 'esi-killmails.read_killmails.v1';
    case ReadCorporationKillmails = 'esi-killmails.read_corporation_killmails.v1';
    case ReadMail = 'esi-mail.read_mail.v1';
    case SendMail = 'esi-mail.send_mail.v1';
    case OrganizeMail = 'esi-mail.organize_mail.v1';
    case ReadStructures = 'esi-universe.read_structures.v1';
    case ReadCorporationAssets = 'esi-assets.read_corporation_assets.v1';
    case ReadWallet = 'esi-wallet.read_character_wallet.v1';
    case ReadLocations = 'esi-location.read_location.v1';
    case ReadOnlineStatus = 'esi-location.read_online.v1';
    case ReadShip = 'esi-location.read_ship_type.v1';
    case WriteWaypoint = 'esi-ui.write_waypoint.v1';
    case ReadCorporationDivisions = 'esi-corporations.read_divisions.v1';
    case ReadCorporationStructures = 'esi-corporations.read_structures.v1';
    case ReadCharacterContacts = 'esi-characters.read_contacts.v1';
    case WriteCharacterContacts = 'esi-characters.write_contacts.v1';
    case ReadCorporationContacts = 'esi-corporations.read_contacts.v1';
    case ReadAllianceContacts = 'esi-alliances.read_contacts.v1';
    case ReadCorporationBlueprints = 'esi-corporations.read_blueprints.v1';
    case ReadCorporationContainerLogs = 'esi-corporations.read_container_logs.v1';
    case ReadCorporationFacilities = 'esi-corporations.read_facilities.v1';
    case ReadCorporationMedals = 'esi-corporations.read_medals.v1';
    case ReadCorporationMembership = 'esi-corporations.read_corporation_membership.v1';
    case TrackCorporationMembers = 'esi-corporations.track_members.v1';
    case ReadCorporationTitles = 'esi-corporations.read_titles.v1';
    case ReadCorporationWallets = 'esi-wallet.read_corporation_wallets.v1';
    case ReadCorporationStandings = 'esi-corporations.read_standings.v1';
    case ReadCorporationStarbases = 'esi-corporations.read_starbases.v1';
    case ReadAgentsResearch = 'esi-characters.read_agents_research.v1';
    case ReadCharacterBlueprints = 'esi-characters.read_blueprints.v1';
    case ReadFatigue = 'esi-characters.read_fatigue.v1';
    case ReadCharacterMedals = 'esi-characters.read_medals.v1';
    case ReadNotifications = 'esi-characters.read_notifications.v1';
    case ReadCharacterCorporationRoles = 'esi-characters.read_corporation_roles.v1';
    case ReadCharacterStandings = 'esi-characters.read_standings.v1';
    case ReadCharacterTitles = 'esi-characters.read_titles.v1';
    case ReadCharacterFwStats = 'esi-characters.read_fw_stats.v1';
    case ReadCorporationFwStats = 'esi-corporations.read_fw_stats.v1';
    case ReadSkills = 'esi-skills.read_skills.v1';
    case ReadSkillQueue = 'esi-skills.read_skillqueue.v1';
    case ReadClones = 'esi-clones.read_clones.v1';
    case ReadImplants = 'esi-clones.read_implants.v1';
    case ReadFleet = 'esi-fleets.read_fleet.v1';
    case WriteFleet = 'esi-fleets.write_fleet.v1';
    case ReadCharacterIndustryJobs = 'esi-industry.read_character_jobs.v1';
    case ReadCharacterMining = 'esi-industry.read_character_mining.v1';
    case ReadCorporationMining = 'esi-industry.read_corporation_mining.v1';
    case ReadCorporationIndustryJobs = 'esi-industry.read_corporation_jobs.v1';
    case ReadCharacterOrders = 'esi-markets.read_character_orders.v1';
    case ReadCorporationOrders = 'esi-markets.read_corporation_orders.v1';
    case ReadLoyaltyPoints = 'esi-characters.read_loyalty.v1';

    /**
     * @return array<int, string>
     */
    public static function fromRequest(string $scopes): array
    {
        $scopes = explode(',', $scopes);

        return array_map(fn ($scope) => self::from($scope)->value, $scopes);
    }

    /**
     * @return array<int, string>
     */
    public static function all(): array
    {
        return array_map(fn (self $scope): string => $scope->value, self::cases());
    }
}
