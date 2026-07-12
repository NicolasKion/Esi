<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\DTO\ContractBid;
use NicolasKion\Esi\DTO\KillmailRef;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\Enums\ContractType;
use NicolasKion\Esi\Esi;

it('fetches and maps character contract bids', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contracts/90000001/bids/*' => Http::response(esiFixture('contracts/character_contract_bids.json')),
    ]);

    $result = (new Esi)->getCharacterContractBids(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ContractBid::class)
        ->and($result->data[0]->amount)->toBe(1.5)
        ->and($result->data[0]->bid_id)->toBe(90000001)
        ->and($result->data[0]->bidder_id)->toBe(90000001)
        ->and($result->data[0]->date_bid)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps corporation contracts', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/contracts/*' => Http::response(esiFixture('contracts/corporation_contracts.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationContracts(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CharacterContract::class)
        ->and($result->data[0]->contract_id)->toBe(90000001)
        ->and($result->data[0]->acceptor_id)->toBe(90000001)
        ->and($result->data[0]->assignee_id)->toBe(90000001)
        ->and($result->data[0]->availability)->toBe('public')
        ->and($result->data[0]->type)->toBe(ContractType::ItemExchange)
        ->and($result->data[0]->status)->toBe('outstanding');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/corporations/456/contracts/'));
});

it('fetches and maps corporation contract items', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/contracts/90000001/items/*' => Http::response(esiFixture('contracts/corporation_contract_items.json')),
    ]);

    $result = (new Esi)->getCorporationContractItems(fakeCharacter(), 456, 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PublicContractItem::class)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->record_id)->toBe(90000001)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->is_included)->toBeTrue()
        ->and($result->data[0]->raw_quantity)->toBe(90000001);
});

it('fetches and maps corporation contract bids', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/contracts/90000001/bids/*' => Http::response(esiFixture('contracts/corporation_contract_bids.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationContractBids(fakeCharacter(), 456, 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ContractBid::class)
        ->and($result->data[0]->amount)->toBe(1.5)
        ->and($result->data[0]->bid_id)->toBe(90000001)
        ->and($result->data[0]->bidder_id)->toBe(90000001)
        ->and($result->data[0]->date_bid)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps a character\'s recent killmails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/killmails/recent/*' => Http::response(esiFixture('killmails/recent.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCharacterRecentKillmails(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(KillmailRef::class)
        ->and($result->data[0]->killmail_id)->toBe(90000001)
        ->and($result->data[0]->killmail_hash)->toBe('abcdef1234567890');
});

it('fetches and maps a corporation\'s recent killmails', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/killmails/recent/*' => Http::response(esiFixture('killmails/recent.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationRecentKillmails(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(KillmailRef::class)
        ->and($result->data[0]->killmail_id)->toBe(90000001)
        ->and($result->data[0]->killmail_hash)->toBe('abcdef1234567890');
});

it('fetches and maps the list of wars', function (): void {
    Http::fake([
        'esi.evetech.net/wars/*' => Http::response(esiFixture('wars/list.json')),
    ]);

    $result = (new Esi)->getWars();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([90000001, 90000002]);

    Http::assertSent(fn ($request) => str_contains($request->url(), '/wars/') && ! str_contains($request->url(), 'max_war_id'));
});

it('fetches the list of wars filtered by max_war_id', function (): void {
    Http::fake([
        'esi.evetech.net/wars/*' => Http::response(esiFixture('wars/list.json')),
    ]);

    $result = (new Esi)->getWars(90000002);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([90000001, 90000002]);

    Http::assertSent(fn ($request) => str_contains($request->url(), 'max_war_id=90000002'));
});

it('fetches and maps the killmails for a war', function (): void {
    Http::fake([
        'esi.evetech.net/wars/1/killmails/*' => Http::response(esiFixture('wars/killmails.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getWarKillmails(1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(KillmailRef::class)
        ->and($result->data[0]->killmail_id)->toBe(90000001)
        ->and($result->data[0]->killmail_hash)->toBe('abcdef1234567890');
});

it('returns an error result when a contracts/killmails/wars endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contracts/90000001/bids/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCharacterContractBids(fakeCharacter(), 90000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
