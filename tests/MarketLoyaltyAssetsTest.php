<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\AssetLocation;
use NicolasKion\Esi\DTO\LoyaltyPoints;
use NicolasKion\Esi\DTO\PersonalMarketOrder;
use NicolasKion\Esi\DTO\PersonalMarketOrderHistory;
use NicolasKion\Esi\Esi;

it('fetches and maps a character\'s open orders', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/orders/' => Http::response(esiFixture('markets/character-orders.json')),
    ]);

    $result = (new Esi)->getCharacterOrders(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PersonalMarketOrder::class)
        ->and($result->data[0]->order_id)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(34)
        ->and($result->data[0]->location_id)->toBe(90000001)
        ->and($result->data[0]->region_id)->toBe(10000002)
        ->and($result->data[0]->duration)->toBe(90)
        ->and($result->data[0]->is_buy_order)->toBeTrue()
        ->and($result->data[0]->is_corporation)->toBeTrue()
        ->and($result->data[0]->issued)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->issued_by)->toBeNull()
        ->and($result->data[0]->min_volume)->toBe(1)
        ->and($result->data[0]->escrow)->toBe(1.5)
        ->and($result->data[0]->price)->toBe(1.5)
        ->and($result->data[0]->range)->toBe('station')
        ->and($result->data[0]->volume_remain)->toBe(5)
        ->and($result->data[0]->volume_total)->toBe(10)
        ->and($result->data[0]->wallet_division)->toBeNull();
});

it('fetches and maps a character\'s order history across pages', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/orders/history/*' => Http::response(esiFixture('markets/character-order-history.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCharacterOrderHistory(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PersonalMarketOrderHistory::class)
        ->and($result->data[0]->order_id)->toBe(90000001)
        ->and($result->data[0]->is_corporation)->toBeTrue()
        ->and($result->data[0]->state)->toBe('cancelled')
        ->and($result->data[0]->issued_by)->toBeNull()
        ->and($result->data[0]->wallet_division)->toBeNull();
});

it('fetches and maps a corporation\'s open orders', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/orders/*' => Http::response(esiFixture('markets/corporation-orders.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationOrders(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PersonalMarketOrder::class)
        ->and($result->data[0]->order_id)->toBe(90000002)
        ->and($result->data[0]->is_corporation)->toBeNull()
        ->and($result->data[0]->issued_by)->toBe(90000001)
        ->and($result->data[0]->wallet_division)->toBe(1);
});

it('fetches and maps a corporation\'s order history across pages', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/orders/history/*' => Http::response(esiFixture('markets/corporation-order-history.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationOrderHistory(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PersonalMarketOrderHistory::class)
        ->and($result->data[0]->order_id)->toBe(90000002)
        ->and($result->data[0]->state)->toBe('expired')
        ->and($result->data[0]->issued_by)->toBe(90000001)
        ->and($result->data[0]->wallet_division)->toBe(1);
});

it('returns an error result when the character orders endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/orders/' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getCharacterOrders(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps a character\'s loyalty points', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/loyalty/points/' => Http::response(esiFixture('loyalty/points.json')),
    ]);

    $result = (new Esi)->getLoyaltyPoints(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(LoyaltyPoints::class)
        ->and($result->data[0]->corporation_id)->toBe(90000001)
        ->and($result->data[0]->loyalty_points)->toBe(12345);
});

it('returns an error result when the loyalty points endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/loyalty/points/' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getLoyaltyPoints(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches character asset locations and sends the item ids in the body', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/assets/locations/' => Http::response(esiFixture('assets/locations.json')),
    ]);

    $result = (new Esi)->getAssetLocations(fakeCharacter(), [1000000000001]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(AssetLocation::class)
        ->and($result->data[0]->item_id)->toBe(1000000000001)
        ->and($result->data[0]->position->x)->toBe(1.5)
        ->and($result->data[0]->position->y)->toBe(2.5)
        ->and($result->data[0]->position->z)->toBe(3.5);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/assets/locations/')
        && $request->data() === [1000000000001]);
});

it('fetches corporation asset locations and sends the item ids in the body', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/assets/locations/' => Http::response(esiFixture('assets/corporation-locations.json')),
    ]);

    $result = (new Esi)->getCorporationAssetLocations(fakeCharacter(), 456, [1000000000002]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(AssetLocation::class)
        ->and($result->data[0]->item_id)->toBe(1000000000002)
        ->and($result->data[0]->position->x)->toBe(4.5)
        ->and($result->data[0]->position->y)->toBe(5.5)
        ->and($result->data[0]->position->z)->toBe(6.5);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/corporations/456/assets/locations/')
        && $request->data() === [1000000000002]);
});

it('returns an error result when the asset locations endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/assets/locations/' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getAssetLocations(fakeCharacter(), [1000000000001]);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
