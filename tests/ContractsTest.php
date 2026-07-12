<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\DTO\PublicContract;
use NicolasKion\Esi\DTO\PublicContractBid;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\Enums\ContractType;
use NicolasKion\Esi\Esi;

it('fetches and maps public contracts', function (): void {
    Http::fake([
        'esi.evetech.net/contracts/public/10000002/*' => Http::response(esiFixture('contracts/public_contracts.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getPublicContracts(10000002);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PublicContract::class)
        ->and($result->data[0]->contract_id)->toBe(90000001)
        ->and($result->data[0]->issuer_id)->toBe(90000001)
        ->and($result->data[0]->issuer_corporation_id)->toBe(90000001)
        ->and($result->data[0]->date_issued)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->date_expired)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->type)->toBe(ContractType::ItemExchange)
        ->and($result->data[0]->buyout)->toBe(1.5)
        ->and($result->data[0]->collateral)->toBe(1.5)
        ->and($result->data[0]->days_to_complete)->toBe(90000001)
        ->and($result->data[0]->start_location_id)->toBe(90000001)
        ->and($result->data[0]->end_location_id)->toBe(90000001)
        ->and($result->data[0]->for_corporation)->toBeTrue()
        ->and($result->data[0]->price)->toBe(1.5)
        ->and($result->data[0]->reward)->toBe(1.5)
        ->and($result->data[0]->volume)->toBe(1.5)
        ->and($result->data[0]->title)->toBe('string');
});

it('fetches and maps public contract items', function (): void {
    Http::fake([
        'esi.evetech.net/contracts/public/items/90000001/*' => Http::response(esiFixture('contracts/public_contract_items.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getPublicContractItems(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PublicContractItem::class)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->record_id)->toBe(90000001)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->is_included)->toBeTrue()
        ->and($result->data[0]->item_id)->toBe(90000001)
        ->and($result->data[0]->is_blueprint_copy)->toBeTrue()
        ->and($result->data[0]->material_efficiency)->toBe(90000001)
        ->and($result->data[0]->time_efficiency)->toBe(90000001)
        ->and($result->data[0]->runs)->toBe(90000001);
});

it('fetches and maps public contract bids', function (): void {
    Http::fake([
        'esi.evetech.net/contracts/public/bids/90000001/*' => Http::response(esiFixture('contracts/public_contract_bids.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getPublicContractBids(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PublicContractBid::class)
        ->and($result->data[0]->amount)->toBe(1.5)
        ->and($result->data[0]->bid_id)->toBe(90000001)
        ->and($result->data[0]->date_bid)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps character contracts', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contracts/*' => Http::response(esiFixture('contracts/character_contracts.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCharacterContracts(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CharacterContract::class)
        ->and($result->data[0]->acceptor_id)->toBe(90000001)
        ->and($result->data[0]->assignee_id)->toBe(90000001)
        ->and($result->data[0]->availability)->toBe('public')
        ->and($result->data[0]->buyout)->toBe(1.5)
        ->and($result->data[0]->collateral)->toBe(1.5)
        ->and($result->data[0]->contract_id)->toBe(90000001)
        ->and($result->data[0]->date_accepted)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->date_completed)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->date_expired)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->date_issued)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->days_to_complete)->toBe(90000001)
        ->and($result->data[0]->end_location_id)->toBe(90000001)
        ->and($result->data[0]->for_corporation)->toBeTrue()
        ->and($result->data[0]->issuer_corporation_id)->toBe(90000001)
        ->and($result->data[0]->issuer_id)->toBe(90000001)
        ->and($result->data[0]->price)->toBe(1.5)
        ->and($result->data[0]->reward)->toBe(1.5)
        ->and($result->data[0]->start_location_id)->toBe(90000001)
        ->and($result->data[0]->status)->toBe('outstanding')
        ->and($result->data[0]->title)->toBe('string')
        ->and($result->data[0]->type)->toBe(ContractType::ItemExchange)
        ->and($result->data[0]->volume)->toBe(1.5);
});

it('fetches and maps character contract items', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contracts/90000001/items/*' => Http::response(esiFixture('contracts/character_contract_items.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCharacterContractItems(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PublicContractItem::class)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->record_id)->toBe(90000001)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->is_included)->toBeTrue()
        ->and($result->data[0]->item_id)->toBeNull()
        ->and($result->data[0]->is_blueprint_copy)->toBeNull()
        ->and($result->data[0]->material_efficiency)->toBeNull()
        ->and($result->data[0]->time_efficiency)->toBeNull()
        ->and($result->data[0]->runs)->toBeNull();
});

it('opens a contract in the client', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/contract/*' => Http::response(null, 204),
    ]);

    $result = (new Esi)->openContract(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/ui/openwindow/contract/')
        && str_contains($request->url(), 'contract_id=90000001'));
});

it('returns an error result when the public contracts endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/contracts/public/10000002/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getPublicContracts(10000002);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
