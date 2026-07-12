<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\MarketGroup;
use NicolasKion\Esi\DTO\MarketOrder;
use NicolasKion\Esi\DTO\MarketPrice;
use NicolasKion\Esi\Enums\MarketOrderType;
use NicolasKion\Esi\Esi;

it('fetches the list of market group ids', function (): void {
    Http::fake([
        'esi.evetech.net/markets/groups*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getMarketGroups();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a market group', function (): void {
    Http::fake([
        'esi.evetech.net/markets/groups/4*' => Http::response(esiFixture('markets/group.json')),
    ]);

    $result = (new Esi)->getMarketGroup(4);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MarketGroup::class)
        ->and($result->data->market_group_id)->toBe(90000001)
        ->and($result->data->types)->toBe([90000001]);
});

it('fetches and maps market prices', function (): void {
    Http::fake([
        'esi.evetech.net/markets/prices*' => Http::response(esiFixture('markets/prices.json')),
    ]);

    $result = (new Esi)->getMarketPrices();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MarketPrice::class)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->adjusted_price)->toBe(1.5)
        ->and($result->data[0]->average_price)->toBe(1.5);
});

it('fetches region market orders and sends the order type and type filter', function (): void {
    Http::fake([
        'esi.evetech.net/markets/10000002/orders*' => Http::response(esiFixture('markets/orders.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getMarketOrders(10000002, MarketOrderType::Sell, 34);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MarketOrder::class)
        ->and($result->data[0]->order_id)->toBe(90000001)
        ->and($result->data[0]->is_buy_order)->toBeTrue()
        ->and($result->data[0]->price)->toBe(1.5)
        ->and($result->data[0]->system_id)->toBe(90000001);

    Http::assertSent(fn ($request) => str_contains($request->url(), 'order_type=sell')
        && str_contains($request->url(), 'type_id=34'));
});

it('fetches the type ids with active orders in a region', function (): void {
    Http::fake([
        'esi.evetech.net/markets/10000002/types*' => Http::response([34, 35], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getMarketTypes(10000002);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([34, 35]);
});

it('fetches structure market orders for an authenticated character', function (): void {
    Http::fake([
        'esi.evetech.net/markets/structures/1035466617946*' => Http::response(esiFixture('markets/orders.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getStructureMarketOrders(fakeCharacter(), 1035466617946);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MarketOrder::class)
        ->and($result->data[0]->order_id)->toBe(90000001);
});

it('returns an error result when a market endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/markets/prices*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getMarketPrices();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
