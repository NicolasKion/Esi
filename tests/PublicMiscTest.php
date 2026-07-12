<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Incursion;
use NicolasKion\Esi\DTO\InsuranceLevel;
use NicolasKion\Esi\DTO\InsurancePrice;
use NicolasKion\Esi\DTO\LoyaltyOffer;
use NicolasKion\Esi\DTO\LoyaltyRequiredItem;
use NicolasKion\Esi\Enums\RoutePreference;
use NicolasKion\Esi\Esi;

it('fetches and maps the list of incursions', function (): void {
    Http::fake([
        'esi.evetech.net/incursions*' => Http::response(esiFixture('incursions/incursions.json')),
    ]);

    $result = (new Esi)->getIncursions();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Incursion::class)
        ->and($result->data[0]->constellation_id)->toBe(90000001)
        ->and($result->data[0]->faction_id)->toBe(90000001)
        ->and($result->data[0]->has_boss)->toBeTrue()
        ->and($result->data[0]->infested_solar_systems)->toBe([90000001])
        ->and($result->data[0]->influence)->toBe(1.5)
        ->and($result->data[0]->staging_solar_system_id)->toBe(90000001)
        ->and($result->data[0]->state)->toBe('withdrawing')
        ->and($result->data[0]->type)->toBe('string');
});

it('returns an error result when the incursions endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/incursions*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getIncursions();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps the list of insurance prices', function (): void {
    Http::fake([
        'esi.evetech.net/insurance/prices*' => Http::response(esiFixture('insurance/prices.json')),
    ]);

    $result = (new Esi)->getInsurancePrices();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(InsurancePrice::class)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->levels)->toHaveCount(1)
        ->and($result->data[0]->levels[0])->toBeInstanceOf(InsuranceLevel::class)
        ->and($result->data[0]->levels[0]->cost)->toBe(1.5)
        ->and($result->data[0]->levels[0]->name)->toBe('string')
        ->and($result->data[0]->levels[0]->payout)->toBe(1.5);
});

it('returns an error result when the insurance prices endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/insurance/prices*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getInsurancePrices();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps the loyalty store offers of a corporation', function (): void {
    Http::fake([
        'esi.evetech.net/loyalty/stores/98000001/offers*' => Http::response(esiFixture('loyalty/offers.json')),
    ]);

    $result = (new Esi)->getLoyaltyOffers(98000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(LoyaltyOffer::class)
        ->and($result->data[0]->offer_id)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->lp_cost)->toBe(90000001)
        ->and($result->data[0]->isk_cost)->toBe(90000001)
        ->and($result->data[0]->ak_cost)->toBe(90000001)
        ->and($result->data[0]->required_items)->toHaveCount(1)
        ->and($result->data[0]->required_items[0])->toBeInstanceOf(LoyaltyRequiredItem::class)
        ->and($result->data[0]->required_items[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->required_items[0]->type_id)->toBe(90000001);

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/loyalty/stores/98000001/offers'));
});

it('defaults a missing ak_cost to null on loyalty offers', function (): void {
    Http::fake([
        'esi.evetech.net/loyalty/stores/98000001/offers*' => Http::response([
            [
                'offer_id' => 1,
                'type_id' => 2,
                'quantity' => 3,
                'lp_cost' => 4,
                'isk_cost' => 5,
                'required_items' => [],
            ],
        ]),
    ]);

    $result = (new Esi)->getLoyaltyOffers(98000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data[0]->ak_cost)->toBeNull()
        ->and($result->data[0]->required_items)->toBeEmpty();
});

it('returns an error result when the loyalty offers endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/loyalty/stores/98000001/offers*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getLoyaltyOffers(98000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps a route between two solar systems', function (): void {
    Http::fake([
        'esi.evetech.net/route/30000142/30002187*' => Http::response(esiFixture('route/route.json')),
    ]);

    $result = (new Esi)->getRoute(30000142, 30002187, RoutePreference::Safer, [30000001], 10);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([30000001]);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/route/30000142/30002187')
        && $request->data()['preference'] === 'Safer'
        && $request->data()['avoid_systems'] === [30000001]
        && $request->data()['security_penalty'] === 10);
});

it('uses default routing preferences when none are given', function (): void {
    Http::fake([
        'esi.evetech.net/route/30000142/30002187*' => Http::response(esiFixture('route/route.json')),
    ]);

    $result = (new Esi)->getRoute(30000142, 30002187);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([30000001]);

    Http::assertSent(fn ($request) => $request->data()['preference'] === 'Shorter'
        && $request->data()['avoid_systems'] === []
        && $request->data()['security_penalty'] === 50);
});

it('returns an error result when the route endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/route/30000142/30002187*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getRoute(30000142, 30002187);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
