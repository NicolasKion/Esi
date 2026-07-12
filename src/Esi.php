<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace NicolasKion\Esi;

use NicolasKion\Esi\DTO\Alliance;
use NicolasKion\Esi\DTO\AllianceIcons;
use NicolasKion\Esi\DTO\Asset;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\DTO\CharacterAffiliation;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\DTO\Contact;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\DTO\Corporation;
use NicolasKion\Esi\DTO\CorporationDivisions;
use NicolasKion\Esi\DTO\CorporationStructure;
use NicolasKion\Esi\DTO\DogmaAttribute;
use NicolasKion\Esi\DTO\DogmaEffect;
use NicolasKion\Esi\DTO\DogmaItem;
use NicolasKion\Esi\DTO\EsiResult;
use NicolasKion\Esi\DTO\EveMail;
use NicolasKion\Esi\DTO\Killmail;
use NicolasKion\Esi\DTO\Location;
use NicolasKion\Esi\DTO\MarketGroup;
use NicolasKion\Esi\DTO\MarketHistory;
use NicolasKion\Esi\DTO\MarketOrder;
use NicolasKion\Esi\DTO\MarketPrice;
use NicolasKion\Esi\DTO\Name;
use NicolasKion\Esi\DTO\Online;
use NicolasKion\Esi\DTO\PublicContract;
use NicolasKion\Esi\DTO\PublicContractBid;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\DTO\RaidableSkyhook;
use NicolasKion\Esi\DTO\Ship;
use NicolasKion\Esi\DTO\Sovereignty;
use NicolasKion\Esi\DTO\Status;
use NicolasKion\Esi\DTO\Structure;
use NicolasKion\Esi\DTO\UniverseIds;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\DTO\War;
use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Enums\MarketOrderType;
use NicolasKion\Esi\Interfaces\Character;
use NicolasKion\Esi\Requests\AddCharacterContactsRequest;
use NicolasKion\Esi\Requests\DeleteCharacterContactsRequest;
use NicolasKion\Esi\Requests\EditCharacterContactsRequest;
use NicolasKion\Esi\Requests\GetAffiliationsRequest;
use NicolasKion\Esi\Requests\GetAllianceContactLabelsRequest;
use NicolasKion\Esi\Requests\GetAllianceContactsRequest;
use NicolasKion\Esi\Requests\GetAllianceCorporationsRequest;
use NicolasKion\Esi\Requests\GetAllianceIconsRequest;
use NicolasKion\Esi\Requests\GetAllianceRequest;
use NicolasKion\Esi\Requests\GetAlliancesRequest;
use NicolasKion\Esi\Requests\GetAssetNamesRequest;
use NicolasKion\Esi\Requests\GetAssetsRequest;
use NicolasKion\Esi\Requests\GetCharacterContactLabelsRequest;
use NicolasKion\Esi\Requests\GetCharacterContactsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractItemsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractsRequest;
use NicolasKion\Esi\Requests\GetCharacterRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetNamesRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetsRequest;
use NicolasKion\Esi\Requests\GetCorporationContactLabelsRequest;
use NicolasKion\Esi\Requests\GetCorporationContactsRequest;
use NicolasKion\Esi\Requests\GetCorporationDivisionsRequest;
use NicolasKion\Esi\Requests\GetCorporationRequest;
use NicolasKion\Esi\Requests\GetCorporationStructuresRequest;
use NicolasKion\Esi\Requests\GetDogmaAttributeRequest;
use NicolasKion\Esi\Requests\GetDogmaAttributesRequest;
use NicolasKion\Esi\Requests\GetDogmaEffectRequest;
use NicolasKion\Esi\Requests\GetDogmaEffectsRequest;
use NicolasKion\Esi\Requests\GetDogmaItemAttributesRequest;
use NicolasKion\Esi\Requests\GetEveMailRequest;
use NicolasKion\Esi\Requests\GetEveMailsRequest;
use NicolasKion\Esi\Requests\GetIdsRequest;
use NicolasKion\Esi\Requests\GetKillmailRequest;
use NicolasKion\Esi\Requests\GetLocationRequest;
use NicolasKion\Esi\Requests\GetMarketGroupRequest;
use NicolasKion\Esi\Requests\GetMarketGroupsRequest;
use NicolasKion\Esi\Requests\GetMarketHistoryRequest;
use NicolasKion\Esi\Requests\GetMarketOrdersRequest;
use NicolasKion\Esi\Requests\GetMarketPricesRequest;
use NicolasKion\Esi\Requests\GetMarketTypesRequest;
use NicolasKion\Esi\Requests\GetNamesRequest;
use NicolasKion\Esi\Requests\GetOnlineRequest;
use NicolasKion\Esi\Requests\GetPublicContractBidsRequest;
use NicolasKion\Esi\Requests\GetPublicContractItemsRequest;
use NicolasKion\Esi\Requests\GetPublicContractsRequest;
use NicolasKion\Esi\Requests\GetPublicStructuresRequest;
use NicolasKion\Esi\Requests\GetRaidableSkyhooksRequest;
use NicolasKion\Esi\Requests\GetShipRequest;
use NicolasKion\Esi\Requests\GetSovereigntyRequest;
use NicolasKion\Esi\Requests\GetStructureMarketOrdersRequest;
use NicolasKion\Esi\Requests\GetStructureRequest;
use NicolasKion\Esi\Requests\GetWalletJournalRequest;
use NicolasKion\Esi\Requests\GetWarRequest;
use NicolasKion\Esi\Requests\OpenContractRequest;
use NicolasKion\Esi\Requests\SendMailRequest;
use NicolasKion\Esi\Requests\UpdateEveMailRequest;

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

    private function getAuthenticatedConnector(Character $character, EsiScope $scope): Connector
    {
        $token = $character->getEsiTokenWithScope($scope);

        return new Connector($token);
    }
}
