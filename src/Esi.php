<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use NicolasKion\Esi\DTO\Alliance;
use NicolasKion\Esi\DTO\Asset;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\DTO\CharacterAffiliation;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\DTO\Corporation;
use NicolasKion\Esi\DTO\DogmaItem;
use NicolasKion\Esi\DTO\EsiResult;
use NicolasKion\Esi\DTO\EveMail;
use NicolasKion\Esi\DTO\MarketHistory;
use NicolasKion\Esi\DTO\Name;
use NicolasKion\Esi\DTO\PublicContract;
use NicolasKion\Esi\DTO\PublicContractBid;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\DTO\Structure;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Interfaces\Character;
use NicolasKion\Esi\Requests\GetAffiliationsRequest;
use NicolasKion\Esi\Requests\GetAllianceRequest;
use NicolasKion\Esi\Requests\GetAlliancesRequest;
use NicolasKion\Esi\Requests\GetAssetNamesRequest;
use NicolasKion\Esi\Requests\GetAssetsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractItemsRequest;
use NicolasKion\Esi\Requests\GetCharacterContractsRequest;
use NicolasKion\Esi\Requests\GetCharacterRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetNamesRequest;
use NicolasKion\Esi\Requests\GetCorporationAssetsRequest;
use NicolasKion\Esi\Requests\GetCorporationRequest;
use NicolasKion\Esi\Requests\GetDogmaItemAttributesRequest;
use NicolasKion\Esi\Requests\GetEveMailRequest;
use NicolasKion\Esi\Requests\GetEveMailsRequest;
use NicolasKion\Esi\Requests\GetMarketHistoryRequest;
use NicolasKion\Esi\Requests\GetNamesRequest;
use NicolasKion\Esi\Requests\GetPublicContractBidsRequest;
use NicolasKion\Esi\Requests\GetPublicContractItemsRequest;
use NicolasKion\Esi\Requests\GetPublicContractsRequest;
use NicolasKion\Esi\Requests\GetPublicStructuresRequest;
use NicolasKion\Esi\Requests\GetStructureRequest;
use NicolasKion\Esi\Requests\GetWalletJournalRequest;
use NicolasKion\Esi\Requests\OpenContractRequest;
use NicolasKion\Esi\Requests\SendMailRequest;
use NicolasKion\Esi\Requests\UpdateEveMailRequest;

class Esi
{
    /**
     * Retrieves public contracts for a given region.
     *
     * @param int $region_id The ID of the region.
     * @return EsiResult<PublicContract[]> Returns an instance of EsiResult that contains the retrieved public contracts.
     *
     * @throws ConnectionException
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
     * @param int $contract_id The ID of the contract.
     * @return EsiResult<PublicContractItem[]> Returns an instance of EsiResult that contains the retrieved public contract items.
     *
     * @throws ConnectionException
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
     * @param int $contract_id The ID of the contract.
     * @return EsiResult<PublicContractBid[]> Returns an instance of EsiResult that contains the retrieved public contract bids.
     *
     * @throws ConnectionException
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
     * @param array<int> $ids The list of IDs.
     * @return EsiResult<CharacterAffiliation[]> Returns an instance of EsiResult that contains the retrieved character affiliations.
     *
     * @throws ConnectionException
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
     * @param int $type_id The type ID.
     * @param int $item_id The item ID.
     * @return EsiResult<DogmaItem> Returns an instance of EsiResult that contains the retrieved dogma item attributes.
     *
     * @throws ConnectionException
     */
    public function getDogmaItem(int $type_id, int $item_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetDogmaItemAttributesRequest($type_id, $item_id);

        return $connector->send($request);
    }

    /**
     * Retrieves market history for a given region and type ID.
     *
     * @param int $region_id The ID of the region.
     * @param int $type_id The type ID.
     * @return EsiResult<MarketHistory[]> Returns an instance of EsiResult that contains the retrieved market history.
     *
     * @throws ConnectionException
     */
    public function getMarketHistory(int $region_id, int $type_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetMarketHistoryRequest($region_id, $type_id);

        return $connector->send($request);
    }

    /**
     * Retrieves names for a given list of IDs.
     *
     * @param array<int> $ids The list of IDs.
     * @return EsiResult<Name[]> Returns an instance of EsiResult that contains the retrieved names.
     *
     * @throws ConnectionException
     */
    public function getNames(array $ids): EsiResult
    {
        $connector = new Connector;
        $request = new GetNamesRequest($ids);

        return $connector->send($request);
    }

    /**
     * Retrieves public structures.
     *
     * @return EsiResult<int[]> Returns an instance of EsiResult that contains the retrieved public structures.
     *
     * @throws ConnectionException
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
     * @param int $structure_id The structure ID.
     * @return EsiResult<Structure> Returns an instance of EsiResult that contains the retrieved structure information.
     *
     * @throws ConnectionException
     */
    public function getStructure(Character $character, int $structure_id): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadStructures);
        $request = new GetStructureRequest($structure_id);

        return $connector->send($request);
    }

    /**
     * @throws ConnectionException
     */
    private function getAuthenticatedConnector(Character $character, EsiScope $scope): Connector
    {
        $token = $character->getEsiTokenWithScope($scope);

        return new Connector($token);
    }

    /**
     * Retrieves the wallet journal for a given character.
     *
     * @return EsiResult<WalletJournalEntry[]> Returns an instance of EsiResult that contains the retrieved wallet journal.
     *
     * @throws ConnectionException
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
     * @return EsiResult<EveMail> Returns an instance of EsiResult that contains the retrieved EVE mails.
     *
     * @throws ConnectionException
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
     *
     * @throws ConnectionException
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
     * @return EsiResult<Collection<Asset>>
     *
     * @throws ConnectionException
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
     * @param array<int> $ids
     * @return EsiResult<AssetName[]>
     *
     * @throws ConnectionException
     */
    public function getAssetNames(Character $character, array $ids): EsiResult
    {
        /** @var AssetName[] $names */
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

            /** @var AssetName[] $names */
            $names = [...$names, ...$result->data];
        }

        return new EsiResult(data: $names);
    }

    /**
     * Retrieves the corporation assets for a given character.
     *
     * @return EsiResult<Collection<Asset>>
     *
     * @throws ConnectionException
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
     * @param array<int> $ids
     * @return EsiResult<AssetName[]>
     *
     * @throws ConnectionException
     */
    public function getCorporationAssetNames(Character $character, array $ids): EsiResult
    {

        /** @var AssetName[] $names */
        $names = [];

        if ($ids === []) {
            return new EsiResult(data: $names);
        }

        if (count($ids) > 1000) {
            $results = collect(array_chunk($ids, 1000))->map(function ($chunk) use ($character) {
                return $this->getCorporationAssetNames($character, $chunk);
            });

            /** @var AssetName[] $names */
            $names = $results->map(fn(EsiResult $result) => $result->data)->flatten()->all();

            return new EsiResult(data: $names);
        }

        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadCorporationAssets);
        $request = new GetCorporationAssetNamesRequest($character->getCorporationId(), $ids);
        $response = $connector->send($request);

        if (str_contains($response->error?->body ?? '', 'Invalid IDs in the request')) {
            if (count($ids) === 1) {
                return new EsiResult(data: $names);
            }

            // Split in two and try again
            $half = (int)ceil(count($ids) / 2);
            $first = array_slice($ids, 0, $half);
            $second = array_slice($ids, $half);

            $first_result = $this->getCorporationAssetNames($character, $first);
            $second_result = $this->getCorporationAssetNames($character, $second);

            /** @var AssetName[] $names */
            $names = [...$first_result->data, ...$second_result->data];

            return new EsiResult(data: $names);
        }

        return $response;
    }

    /**
     * Retrieves a character by ID.
     *
     * @return EsiResult<DTO\Character>
     *
     * @throws ConnectionException
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
     *
     * @throws ConnectionException
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
     * @return EsiResult<int>
     *
     * @throws ConnectionException
     */
    public function sendMail(Character $character, array $recipients, string $subject, string $body): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::SendMail);

        return $connector->send(new SendMailRequest($character->getId(), $recipients, $subject, $body));
    }

    /**
     * Retrieves the contracts for a given character.
     *
     * @return EsiResult<Collection<CharacterContract>>
     *
     * @throws ConnectionException
     */
    public function getCharacterContracts(Character $character): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::ReadContracts);

        return $connector->sendPaginated(new GetCharacterContractsRequest($character->getId()));
    }

    /**
     * Retrieves the contract items for a given character and contract.
     *
     * @return EsiResult<Collection<PublicContractItem>>
     *
     * @throws ConnectionException
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
     *
     * @throws ConnectionException
     */
    public function getCorporation(int $corporation_id): EsiResult
    {
        $connector = new Connector;
        $request = new GetCorporationRequest($corporation_id);

        return $connector->send($request);
    }

    /**
     * Retrieves alliance details
     *
     * @return EsiResult<Alliance>
     *
     * @throws ConnectionException
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
     * @return EsiResult<int[]>
     *
     * @throws ConnectionException
     */
    public function getAlliances(): EsiResult
    {
        $connector = new Connector;
        $request = new GetAlliancesRequest;

        return $connector->sendPaginated($request);
    }

    /**
     * Updates an EVE mail
     *
     * @param array<int>|null $labels
     *
     * @throws ConnectionException
     */
    public function updateEveMail(Character $character, int $mail_id, bool $read = true, ?array $labels = null): EsiResult
    {
        $connector = $this->getAuthenticatedConnector($character, EsiScope::OrganizeMail);
        $request = new UpdateEveMailRequest($character->getId(), $mail_id, $read, $labels);

        return $connector->send($request);
    }
}
