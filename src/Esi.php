<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace NicolasKion\Esi;

use NicolasKion\Esi\DTO\AgentResearch;
use NicolasKion\Esi\DTO\Alliance;
use NicolasKion\Esi\DTO\AllianceHistory;
use NicolasKion\Esi\DTO\AllianceIcons;
use NicolasKion\Esi\DTO\Ancestry;
use NicolasKion\Esi\DTO\Asset;
use NicolasKion\Esi\DTO\AssetLocation;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\DTO\AsteroidBelt;
use NicolasKion\Esi\DTO\Bloodline;
use NicolasKion\Esi\DTO\Blueprint;
use NicolasKion\Esi\DTO\CalendarEvent;
use NicolasKion\Esi\DTO\CalendarEventAttendee;
use NicolasKion\Esi\DTO\CalendarEventSummary;
use NicolasKion\Esi\DTO\CharacterAffiliation;
use NicolasKion\Esi\DTO\CharacterAttributes;
use NicolasKion\Esi\DTO\CharacterClones;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\DTO\CharacterFactionWarfareStats;
use NicolasKion\Esi\DTO\CharacterMedal;
use NicolasKion\Esi\DTO\CharacterPortrait;
use NicolasKion\Esi\DTO\CharacterRoles;
use NicolasKion\Esi\DTO\CharacterSkills;
use NicolasKion\Esi\DTO\CharacterTitle;
use NicolasKion\Esi\DTO\Constellation;
use NicolasKion\Esi\DTO\Contact;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\DTO\ContactNotification;
use NicolasKion\Esi\DTO\ContainerLog;
use NicolasKion\Esi\DTO\ContractBid;
use NicolasKion\Esi\DTO\Corporation;
use NicolasKion\Esi\DTO\CorporationDivisions;
use NicolasKion\Esi\DTO\CorporationFactionWarfareStats;
use NicolasKion\Esi\DTO\CorporationHistory;
use NicolasKion\Esi\DTO\CorporationIcons;
use NicolasKion\Esi\DTO\CorporationMedal;
use NicolasKion\Esi\DTO\CorporationRoles;
use NicolasKion\Esi\DTO\CorporationStructure;
use NicolasKion\Esi\DTO\CorporationTitle;
use NicolasKion\Esi\DTO\CorporationWallet;
use NicolasKion\Esi\DTO\CustomsOffice;
use NicolasKion\Esi\DTO\DogmaAttribute;
use NicolasKion\Esi\DTO\DogmaEffect;
use NicolasKion\Esi\DTO\DogmaItem;
use NicolasKion\Esi\DTO\EsiResult;
use NicolasKion\Esi\DTO\EveMail;
use NicolasKion\Esi\DTO\Facility;
use NicolasKion\Esi\DTO\Faction;
use NicolasKion\Esi\DTO\FactionWarfareCharacterLeaderboard;
use NicolasKion\Esi\DTO\FactionWarfareCorporationLeaderboard;
use NicolasKion\Esi\DTO\FactionWarfareFactionStats;
use NicolasKion\Esi\DTO\FactionWarfareLeaderboard;
use NicolasKion\Esi\DTO\FactionWarfareSystem;
use NicolasKion\Esi\DTO\FactionWarfareWar;
use NicolasKion\Esi\DTO\Fitting;
use NicolasKion\Esi\DTO\Fleet;
use NicolasKion\Esi\DTO\FleetInfo;
use NicolasKion\Esi\DTO\FleetMember;
use NicolasKion\Esi\DTO\FleetWing;
use NicolasKion\Esi\DTO\Graphic;
use NicolasKion\Esi\DTO\Incursion;
use NicolasKion\Esi\DTO\IndustryFacility;
use NicolasKion\Esi\DTO\IndustryJob;
use NicolasKion\Esi\DTO\IndustrySystem;
use NicolasKion\Esi\DTO\InsurancePrice;
use NicolasKion\Esi\DTO\IssuedMedal;
use NicolasKion\Esi\DTO\JumpFatigue;
use NicolasKion\Esi\DTO\Killmail;
use NicolasKion\Esi\DTO\KillmailRef;
use NicolasKion\Esi\DTO\Location;
use NicolasKion\Esi\DTO\LoyaltyOffer;
use NicolasKion\Esi\DTO\LoyaltyPoints;
use NicolasKion\Esi\DTO\MailingList;
use NicolasKion\Esi\DTO\MailLabels;
use NicolasKion\Esi\DTO\MarketGroup;
use NicolasKion\Esi\DTO\MarketHistory;
use NicolasKion\Esi\DTO\MarketOrder;
use NicolasKion\Esi\DTO\MarketPrice;
use NicolasKion\Esi\DTO\MemberTitles;
use NicolasKion\Esi\DTO\MemberTracking;
use NicolasKion\Esi\DTO\MiningExtraction;
use NicolasKion\Esi\DTO\MiningLedgerEntry;
use NicolasKion\Esi\DTO\MiningObserver;
use NicolasKion\Esi\DTO\MiningObserverEntry;
use NicolasKion\Esi\DTO\Moon;
use NicolasKion\Esi\DTO\Name;
use NicolasKion\Esi\DTO\Notification;
use NicolasKion\Esi\DTO\Online;
use NicolasKion\Esi\DTO\PersonalMarketOrder;
use NicolasKion\Esi\DTO\PersonalMarketOrderHistory;
use NicolasKion\Esi\DTO\Planet;
use NicolasKion\Esi\DTO\PlanetColony;
use NicolasKion\Esi\DTO\PlanetLayout;
use NicolasKion\Esi\DTO\PublicContract;
use NicolasKion\Esi\DTO\PublicContractBid;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\DTO\Race;
use NicolasKion\Esi\DTO\RaidableSkyhook;
use NicolasKion\Esi\DTO\Region;
use NicolasKion\Esi\DTO\RoleHistory;
use NicolasKion\Esi\DTO\Schematic;
use NicolasKion\Esi\DTO\Shareholder;
use NicolasKion\Esi\DTO\Ship;
use NicolasKion\Esi\DTO\SkillQueueEntry;
use NicolasKion\Esi\DTO\Sovereignty;
use NicolasKion\Esi\DTO\Standing;
use NicolasKion\Esi\DTO\Star;
use NicolasKion\Esi\DTO\Starbase;
use NicolasKion\Esi\DTO\StarbaseDetail;
use NicolasKion\Esi\DTO\Stargate;
use NicolasKion\Esi\DTO\Station;
use NicolasKion\Esi\DTO\Status;
use NicolasKion\Esi\DTO\Structure;
use NicolasKion\Esi\DTO\System;
use NicolasKion\Esi\DTO\SystemJumps;
use NicolasKion\Esi\DTO\SystemKills;
use NicolasKion\Esi\DTO\UniverseCategory;
use NicolasKion\Esi\DTO\UniverseGroup;
use NicolasKion\Esi\DTO\UniverseIds;
use NicolasKion\Esi\DTO\UniverseType;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\DTO\WalletTransaction;
use NicolasKion\Esi\DTO\War;
use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Enums\MarketOrderType;
use NicolasKion\Esi\Enums\RoutePreference;
use NicolasKion\Esi\Interfaces\Character;
use NicolasKion\Esi\Requests\AddCharacterContactsRequest;
use NicolasKion\Esi\Requests\CreateFittingRequest;
use NicolasKion\Esi\Requests\CreateFleetSquadRequest;
use NicolasKion\Esi\Requests\CreateFleetWingRequest;
use NicolasKion\Esi\Requests\CreateMailLabelRequest;
use NicolasKion\Esi\Requests\DeleteCharacterContactsRequest;
use NicolasKion\Esi\Requests\DeleteFittingRequest;
use NicolasKion\Esi\Requests\DeleteFleetSquadRequest;
use NicolasKion\Esi\Requests\DeleteFleetWingRequest;
use NicolasKion\Esi\Requests\DeleteMailLabelRequest;
use NicolasKion\Esi\Requests\DeleteMailRequest;
use NicolasKion\Esi\Requests\EditCharacterContactsRequest;
use NicolasKion\Esi\Requests\GetAffiliationsRequest;
use NicolasKion\Esi\Requests\GetAgentsResearchRequest;
use NicolasKion\Esi\Requests\GetAllianceContactLabelsRequest;
use NicolasKion\Esi\Requests\GetAllianceContactsRequest;
use NicolasKion\Esi\Requests\GetAllianceCorporationsRequest;
use NicolasKion\Esi\Requests\GetAllianceIconsRequest;
use NicolasKion\Esi\Requests\GetAllianceRequest;
use NicolasKion\Esi\Requests\GetAlliancesRequest;
use NicolasKion\Esi\Requests\GetAncestriesRequest;
use NicolasKion\Esi\Requests\GetAssetLocationsRequest;
use NicolasKion\Esi\Requests\GetAssetNamesRequest;
use NicolasKion\Esi\Requests\GetAssetsRequest;
use NicolasKion\Esi\Requests\GetAsteroidBeltRequest;
use NicolasKion\Esi\Requests\GetBloodlinesRequest;
use NicolasKion\Esi\Requests\GetCalendarEventAttendeesRequest;
use NicolasKion\Esi\Requests\GetCalendarEventRequest;
use NicolasKion\Esi\Requests\GetCalendarRequest;
use NicolasKion\Esi\Requests\GetCharacterAttributesRequest;
use NicolasKion\Esi\Requests\GetCharacterBlueprintsRequest;
use NicolasKion\Esi\Requests\GetCharacterClonesRequest;
use NicolasKion\Esi\Requests\GetCharacterContactLabelsRequest;
use NicolasKion\Esi\Requests\GetCharacterContactNotificationsRequest;
use NicolasKion\Esi\Requests\GetCharacterContactsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractBidsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractItemsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractsRequest;
use NicolasKion\Esi\Requests\GetCharacterCorporationHistoryRequest;
use NicolasKion\Esi\Requests\GetCharacterFactionWarfareStatsRequest;
use NicolasKion\Esi\Requests\GetCharacterFatigueRequest;
use NicolasKion\Esi\Requests\GetCharacterFleetRequest;
use NicolasKion\Esi\Requests\GetCharacterImplantsRequest;
use NicolasKion\Esi\Requests\GetCharacterIndustryJobsRequest;
use NicolasKion\Esi\Requests\GetCharacterMedalsRequest;
use NicolasKion\Esi\Requests\GetCharacterMiningRequest;
use NicolasKion\Esi\Requests\GetCharacterNotificationsRequest;
use NicolasKion\Esi\Requests\GetCharacterOrderHistoryRequest;
use NicolasKion\Esi\Requests\GetCharacterOrdersRequest;
use NicolasKion\Esi\Requests\GetCharacterPortraitRequest;
use NicolasKion\Esi\Requests\GetCharacterRecentKillmailsRequest;
use NicolasKion\Esi\Requests\GetCharacterRequest;
use NicolasKion\Esi\Requests\GetCharacterRolesRequest;
use NicolasKion\Esi\Requests\GetCharacterSkillQueueRequest;
use NicolasKion\Esi\Requests\GetCharacterSkillsRequest;
use NicolasKion\Esi\Requests\GetCharacterStandingsRequest;
use NicolasKion\Esi\Requests\GetCharacterTitlesRequest;
use NicolasKion\Esi\Requests\GetConstellationRequest;
use NicolasKion\Esi\Requests\GetCorporationAllianceHistoryRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetLocationsRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetNamesRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetsRequest;
use NicolasKion\Esi\Requests\GetCorporationBlueprintsRequest;
use NicolasKion\Esi\Requests\GetCorporationContactLabelsRequest;
use NicolasKion\Esi\Requests\GetCorporationContactsRequest;
use NicolasKion\Esi\Requests\GetCorporationContainerLogsRequest;
use NicolasKion\Esi\Requests\GetCorporationContractBidsRequest;
use NicolasKion\Esi\Requests\GetCorporationContractItemsRequest;
use NicolasKion\Esi\Requests\GetCorporationContractsRequest;
use NicolasKion\Esi\Requests\GetCorporationCustomsOfficesRequest;
use NicolasKion\Esi\Requests\GetCorporationDivisionsRequest;
use NicolasKion\Esi\Requests\GetCorporationFacilitiesRequest;
use NicolasKion\Esi\Requests\GetCorporationFactionWarfareStatsRequest;
use NicolasKion\Esi\Requests\GetCorporationIconsRequest;
use NicolasKion\Esi\Requests\GetCorporationIndustryJobsRequest;
use NicolasKion\Esi\Requests\GetCorporationIssuedMedalsRequest;
use NicolasKion\Esi\Requests\GetCorporationMedalsRequest;
use NicolasKion\Esi\Requests\GetCorporationMemberLimitRequest;
use NicolasKion\Esi\Requests\GetCorporationMembersRequest;
use NicolasKion\Esi\Requests\GetCorporationMemberTitlesRequest;
use NicolasKion\Esi\Requests\GetCorporationMemberTrackingRequest;
use NicolasKion\Esi\Requests\GetCorporationMiningExtractionsRequest;
use NicolasKion\Esi\Requests\GetCorporationMiningObserverRequest;
use NicolasKion\Esi\Requests\GetCorporationMiningObserversRequest;
use NicolasKion\Esi\Requests\GetCorporationOrderHistoryRequest;
use NicolasKion\Esi\Requests\GetCorporationOrdersRequest;
use NicolasKion\Esi\Requests\GetCorporationRecentKillmailsRequest;
use NicolasKion\Esi\Requests\GetCorporationRequest;
use NicolasKion\Esi\Requests\GetCorporationRolesHistoryRequest;
use NicolasKion\Esi\Requests\GetCorporationRolesRequest;
use NicolasKion\Esi\Requests\GetCorporationShareholdersRequest;
use NicolasKion\Esi\Requests\GetCorporationStandingsRequest;
use NicolasKion\Esi\Requests\GetCorporationStarbaseRequest;
use NicolasKion\Esi\Requests\GetCorporationStarbasesRequest;
use NicolasKion\Esi\Requests\GetCorporationStructuresRequest;
use NicolasKion\Esi\Requests\GetCorporationTitlesRequest;
use NicolasKion\Esi\Requests\GetCorporationWalletJournalRequest;
use NicolasKion\Esi\Requests\GetCorporationWalletsRequest;
use NicolasKion\Esi\Requests\GetCorporationWalletTransactionsRequest;
use NicolasKion\Esi\Requests\GetCspaChargeRequest;
use NicolasKion\Esi\Requests\GetDogmaAttributeRequest;
use NicolasKion\Esi\Requests\GetDogmaAttributesRequest;
use NicolasKion\Esi\Requests\GetDogmaEffectRequest;
use NicolasKion\Esi\Requests\GetDogmaEffectsRequest;
use NicolasKion\Esi\Requests\GetDogmaItemAttributesRequest;
use NicolasKion\Esi\Requests\GetEveMailRequest;
use NicolasKion\Esi\Requests\GetEveMailsRequest;
use NicolasKion\Esi\Requests\GetFactionsRequest;
use NicolasKion\Esi\Requests\GetFactionWarfareCharacterLeaderboardsRequest;
use NicolasKion\Esi\Requests\GetFactionWarfareCorporationLeaderboardsRequest;
use NicolasKion\Esi\Requests\GetFactionWarfareLeaderboardsRequest;
use NicolasKion\Esi\Requests\GetFactionWarfareStatsRequest;
use NicolasKion\Esi\Requests\GetFactionWarfareSystemsRequest;
use NicolasKion\Esi\Requests\GetFactionWarfareWarsRequest;
use NicolasKion\Esi\Requests\GetFittingsRequest;
use NicolasKion\Esi\Requests\GetFleetMembersRequest;
use NicolasKion\Esi\Requests\GetFleetRequest;
use NicolasKion\Esi\Requests\GetFleetWingsRequest;
use NicolasKion\Esi\Requests\GetGraphicRequest;
use NicolasKion\Esi\Requests\GetIdsRequest;
use NicolasKion\Esi\Requests\GetIncursionsRequest;
use NicolasKion\Esi\Requests\GetIndustryFacilitiesRequest;
use NicolasKion\Esi\Requests\GetIndustrySystemsRequest;
use NicolasKion\Esi\Requests\GetInsurancePricesRequest;
use NicolasKion\Esi\Requests\GetKillmailRequest;
use NicolasKion\Esi\Requests\GetLocationRequest;
use NicolasKion\Esi\Requests\GetLoyaltyOffersRequest;
use NicolasKion\Esi\Requests\GetLoyaltyPointsRequest;
use NicolasKion\Esi\Requests\GetMailingListsRequest;
use NicolasKion\Esi\Requests\GetMailLabelsRequest;
use NicolasKion\Esi\Requests\GetMarketGroupRequest;
use NicolasKion\Esi\Requests\GetMarketGroupsRequest;
use NicolasKion\Esi\Requests\GetMarketHistoryRequest;
use NicolasKion\Esi\Requests\GetMarketOrdersRequest;
use NicolasKion\Esi\Requests\GetMarketPricesRequest;
use NicolasKion\Esi\Requests\GetMarketTypesRequest;
use NicolasKion\Esi\Requests\GetMoonRequest;
use NicolasKion\Esi\Requests\GetNamesRequest;
use NicolasKion\Esi\Requests\GetNpcCorporationsRequest;
use NicolasKion\Esi\Requests\GetOnlineRequest;
use NicolasKion\Esi\Requests\GetPlanetLayoutRequest;
use NicolasKion\Esi\Requests\GetPlanetRequest;
use NicolasKion\Esi\Requests\GetPlanetsRequest;
use NicolasKion\Esi\Requests\GetPublicContractBidsRequest;
use NicolasKion\Esi\Requests\GetPublicContractItemsRequest;
use NicolasKion\Esi\Requests\GetPublicContractsRequest;
use NicolasKion\Esi\Requests\GetPublicStructuresRequest;
use NicolasKion\Esi\Requests\GetRacesRequest;
use NicolasKion\Esi\Requests\GetRaidableSkyhooksRequest;
use NicolasKion\Esi\Requests\GetRegionRequest;
use NicolasKion\Esi\Requests\GetRouteRequest;
use NicolasKion\Esi\Requests\GetSchematicRequest;
use NicolasKion\Esi\Requests\GetShipRequest;
use NicolasKion\Esi\Requests\GetSovereigntyRequest;
use NicolasKion\Esi\Requests\GetStargateRequest;
use NicolasKion\Esi\Requests\GetStarRequest;
use NicolasKion\Esi\Requests\GetStationRequest;
use NicolasKion\Esi\Requests\GetStructureMarketOrdersRequest;
use NicolasKion\Esi\Requests\GetStructureRequest;
use NicolasKion\Esi\Requests\GetSystemJumpsRequest;
use NicolasKion\Esi\Requests\GetSystemKillsRequest;
use NicolasKion\Esi\Requests\GetSystemRequest;
use NicolasKion\Esi\Requests\GetUniverseCategoriesRequest;
use NicolasKion\Esi\Requests\GetUniverseCategoryRequest;
use NicolasKion\Esi\Requests\GetUniverseConstellationsRequest;
use NicolasKion\Esi\Requests\GetUniverseGraphicsRequest;
use NicolasKion\Esi\Requests\GetUniverseGroupRequest;
use NicolasKion\Esi\Requests\GetUniverseGroupsRequest;
use NicolasKion\Esi\Requests\GetUniverseRegionsRequest;
use NicolasKion\Esi\Requests\GetUniverseSystemsRequest;
use NicolasKion\Esi\Requests\GetUniverseTypeRequest;
use NicolasKion\Esi\Requests\GetUniverseTypesRequest;
use NicolasKion\Esi\Requests\GetWalletBalanceRequest;
use NicolasKion\Esi\Requests\GetWalletJournalRequest;
use NicolasKion\Esi\Requests\GetWalletTransactionsRequest;
use NicolasKion\Esi\Requests\GetWarKillmailsRequest;
use NicolasKion\Esi\Requests\GetWarRequest;
use NicolasKion\Esi\Requests\GetWarsRequest;
use NicolasKion\Esi\Requests\InviteFleetMemberRequest;
use NicolasKion\Esi\Requests\KickFleetMemberRequest;
use NicolasKion\Esi\Requests\MoveFleetMemberRequest;
use NicolasKion\Esi\Requests\OpenContractRequest;
use NicolasKion\Esi\Requests\OpenInformationWindowRequest;
use NicolasKion\Esi\Requests\OpenMarketDetailsWindowRequest;
use NicolasKion\Esi\Requests\OpenNewMailWindowRequest;
use NicolasKion\Esi\Requests\RenameFleetSquadRequest;
use NicolasKion\Esi\Requests\RenameFleetWingRequest;
use NicolasKion\Esi\Requests\RespondToCalendarEventRequest;
use NicolasKion\Esi\Requests\SendMailRequest;
use NicolasKion\Esi\Requests\UpdateEveMailRequest;
use NicolasKion\Esi\Requests\UpdateFleetRequest;

class Esi
{
    /**
     * Retrieves public contracts for a given region.
     *
     * @param  int  $region_id  The ID of the region.
     * @return EsiResult<array<int, PublicContract>> Returns an instance of EsiResult that contains the retrieved public contracts.
     */
    public function getPublicContracts(int $region_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetPublicContractsRequest($region_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves public contract items for a given contract.
     *
     * @param  int  $contract_id  The ID of the contract.
     * @return EsiResult<array<int, PublicContractItem>> Returns an instance of EsiResult that contains the retrieved public contract items.
     */
    public function getPublicContractItems(int $contract_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetPublicContractItemsRequest($contract_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves public contract bids for a given contract.
     *
     * @param  int  $contract_id  The ID of the contract.
     * @return EsiResult<array<int, PublicContractBid>> Returns an instance of EsiResult that contains the retrieved public contract bids.
     */
    public function getPublicContractBids(int $contract_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetPublicContractBidsRequest($contract_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves character affiliations for a given list of IDs.
     *
     * @param  array<int>  $ids  The list of IDs.
     * @return EsiResult<array<int, CharacterAffiliation>> Returns an instance of EsiResult that contains the retrieved character affiliations.
     */
    public function getAffiliations(array $ids): EsiResult
    {
        $connector = new Connector;
        $request = new GetAffiliationsRequest($ids);

        return $connector->send($request);
    }

    /**
     * Retrieves dogma item attributes for a given type and item ID.
     *
     * @param  int  $type_id  The type ID.
     * @param  int  $item_id  The item ID.
     * @return EsiResult<DogmaItem> Returns an instance of EsiResult that contains the retrieved dogma item attributes.
     */
    public function getDogmaItem(int $type_id, int $item_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetDogmaItemAttributesRequest($type_id, $item_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of dogma attribute IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getDogmaAttributes(): EsiResult
    {
        $connector = new Connector;
        $request = new GetDogmaAttributesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a dogma attribute.
     *
     * @return EsiResult<DogmaAttribute>
     */
    public function getDogmaAttribute(int $attribute_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetDogmaAttributeRequest($attribute_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of dogma effect IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getDogmaEffects(): EsiResult
    {
        $connector = new Connector;
        $request = new GetDogmaEffectsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a dogma effect.
     *
     * @return EsiResult<DogmaEffect>
     */
    public function getDogmaEffect(int $effect_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetDogmaEffectRequest($effect_id);

        return $connector->send($request);
    }

    /**
     * Retrieves market history for a given region and type ID.
     *
     * @param  int  $region_id  The ID of the region.
     * @param  int  $type_id  The type ID.
     * @return EsiResult<array<int, MarketHistory>> Returns an instance of EsiResult that contains the retrieved market history.
     */
    public function getMarketHistory(int $region_id, int $type_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketHistoryRequest($region_id, $type_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of market group IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getMarketGroups(): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketGroupsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a market group.
     *
     * @return EsiResult<MarketGroup>
     */
    public function getMarketGroup(int $market_group_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketGroupRequest($market_group_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the adjusted and average prices for all types.
     *
     * @return EsiResult<array<int, MarketPrice>>
     */
    public function getMarketPrices(): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketPricesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves market orders in a region, optionally filtered by type.
     *
     * @return EsiResult<array<int, MarketOrder>>
     */
    public function getMarketOrders(int $region_id, MarketOrderType $order_type = MarketOrderType::All, ?int $type_id = null): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketOrdersRequest($region_id, $order_type, $type_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the type IDs with active market orders in a region.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getMarketTypes(int $region_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketTypesRequest($region_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves market orders in a player-owned structure.
     *
     * @return EsiResult<array<int, MarketOrder>>
     */
    public function getStructureMarketOrders(Character $character, int $structure_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadMarketStructures);
        $request = new GetStructureMarketOrdersRequest($structure_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the open market orders placed by a character.
     *
     * @return EsiResult<array<int, PersonalMarketOrder>>
     */
    public function getCharacterOrders(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterOrders);
        $request = new GetCharacterOrdersRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the cancelled and expired market orders placed by a character (up to 90 days in the past).
     *
     * @return EsiResult<array<int, PersonalMarketOrderHistory>>
     */
    public function getCharacterOrderHistory(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterOrders);
        $request = new GetCharacterOrderHistoryRequest($character->getId());

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the open market orders placed on behalf of a corporation.
     *
     * @return EsiResult<array<int, PersonalMarketOrder>>
     */
    public function getCorporationOrders(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationOrders);
        $request = new GetCorporationOrdersRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the cancelled and expired market orders placed on behalf of a corporation (up to 90 days in the past).
     *
     * @return EsiResult<array<int, PersonalMarketOrderHistory>>
     */
    public function getCorporationOrderHistory(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationOrders);
        $request = new GetCorporationOrderHistoryRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves names for a given list of IDs.
     *
     * @param  array<int>  $ids  The list of IDs.
     * @return EsiResult<array<int, Name>> Returns an instance of EsiResult that contains the retrieved names.
     */
    public function getNames(array $ids): EsiResult
    {
        $connector = new Connector;
        $request = new GetNamesRequest($ids);

        return $connector->send($request);
    }

    /**
     * Resolves a list of names to IDs, grouped by category.
     *
     * Only exact matches are returned. Names are limited to 500 per request by ESI.
     *
     * @param  array<string>  $names  The list of names to resolve.
     * @return EsiResult<UniverseIds> Returns an instance of EsiResult that contains the resolved IDs.
     */
    public function getIds(array $names): EsiResult
    {
        $connector = new Connector;
        $request = new GetIdsRequest($names);

        return $connector->send($request);
    }

    /**
     * Retrieves public structures.
     *
     * @return EsiResult<array<int, int>> Returns an instance of EsiResult that contains the retrieved public structures.
     */
    public function getPublicStructures(): EsiResult
    {
        $connector = new Connector;
        $request = new GetPublicStructuresRequest;

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves structure information for a given structure ID.
     *
     * @param  int  $structure_id  The structure ID.
     * @return EsiResult<Structure> Returns an instance of EsiResult that contains the retrieved structure information.
     */
    public function getStructure(Character $character, int $structure_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadStructures);
        $request = new GetStructureRequest($structure_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the wallet journal for a given character.
     *
     * @return EsiResult<array<int, WalletJournalEntry>> Returns an instance of EsiResult that contains the retrieved wallet journal.
     */
    public function getWalletJournal(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadWallet);
        $request = new GetWalletJournalRequest($character->getId());

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the wallet balance for a given character.
     *
     * @return EsiResult<float> Returns an instance of EsiResult that contains the retrieved wallet balance.
     */
    public function getWalletBalance(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadWallet);
        $request = new GetWalletBalanceRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the wallet transactions for a given character.
     *
     * @param  int|null  $from_id  Only fetch transactions happened before this transaction ID.
     * @return EsiResult<array<int, WalletTransaction>> Returns an instance of EsiResult that contains the retrieved wallet transactions.
     */
    public function getWalletTransactions(Character $character, ?int $from_id = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadWallet);
        $request = new GetWalletTransactionsRequest($character->getId(), $from_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the wallets of a corporation.
     *
     * @return EsiResult<array<int, CorporationWallet>> Returns an instance of EsiResult that contains the retrieved corporation wallets.
     */
    public function getCorporationWallets(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationWallets);
        $request = new GetCorporationWalletsRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the wallet journal of a corporation division.
     *
     * @return EsiResult<array<int, WalletJournalEntry>> Returns an instance of EsiResult that contains the retrieved corporation wallet journal.
     */
    public function getCorporationWalletJournal(Character $character, int $corporation_id, int $division): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationWallets);
        $request = new GetCorporationWalletJournalRequest($corporation_id, $division);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the wallet transactions of a corporation division.
     *
     * @param  int|null  $from_id  Only fetch transactions happened before this transaction ID.
     * @return EsiResult<array<int, WalletTransaction>> Returns an instance of EsiResult that contains the retrieved corporation wallet transactions.
     */
    public function getCorporationWalletTransactions(Character $character, int $corporation_id, int $division, ?int $from_id = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationWallets);
        $request = new GetCorporationWalletTransactionsRequest($corporation_id, $division, $from_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the EVE mails for a given character.
     *
     * @return EsiResult<array<int, EveMail>> Returns an instance of EsiResult that contains the retrieved EVE mails.
     */
    public function getEveMails(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadMail);
        $request = new GetEveMailsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves an EVE mail for a given character and mail ID.
     *
     * @return EsiResult<EveMail>
     */
    public function getEveMail(Character $character, int $mail_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadMail);
        $request = new GetEveMailRequest($character->getId(), $mail_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the assets for a given character.
     *
     * @return EsiResult<array<int, Asset>>
     */
    public function getAssets(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadAssets);
        $request = new GetAssetsRequest($character->getId());

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the asset names for a given character.
     *
     * @param  array<int>  $ids
     * @return EsiResult<array<int, AssetName>>
     */
    public function getAssetNames(Character $character, array $ids): EsiResult
    {
        /** @var array<int, AssetName> $names */
        $names = [];

        if ($ids === []) {
            return new EsiResult(data: $names);
        }

        $chunks = array_chunk($ids, 1000);

        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadAssets);

        // Maximum of 1000 IDs per request, so we need to chunk the array
        foreach ($chunks as $chunk) {
            $request = new GetAssetNamesRequest($character->getId(), $chunk);
            $result = $connector->send($request);
            if ($result->failed()) {
                return $result;
            }

            $names = [...$names, ...$result->data];
        }

        return new EsiResult(data: $names);
    }

    /**
     * Retrieves the corporation assets for a given character.
     *
     * @return EsiResult<array<int, Asset>>
     */
    public function getCorporationAssets(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationAssets);
        $request = new GetCorporationAssetsRequest($character->getCorporationId());

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the corporation asset names for a given character.
     *
     * @param  array<int>  $ids
     * @return EsiResult<array<int, AssetName>>
     */
    public function getCorporationAssetNames(Character $character, array $ids): EsiResult
    {

        /** @var array<int, AssetName> $names */
        $names = [];

        if ($ids === []) {
            return new EsiResult(data: $names);
        }

        if (count($ids) > 1000) {
            $results = collect(array_chunk($ids, 1000))->map(function ($chunk) use ($character) {
                return $this->getCorporationAssetNames($character, $chunk);
            });

            $names = $results->flatMap(fn (EsiResult $result) => $result->data)->all();

            return new EsiResult(data: $names);
        }

        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationAssets);
        $request = new GetCorporationAssetNamesRequest($character->getCorporationId(), $ids);
        $response = $connector->send($request);

        if (str_contains($response->error->body ?? '', 'Invalid IDs in the request')) {
            if (count($ids) === 1) {
                return new EsiResult(data: $names);
            }

            // Split in two and try again
            $half = (int) ceil(count($ids) / 2);
            $first = array_slice($ids, 0, $half);
            $second = array_slice($ids, $half);

            $first_result = $this->getCorporationAssetNames($character, $first);
            $second_result = $this->getCorporationAssetNames($character, $second);

            $names = [...$first_result->data, ...$second_result->data];

            return new EsiResult(data: $names);
        }

        return $response;
    }

    /**
     * Retrieves the locations of a set of a character's assets.
     *
     * @param  array<int, int>  $item_ids
     * @return EsiResult<array<int, AssetLocation>>
     */
    public function getAssetLocations(Character $character, array $item_ids): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadAssets);
        $request = new GetAssetLocationsRequest($character->getId(), $item_ids);

        return $connector->send($request);
    }

    /**
     * Retrieves the locations of a set of a corporation's assets.
     *
     * @param  array<int, int>  $item_ids
     * @return EsiResult<array<int, AssetLocation>>
     */
    public function getCorporationAssetLocations(Character $character, int $corporation_id, array $item_ids): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationAssets);
        $request = new GetCorporationAssetLocationsRequest($corporation_id, $item_ids);

        return $connector->send($request);
    }

    /**
     * Retrieves a character by ID.
     *
     * @return EsiResult<DTO\Character>
     */
    public function getCharacter(int $character_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCharacterRequest($character_id);

        return $connector->send($request);
    }

    /**
     * Opens a contract in the EVE Online client.
     *
     * @return EsiResult<null>
     */
    public function openContract(Character $character, int $contract_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OpenWindow);
        $request = new OpenContractRequest($contract_id);

        return $connector->send($request);
    }

    /**
     * Sends a mail to a character.
     *
     * @param  array<int, array<string, mixed>>  $recipients
     * @return EsiResult<int>
     */
    public function sendMail(Character $character, array $recipients, string $subject, string $body): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::SendMail);

        return $connector->send(new SendMailRequest($character->getId(), $recipients, $subject, $body));
    }

    /**
     * Retrieves the contracts for a given character.
     *
     * @return EsiResult<array<int, CharacterContract>>
     */
    public function getCharacterContracts(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadContracts);

        return $connector->sendPaginated(new GetCharacterContractsRequest($character->getId()));
    }

    /**
     * Retrieves the contract items for a given character and contract.
     *
     * @return EsiResult<array<int, PublicContractItem>>
     */
    public function getCharacterContractItems(Character $character, int $contract_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadContracts);

        return $connector->sendPaginated(new GetCharacterContractItemsRequest($character->getId(), $contract_id));
    }

    /**
     * Retrieves the bids for a given character and auction contract.
     *
     * @return EsiResult<array<int, ContractBid>>
     */
    public function getCharacterContractBids(Character $character, int $contract_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadContracts);

        return $connector->send(new GetCharacterContractBidsRequest($character->getId(), $contract_id));
    }

    /**
     * Retrieves the contracts for a given corporation.
     *
     * @return EsiResult<array<int, CharacterContract>>
     */
    public function getCorporationContracts(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationContracts);

        return $connector->sendPaginated(new GetCorporationContractsRequest($corporation_id));
    }

    /**
     * Retrieves the contract items for a given corporation and contract.
     *
     * @return EsiResult<array<int, PublicContractItem>>
     */
    public function getCorporationContractItems(Character $character, int $corporation_id, int $contract_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationContracts);

        return $connector->send(new GetCorporationContractItemsRequest($corporation_id, $contract_id));
    }

    /**
     * Retrieves the bids for a given corporation and auction contract.
     *
     * @return EsiResult<array<int, ContractBid>>
     */
    public function getCorporationContractBids(Character $character, int $corporation_id, int $contract_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationContracts);

        return $connector->sendPaginated(new GetCorporationContractBidsRequest($corporation_id, $contract_id));
    }

    /**
     * Retrieves corporation details
     *
     * @return EsiResult<Corporation>
     */
    public function getCorporation(int $corporation_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCorporationRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves corporation division names (hangar and wallet).
     *
     * @return EsiResult<CorporationDivisions>
     */
    public function getCorporationDivisions(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationDivisions);
        $request = new GetCorporationDivisionsRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves corporation structures.
     *
     * @return EsiResult<array<int, CorporationStructure>>
     */
    public function getCorporationStructures(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationStructures);
        $request = new GetCorporationStructuresRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves alliance details
     *
     * @return EsiResult<Alliance>
     */
    public function getAlliance(int $id): EsiResult
    {
        $connector = new Connector;
        $request = new GetAllianceRequest($id);

        return $connector->send($request);
    }

    /**
     * Retrieves all alliances
     *
     * @return EsiResult<array<int, int>>
     */
    public function getAlliances(): EsiResult
    {
        $connector = new Connector;
        $request = new GetAlliancesRequest;

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the corporation IDs of the members of an alliance.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getAllianceCorporations(int $alliance_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetAllianceCorporationsRequest($alliance_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the icon URLs for an alliance.
     *
     * @return EsiResult<AllianceIcons>
     */
    public function getAllianceIcons(int $alliance_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetAllianceIconsRequest($alliance_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the contacts for a given character.
     *
     * @return EsiResult<array<int, Contact>>
     */
    public function getCharacterContacts(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterContacts);

        return $connector->sendPaginated(new GetCharacterContactsRequest($character->getId()));
    }

    /**
     * Retrieves the contact labels for a given character.
     *
     * @return EsiResult<array<int, ContactLabel>>
     */
    public function getCharacterContactLabels(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterContacts);

        return $connector->send(new GetCharacterContactLabelsRequest($character->getId()));
    }

    /**
     * Adds contacts for a given character.
     *
     * @param  int[]  $contact_ids  The contacts to add (1-100 entries).
     * @param  float  $standing  The standing to assign (-10 to 10).
     * @param  int[]|null  $label_ids  Optional labels to apply to the new contacts.
     * @param  bool  $watched  Whether the contacts should be watched (characters only).
     * @return EsiResult<array<int, int>> The IDs of the contacts that were added.
     */
    public function addCharacterContacts(Character $character, array $contact_ids, float $standing, ?array $label_ids = null, bool $watched = false): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteCharacterContacts);

        return $connector->send(new AddCharacterContactsRequest($character->getId(), $contact_ids, $standing, $label_ids, $watched));
    }

    /**
     * Edits contacts for a given character.
     *
     * @param  int[]  $contact_ids  The contacts to edit (1-100 entries).
     * @param  float  $standing  The standing to assign (-10 to 10).
     * @param  int[]|null  $label_ids  Optional labels to apply to the contacts.
     * @param  bool  $watched  Whether the contacts should be watched (characters only).
     * @return EsiResult<null>
     */
    public function editCharacterContacts(Character $character, array $contact_ids, float $standing, ?array $label_ids = null, bool $watched = false): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteCharacterContacts);

        return $connector->send(new EditCharacterContactsRequest($character->getId(), $contact_ids, $standing, $label_ids, $watched));
    }

    /**
     * Deletes contacts for a given character.
     *
     * @param  int[]  $contact_ids  The contacts to delete.
     * @return EsiResult<null>
     */
    public function deleteCharacterContacts(Character $character, array $contact_ids): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteCharacterContacts);

        return $connector->send(new DeleteCharacterContactsRequest($character->getId(), $contact_ids));
    }

    /**
     * Retrieves the contacts for a given corporation.
     *
     * @return EsiResult<array<int, Contact>>
     */
    public function getCorporationContacts(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationContacts);

        return $connector->sendPaginated(new GetCorporationContactsRequest($corporation_id));
    }

    /**
     * Retrieves the contact labels for a given corporation.
     *
     * @return EsiResult<array<int, ContactLabel>>
     */
    public function getCorporationContactLabels(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationContacts);

        return $connector->send(new GetCorporationContactLabelsRequest($corporation_id));
    }

    /**
     * Retrieves the contacts for a given alliance.
     *
     * @return EsiResult<array<int, Contact>>
     */
    public function getAllianceContacts(Character $character, int $alliance_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadAllianceContacts);

        return $connector->sendPaginated(new GetAllianceContactsRequest($alliance_id));
    }

    /**
     * Retrieves the contact labels for a given alliance.
     *
     * @return EsiResult<array<int, ContactLabel>>
     */
    public function getAllianceContactLabels(Character $character, int $alliance_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadAllianceContacts);

        return $connector->send(new GetAllianceContactLabelsRequest($alliance_id));
    }

    /**
     * Updates an EVE mail
     *
     * @param  array<int, int>|null  $labels
     * @return EsiResult<null>
     */
    public function updateEveMail(Character $character, int $mail_id, bool $read = true, ?array $labels = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OrganizeMail);
        $request = new UpdateEveMailRequest($character->getId(), $mail_id, $read, $labels);

        return $connector->send($request);
    }

    /**
     * Retrieves the mail labels and unread counts for a given character.
     *
     * @return EsiResult<MailLabels>
     */
    public function getMailLabels(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadMail);
        $request = new GetMailLabelsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the mailing lists a given character is subscribed to.
     *
     * @return EsiResult<array<int, MailingList>>
     */
    public function getMailingLists(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadMail);
        $request = new GetMailingListsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Creates a mail label for a given character.
     *
     * @return EsiResult<int> Returns an instance of EsiResult that contains the new label's ID.
     */
    public function createMailLabel(Character $character, string $name, ?string $color = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OrganizeMail);
        $request = new CreateMailLabelRequest($character->getId(), $name, $color);

        return $connector->send($request);
    }

    /**
     * Deletes a mail label for a given character.
     *
     * @return EsiResult<null>
     */
    public function deleteMailLabel(Character $character, int $label_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OrganizeMail);
        $request = new DeleteMailLabelRequest($character->getId(), $label_id);

        return $connector->send($request);
    }

    /**
     * Deletes a mail for a given character.
     *
     * @return EsiResult<null>
     */
    public function deleteMail(Character $character, int $mail_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OrganizeMail);
        $request = new DeleteMailRequest($character->getId(), $mail_id);

        return $connector->send($request);
    }

    /**
     * Retrieve a War
     *
     * @return EsiResult<War>
     */
    public function getWar(int $war_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetWarRequest($war_id);

        return $connector->send($request);
    }

    /**
     * Retrieve a list of wars, optionally only those with an ID smaller than max_war_id.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getWars(?int $max_war_id = null): EsiResult
    {
        $connector = new Connector;
        $request = new GetWarsRequest($max_war_id);

        return $connector->send($request);
    }

    /**
     * Retrieve the killmails related to a war.
     *
     * @return EsiResult<array<int, KillmailRef>>
     */
    public function getWarKillmails(int $war_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetWarKillmailsRequest($war_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Get character location
     *
     * @return EsiResult<Location>
     */
    public function getLocation(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadLocations);
        $request = new GetLocationRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get character online status
     *
     * @return EsiResult<Online>
     */
    public function getOnline(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadOnlineStatus);
        $request = new GetOnlineRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get character ship
     *
     * @return EsiResult<Ship>
     */
    public function getShip(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadShip);
        $request = new GetShipRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get the sovereignty of all systems
     *
     * @return EsiResult<array<int, Sovereignty>>
     */
    public function getSovereignty(): EsiResult
    {
        $connector = new Connector;
        $request = new GetSovereigntyRequest;

        return $connector->send($request);
    }

    /**
     * Get a killmail
     *
     * @return EsiResult<Killmail>
     */
    public function getKillmail(int $killmail_id, string $killmail_hash): EsiResult
    {
        $connector = new Connector;
        $request = new GetKillmailRequest($killmail_id, $killmail_hash);

        return $connector->send($request);
    }

    /**
     * Retrieves a character's recent kills and losses (last 90 days).
     *
     * @return EsiResult<array<int, KillmailRef>>
     */
    public function getCharacterRecentKillmails(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadKillmails);

        return $connector->sendPaginated(new GetCharacterRecentKillmailsRequest($character->getId()));
    }

    /**
     * Retrieves a corporation's recent kills and losses (last 90 days).
     *
     * @return EsiResult<array<int, KillmailRef>>
     */
    public function getCorporationRecentKillmails(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationKillmails);

        return $connector->sendPaginated(new GetCorporationRecentKillmailsRequest($corporation_id));
    }

    /**
     * Set a waypoint for a character
     *
     * @return EsiResult<null>
     */
    public function setWaypoint(Character $character, int $destination_id, bool $add_to_beginning = false, bool $clear_other_waypoints = false): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteWaypoint);
        $request = new Requests\SetWaypointRequest(
            character_id: $character->getId(),
            destination_id: $destination_id,
            add_to_beginning: $add_to_beginning,
            clear_other_waypoints: $clear_other_waypoints
        );

        return $connector->send($request);
    }

    /**
     * Retrieves a listing of all Skyhooks that currently or will shortly be raidable.
     *
     * @return EsiResult<array<int, RaidableSkyhook>>
     */
    public function getRaidableSkyhooks(): EsiResult
    {
        $connector = new Connector;
        $request = new GetRaidableSkyhooksRequest;

        return $connector->send($request);
    }

    /**
     * Get the current status of the EVE Online server.
     *
     * @return EsiResult<Status>
     */
    public function getStatus(): EsiResult
    {
        $connector = new Connector;
        $request = new Requests\GetStatusRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the list of category IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseCategories(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseCategoriesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a category.
     *
     * @return EsiResult<UniverseCategory>
     */
    public function getUniverseCategory(int $category_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseCategoryRequest($category_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of group IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseGroups(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseGroupsRequest;

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves information about a group.
     *
     * @return EsiResult<UniverseGroup>
     */
    public function getUniverseGroup(int $group_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseGroupRequest($group_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of type IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseTypes(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseTypesRequest;

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves information about a type.
     *
     * @return EsiResult<UniverseType>
     */
    public function getUniverseType(int $type_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseTypeRequest($type_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of constellation IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseConstellations(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseConstellationsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a constellation.
     *
     * @return EsiResult<Constellation>
     */
    public function getConstellation(int $constellation_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetConstellationRequest($constellation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of graphic IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseGraphics(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseGraphicsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a graphic.
     *
     * @return EsiResult<Graphic>
     */
    public function getGraphic(int $graphic_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetGraphicRequest($graphic_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of region IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseRegions(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseRegionsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a region.
     *
     * @return EsiResult<Region>
     */
    public function getRegion(int $region_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetRegionRequest($region_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of solar system IDs.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getUniverseSystems(): EsiResult
    {
        $connector = new Connector;
        $request = new GetUniverseSystemsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves information about a solar system.
     *
     * @return EsiResult<System>
     */
    public function getSystem(int $system_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetSystemRequest($system_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about a station.
     *
     * @return EsiResult<Station>
     */
    public function getStation(int $station_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetStationRequest($station_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about a stargate.
     *
     * @return EsiResult<Stargate>
     */
    public function getStargate(int $stargate_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetStargateRequest($stargate_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about a star.
     *
     * @return EsiResult<Star>
     */
    public function getStar(int $star_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetStarRequest($star_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about a planet.
     *
     * @return EsiResult<Planet>
     */
    public function getPlanet(int $planet_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetPlanetRequest($planet_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about a moon.
     *
     * @return EsiResult<Moon>
     */
    public function getMoon(int $moon_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetMoonRequest($moon_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about an asteroid belt.
     *
     * @return EsiResult<AsteroidBelt>
     */
    public function getAsteroidBelt(int $asteroid_belt_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetAsteroidBeltRequest($asteroid_belt_id);

        return $connector->send($request);
    }

    /**
     * Retrieves information about a schematic.
     *
     * @return EsiResult<Schematic>
     */
    public function getSchematic(int $schematic_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetSchematicRequest($schematic_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the list of character ancestries.
     *
     * @return EsiResult<array<int, Ancestry>>
     */
    public function getAncestries(): EsiResult
    {
        $connector = new Connector;
        $request = new GetAncestriesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the list of character bloodlines.
     *
     * @return EsiResult<array<int, Bloodline>>
     */
    public function getBloodlines(): EsiResult
    {
        $connector = new Connector;
        $request = new GetBloodlinesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the list of factions.
     *
     * @return EsiResult<array<int, Faction>>
     */
    public function getFactions(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the list of character races.
     *
     * @return EsiResult<array<int, Race>>
     */
    public function getRaces(): EsiResult
    {
        $connector = new Connector;
        $request = new GetRacesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the number of jumps per solar system, as seen in the last hour.
     *
     * @return EsiResult<array<int, SystemJumps>>
     */
    public function getSystemJumps(): EsiResult
    {
        $connector = new Connector;
        $request = new GetSystemJumpsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the number of ship, pod, and NPC kills per solar system, as seen in the last hour.
     *
     * @return EsiResult<array<int, SystemKills>>
     */
    public function getSystemKills(): EsiResult
    {
        $connector = new Connector;
        $request = new GetSystemKillsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the IDs of NPC corporations.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getNpcCorporations(): EsiResult
    {
        $connector = new Connector;
        $request = new GetNpcCorporationsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the alliance history of a corporation.
     *
     * @return EsiResult<array<int, AllianceHistory>>
     */
    public function getCorporationAllianceHistory(int $corporation_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCorporationAllianceHistoryRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the icon URLs for a corporation.
     *
     * @return EsiResult<CorporationIcons>
     */
    public function getCorporationIcons(int $corporation_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCorporationIconsRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the blueprints owned by a corporation.
     *
     * @return EsiResult<array<int, Blueprint>>
     */
    public function getCorporationBlueprints(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationBlueprints);
        $request = new GetCorporationBlueprintsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the recent access logs of a corporation's audit log secure containers.
     *
     * @return EsiResult<array<int, ContainerLog>>
     */
    public function getCorporationContainerLogs(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationContainerLogs);
        $request = new GetCorporationContainerLogsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves a corporation's facilities.
     *
     * @return EsiResult<array<int, Facility>>
     */
    public function getCorporationFacilities(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationFacilities);
        $request = new GetCorporationFacilitiesRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the medals of a corporation.
     *
     * @return EsiResult<array<int, CorporationMedal>>
     */
    public function getCorporationMedals(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMedals);
        $request = new GetCorporationMedalsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the medals issued by a corporation.
     *
     * @return EsiResult<array<int, IssuedMedal>>
     */
    public function getCorporationIssuedMedals(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMedals);
        $request = new GetCorporationIssuedMedalsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the member character IDs of a corporation.
     *
     * @return EsiResult<array<int, int>>
     */
    public function getCorporationMembers(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMembership);
        $request = new GetCorporationMembersRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the member limit of a corporation.
     *
     * @return EsiResult<int>
     */
    public function getCorporationMemberLimit(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::TrackCorporationMembers);
        $request = new GetCorporationMemberLimitRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the titles held by each member of a corporation.
     *
     * @return EsiResult<array<int, MemberTitles>>
     */
    public function getCorporationMemberTitles(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationTitles);
        $request = new GetCorporationMemberTitlesRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the membertracking information of a corporation.
     *
     * @return EsiResult<array<int, MemberTracking>>
     */
    public function getCorporationMemberTracking(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::TrackCorporationMembers);
        $request = new GetCorporationMemberTrackingRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the roles of each member of a corporation.
     *
     * @return EsiResult<array<int, CorporationRoles>>
     */
    public function getCorporationRoles(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMembership);
        $request = new GetCorporationRolesRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the role change history of a corporation's members.
     *
     * @return EsiResult<array<int, RoleHistory>>
     */
    public function getCorporationRolesHistory(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMembership);
        $request = new GetCorporationRolesHistoryRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the shareholders of a corporation.
     *
     * @return EsiResult<array<int, Shareholder>>
     */
    public function getCorporationShareholders(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationWallets);
        $request = new GetCorporationShareholdersRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the standings of a corporation.
     *
     * @return EsiResult<array<int, Standing>>
     */
    public function getCorporationStandings(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationStandings);
        $request = new GetCorporationStandingsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the starbases (POSes) of a corporation.
     *
     * @return EsiResult<array<int, Starbase>>
     */
    public function getCorporationStarbases(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationStarbases);
        $request = new GetCorporationStarbasesRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves detailed settings for a corporation starbase (POS).
     *
     * @return EsiResult<StarbaseDetail>
     */
    public function getCorporationStarbase(Character $character, int $corporation_id, int $starbase_id, int $system_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationStarbases);
        $request = new GetCorporationStarbaseRequest($corporation_id, $starbase_id, $system_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the member titles of a corporation.
     *
     * @return EsiResult<array<int, CorporationTitle>>
     */
    public function getCorporationTitles(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationTitles);
        $request = new GetCorporationTitlesRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the corporation history of a character.
     *
     * @return EsiResult<array<int, CorporationHistory>>
     */
    public function getCharacterCorporationHistory(int $character_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCharacterCorporationHistoryRequest($character_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the portrait URLs of a character.
     *
     * @return EsiResult<CharacterPortrait>
     */
    public function getCharacterPortrait(int $character_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCharacterPortraitRequest($character_id);

        return $connector->send($request);
    }

    /**
     * Retrieves a character's agents research progress.
     *
     * @return EsiResult<array<int, AgentResearch>>
     */
    public function getAgentsResearch(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadAgentsResearch);
        $request = new GetAgentsResearchRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the blueprints owned by a character.
     *
     * @return EsiResult<array<int, Blueprint>>
     */
    public function getCharacterBlueprints(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterBlueprints);
        $request = new GetCharacterBlueprintsRequest($character->getId());

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves a character's jump fatigue.
     *
     * @return EsiResult<JumpFatigue>
     */
    public function getCharacterFatigue(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadFatigue);
        $request = new GetCharacterFatigueRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the medals of a character.
     *
     * @return EsiResult<array<int, CharacterMedal>>
     */
    public function getCharacterMedals(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterMedals);
        $request = new GetCharacterMedalsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the notifications of a character.
     *
     * @return EsiResult<array<int, Notification>>
     */
    public function getCharacterNotifications(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadNotifications);
        $request = new GetCharacterNotificationsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the contact notifications of a character.
     *
     * @return EsiResult<array<int, ContactNotification>>
     */
    public function getCharacterContactNotifications(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadNotifications);
        $request = new GetCharacterContactNotificationsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the corporation roles of a character.
     *
     * @return EsiResult<CharacterRoles>
     */
    public function getCharacterRoles(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterCorporationRoles);
        $request = new GetCharacterRolesRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the standings of a character.
     *
     * @return EsiResult<array<int, Standing>>
     */
    public function getCharacterStandings(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterStandings);
        $request = new GetCharacterStandingsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the titles of a character.
     *
     * @return EsiResult<array<int, CharacterTitle>>
     */
    public function getCharacterTitles(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterTitles);
        $request = new GetCharacterTitlesRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Calculates the CSPA charge cost for contacting a set of characters.
     *
     * @param  array<int, int>  $character_ids
     * @return EsiResult<float>
     */
    public function getCspaCharge(Character $character, array $character_ids): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterContacts);
        $request = new GetCspaChargeRequest($character->getId(), $character_ids);

        return $connector->send($request);
    }

    /**
     * Retrieves the faction warfare leaderboard of factions.
     *
     * @return EsiResult<FactionWarfareLeaderboard>
     */
    public function getFactionWarfareLeaderboards(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionWarfareLeaderboardsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the faction warfare leaderboard of characters.
     *
     * @return EsiResult<FactionWarfareCharacterLeaderboard>
     */
    public function getFactionWarfareCharacterLeaderboards(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionWarfareCharacterLeaderboardsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the faction warfare leaderboard of corporations.
     *
     * @return EsiResult<FactionWarfareCorporationLeaderboard>
     */
    public function getFactionWarfareCorporationLeaderboards(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionWarfareCorporationLeaderboardsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves faction warfare statistics for every faction.
     *
     * @return EsiResult<array<int, FactionWarfareFactionStats>>
     */
    public function getFactionWarfareStats(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionWarfareStatsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves faction warfare occupancy details for every solar system.
     *
     * @return EsiResult<array<int, FactionWarfareSystem>>
     */
    public function getFactionWarfareSystems(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionWarfareSystemsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the ongoing faction warfare wars.
     *
     * @return EsiResult<array<int, FactionWarfareWar>>
     */
    public function getFactionWarfareWars(): EsiResult
    {
        $connector = new Connector;
        $request = new GetFactionWarfareWarsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves faction warfare statistics for a given character.
     *
     * @return EsiResult<CharacterFactionWarfareStats>
     */
    public function getCharacterFactionWarfareStats(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterFwStats);
        $request = new GetCharacterFactionWarfareStatsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves faction warfare statistics for a given corporation.
     *
     * @return EsiResult<CorporationFactionWarfareStats>
     */
    public function getCorporationFactionWarfareStats(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationFwStats);
        $request = new GetCorporationFactionWarfareStatsRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the current incursions.
     *
     * @return EsiResult<array<int, Incursion>>
     */
    public function getIncursions(): EsiResult
    {
        $connector = new Connector;
        $request = new GetIncursionsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves insurance prices for all ship types.
     *
     * @return EsiResult<array<int, InsurancePrice>>
     */
    public function getInsurancePrices(): EsiResult
    {
        $connector = new Connector;
        $request = new GetInsurancePricesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the loyalty store offers of a corporation.
     *
     * @return EsiResult<array<int, LoyaltyOffer>>
     */
    public function getLoyaltyOffers(int $corporation_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetLoyaltyOffersRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the loyalty points a character has with every corporation it has worked for.
     *
     * @return EsiResult<array<int, LoyaltyPoints>>
     */
    public function getLoyaltyPoints(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadLoyaltyPoints);
        $request = new GetLoyaltyPointsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the shortest, safest, or least secure route between two solar systems.
     *
     * @param  array<int, int>  $avoid_systems  Solar systems to avoid.
     * @return EsiResult<array<int, int>>
     */
    public function getRoute(int $origin_system_id, int $destination_system_id, RoutePreference $preference = RoutePreference::Shorter, array $avoid_systems = [], int $security_penalty = 50): EsiResult
    {
        $connector = new Connector;
        $request = new GetRouteRequest($origin_system_id, $destination_system_id, $preference, $avoid_systems, $security_penalty);

        return $connector->send($request);
    }

    /**
     * Get character skills
     *
     * @return EsiResult<CharacterSkills>
     */
    public function getCharacterSkills(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadSkills);
        $request = new GetCharacterSkillsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get character skill queue
     *
     * @return EsiResult<array<int, SkillQueueEntry>>
     */
    public function getCharacterSkillQueue(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadSkillQueue);
        $request = new GetCharacterSkillQueueRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get character attributes
     *
     * @return EsiResult<CharacterAttributes>
     */
    public function getCharacterAttributes(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadSkills);
        $request = new GetCharacterAttributesRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get character clones
     *
     * @return EsiResult<CharacterClones>
     */
    public function getCharacterClones(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadClones);
        $request = new GetCharacterClonesRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Get character implants
     *
     * @return EsiResult<array<int, int>>
     */
    public function getCharacterImplants(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadImplants);
        $request = new GetCharacterImplantsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the fleet information of a character.
     *
     * @return EsiResult<FleetInfo>
     */
    public function getCharacterFleet(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadFleet);
        $request = new GetCharacterFleetRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves information about a fleet.
     *
     * @return EsiResult<Fleet>
     */
    public function getFleet(Character $character, int $fleet_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadFleet);
        $request = new GetFleetRequest($fleet_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the members of a fleet.
     *
     * @return EsiResult<array<int, FleetMember>>
     */
    public function getFleetMembers(Character $character, int $fleet_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadFleet);
        $request = new GetFleetMembersRequest($fleet_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the wings of a fleet.
     *
     * @return EsiResult<array<int, FleetWing>>
     */
    public function getFleetWings(Character $character, int $fleet_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadFleet);
        $request = new GetFleetWingsRequest($fleet_id);

        return $connector->send($request);
    }

    /**
     * Updates settings of a fleet.
     *
     * @return EsiResult<null>
     */
    public function updateFleet(Character $character, int $fleet_id, ?bool $is_free_move = null, ?string $motd = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new UpdateFleetRequest($fleet_id, $is_free_move, $motd);

        return $connector->send($request);
    }

    /**
     * Invites a character into a fleet.
     *
     * @return EsiResult<null>
     */
    public function inviteFleetMember(Character $character, int $fleet_id, int $character_id, string $role, ?int $squad_id = null, ?int $wing_id = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new InviteFleetMemberRequest($fleet_id, $character_id, $role, $squad_id, $wing_id);

        return $connector->send($request);
    }

    /**
     * Kicks a member out of a fleet.
     *
     * @return EsiResult<null>
     */
    public function kickFleetMember(Character $character, int $fleet_id, int $member_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new KickFleetMemberRequest($fleet_id, $member_id);

        return $connector->send($request);
    }

    /**
     * Moves a fleet member to a new role or squad/wing.
     *
     * @return EsiResult<null>
     */
    public function moveFleetMember(Character $character, int $fleet_id, int $member_id, string $role, ?int $squad_id = null, ?int $wing_id = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new MoveFleetMemberRequest($fleet_id, $member_id, $role, $squad_id, $wing_id);

        return $connector->send($request);
    }

    /**
     * Creates a new wing in a fleet.
     *
     * @return EsiResult<int> The ID of the new wing.
     */
    public function createFleetWing(Character $character, int $fleet_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new CreateFleetWingRequest($fleet_id);

        return $connector->send($request);
    }

    /**
     * Deletes a wing from a fleet.
     *
     * @return EsiResult<null>
     */
    public function deleteFleetWing(Character $character, int $fleet_id, int $wing_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new DeleteFleetWingRequest($fleet_id, $wing_id);

        return $connector->send($request);
    }

    /**
     * Renames a fleet wing.
     *
     * @return EsiResult<null>
     */
    public function renameFleetWing(Character $character, int $fleet_id, int $wing_id, string $name): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new RenameFleetWingRequest($fleet_id, $wing_id, $name);

        return $connector->send($request);
    }

    /**
     * Creates a new squad in a fleet wing.
     *
     * @return EsiResult<int> The ID of the new squad.
     */
    public function createFleetSquad(Character $character, int $fleet_id, int $wing_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new CreateFleetSquadRequest($fleet_id, $wing_id);

        return $connector->send($request);
    }

    /**
     * Deletes a squad from a fleet.
     *
     * @return EsiResult<null>
     */
    public function deleteFleetSquad(Character $character, int $fleet_id, int $squad_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new DeleteFleetSquadRequest($fleet_id, $squad_id);

        return $connector->send($request);
    }

    /**
     * Renames a fleet squad.
     *
     * @return EsiResult<null>
     */
    public function renameFleetSquad(Character $character, int $fleet_id, int $squad_id, string $name): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFleet);
        $request = new RenameFleetSquadRequest($fleet_id, $squad_id, $name);

        return $connector->send($request);
    }

    /**
     * Retrieves a list of industry facilities.
     *
     * @return EsiResult<array<int, IndustryFacility>> Returns an instance of EsiResult that contains the retrieved industry facilities.
     */
    public function getIndustryFacilities(): EsiResult
    {
        $connector = new Connector;
        $request = new GetIndustryFacilitiesRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the cost indices for solar systems used in industry.
     *
     * @return EsiResult<array<int, IndustrySystem>> Returns an instance of EsiResult that contains the retrieved industry systems.
     */
    public function getIndustrySystems(): EsiResult
    {
        $connector = new Connector;
        $request = new GetIndustrySystemsRequest;

        return $connector->send($request);
    }

    /**
     * Retrieves the industry jobs for a given character.
     *
     * @return EsiResult<array<int, IndustryJob>> Returns an instance of EsiResult that contains the retrieved industry jobs.
     */
    public function getCharacterIndustryJobs(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterIndustryJobs);
        $request = new GetCharacterIndustryJobsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the industry jobs for a corporation.
     *
     * @return EsiResult<array<int, IndustryJob>> Returns an instance of EsiResult that contains the retrieved industry jobs.
     */
    public function getCorporationIndustryJobs(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationIndustryJobs);
        $request = new GetCorporationIndustryJobsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the mining ledger for a given character.
     *
     * @return EsiResult<array<int, MiningLedgerEntry>> Returns an instance of EsiResult that contains the retrieved mining ledger.
     */
    public function getCharacterMining(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCharacterMining);
        $request = new GetCharacterMiningRequest($character->getId());

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the moon mining extractions for a corporation.
     *
     * @return EsiResult<array<int, MiningExtraction>> Returns an instance of EsiResult that contains the retrieved moon mining extractions.
     */
    public function getCorporationMiningExtractions(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMining);
        $request = new GetCorporationMiningExtractionsRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the mining observers for a corporation.
     *
     * @return EsiResult<array<int, MiningObserver>> Returns an instance of EsiResult that contains the retrieved mining observers.
     */
    public function getCorporationMiningObservers(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMining);
        $request = new GetCorporationMiningObserversRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves the mining ledger observed by a specific mining observer.
     *
     * @return EsiResult<array<int, MiningObserverEntry>> Returns an instance of EsiResult that contains the retrieved mining observer entries.
     */
    public function getCorporationMiningObserver(Character $character, int $corporation_id, int $observer_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationMining);
        $request = new GetCorporationMiningObserverRequest($corporation_id, $observer_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Retrieves a character's upcoming calendar events.
     *
     * @return EsiResult<array<int, CalendarEventSummary>>
     */
    public function getCalendar(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCalendarEvents);
        $request = new GetCalendarRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the full details of a calendar event.
     *
     * @return EsiResult<CalendarEvent>
     */
    public function getCalendarEvent(Character $character, int $event_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCalendarEvents);
        $request = new GetCalendarEventRequest($character->getId(), $event_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the attendees of a calendar event.
     *
     * @return EsiResult<array<int, CalendarEventAttendee>>
     */
    public function getCalendarEventAttendees(Character $character, int $event_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCalendarEvents);
        $request = new GetCalendarEventAttendeesRequest($character->getId(), $event_id);

        return $connector->send($request);
    }

    /**
     * Responds to a calendar event invitation (accepted, declined, or tentative).
     *
     * @return EsiResult<null>
     */
    public function respondToCalendarEvent(Character $character, int $event_id, string $response): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::RespondCalendarEvents);
        $request = new RespondToCalendarEventRequest($character->getId(), $event_id, $response);

        return $connector->send($request);
    }

    /**
     * Retrieves a character's ship fittings.
     *
     * @return EsiResult<array<int, Fitting>>
     */
    public function getFittings(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadFittings);
        $request = new GetFittingsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Creates a new ship fitting for a character.
     *
     * @param  array<int, array<string, mixed>>  $items
     * @return EsiResult<int> Returns an instance of EsiResult that contains the new fitting's ID.
     */
    public function createFitting(Character $character, string $name, string $description, int $ship_type_id, array $items): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFittings);
        $request = new CreateFittingRequest($character->getId(), $name, $description, $ship_type_id, $items);

        return $connector->send($request);
    }

    /**
     * Deletes a ship fitting for a character.
     *
     * @return EsiResult<null>
     */
    public function deleteFitting(Character $character, int $fitting_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::WriteFittings);
        $request = new DeleteFittingRequest($character->getId(), $fitting_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the planetary colonies owned by a character.
     *
     * @return EsiResult<array<int, PlanetColony>>
     */
    public function getPlanets(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ManagePlanets);
        $request = new GetPlanetsRequest($character->getId());

        return $connector->send($request);
    }

    /**
     * Retrieves the layout (pins, links, and routes) of one of a character's planetary colonies.
     *
     * Named getPlanetLayout rather than getPlanet to avoid clashing with the
     * existing public getPlanet(int $planet_id) universe endpoint.
     *
     * @return EsiResult<PlanetLayout>
     */
    public function getPlanetLayout(Character $character, int $planet_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ManagePlanets);
        $request = new GetPlanetLayoutRequest($character->getId(), $planet_id);

        return $connector->send($request);
    }

    /**
     * Retrieves the customs offices owned by a corporation.
     *
     * @return EsiResult<array<int, CustomsOffice>>
     */
    public function getCorporationCustomsOffices(Character $character, int $corporation_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCustomsOffices);
        $request = new GetCorporationCustomsOfficesRequest($corporation_id);

        return $connector->sendPaginated($request);
    }

    /**
     * Opens the information window for a character, corporation, alliance, or item in the EVE Online client.
     *
     * @return EsiResult<null>
     */
    public function openInformationWindow(Character $character, int $target_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OpenWindow);
        $request = new OpenInformationWindowRequest($target_id);

        return $connector->send($request);
    }

    /**
     * Opens the market details window for a type in the EVE Online client.
     *
     * @return EsiResult<null>
     */
    public function openMarketDetailsWindow(Character $character, int $type_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OpenWindow);
        $request = new OpenMarketDetailsWindowRequest($type_id);

        return $connector->send($request);
    }

    /**
     * Opens the new mail window, pre-filled with the given recipients, subject, and body, in the EVE Online client.
     *
     * @param  array<int, int>  $recipients
     * @return EsiResult<null>
     */
    public function openNewMailWindow(Character $character, array $recipients, string $subject, string $body, ?int $to_corp_or_alliance_id = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OpenWindow);
        $request = new OpenNewMailWindowRequest($recipients, $subject, $body, $to_corp_or_alliance_id);

        return $connector->send($request);
    }

    private function getAuthenticatedConnector(Character $character, EsiScope $scope): Connector
    {
        $token = $character->getEsiTokenWithScope($scope);

        return new Connector($token);
    }
}
