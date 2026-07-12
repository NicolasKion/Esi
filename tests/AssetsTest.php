<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Asset;
use NicolasKion\Esi\DTO\AssetName;
use NicolasKion\Esi\Enums\LocationFlag;
use NicolasKion\Esi\Enums\LocationType;
use NicolasKion\Esi\Esi;

it('fetches and maps character assets', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/assets/*' => Http::response(esiFixture('assets/assets.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getAssets(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Asset::class)
        ->and($result->data[0]->is_blueprint_copy)->toBeTrue()
        ->and($result->data[0]->is_singleton)->toBeTrue()
        ->and($result->data[0]->item_id)->toBe(90000001)
        ->and($result->data[0]->location_flag)->toBe(LocationFlag::AssetSafety)
        ->and($result->data[0]->location_id)->toBe(90000001)
        ->and($result->data[0]->location_type)->toBe(LocationType::Station)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000001);
});

it('fetches character asset names with the ids in the body', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/assets/names/' => Http::response(esiFixture('assets/asset-names.json')),
    ]);

    $result = (new Esi)->getAssetNames(fakeCharacter(), [1000000000001]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(AssetName::class)
        ->and($result->data[0]->item_id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('string');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/assets/names/')
        && $request->data() === [1000000000001]);
});

it('fetches and maps corporation assets', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/assets/*' => Http::response(esiFixture('assets/corporation-assets.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationAssets(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Asset::class)
        ->and($result->data[0]->is_blueprint_copy)->toBeTrue()
        ->and($result->data[0]->is_singleton)->toBeTrue()
        ->and($result->data[0]->item_id)->toBe(90000001)
        ->and($result->data[0]->location_flag)->toBe(LocationFlag::AssetSafety)
        ->and($result->data[0]->location_id)->toBe(90000001)
        ->and($result->data[0]->location_type)->toBe(LocationType::Station)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000001);
});

it('fetches corporation asset names with the ids in the body', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/assets/names/' => Http::response(esiFixture('assets/corporation-asset-names.json')),
    ]);

    $result = (new Esi)->getCorporationAssetNames(fakeCharacter(), [1000000000001]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(AssetName::class)
        ->and($result->data[0]->item_id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('string');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/corporations/456/assets/names/')
        && $request->data() === [1000000000001]);
});

it('returns an error result when the assets endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/assets/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getAssets(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('returns an empty result without hitting the API when no ids are given', function (): void {
    Http::fake();

    $result = (new Esi)->getAssetNames(fakeCharacter(), []);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([]);

    Http::assertNothingSent();
});

it('propagates a failed asset-names request', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/assets/names/*' => Http::response('boom', 500),
    ]);

    $result = (new Esi)->getAssetNames(fakeCharacter(), [1000000000001]);

    expect($result->failed())->toBeTrue();
});

it('returns early for corporation asset names with no ids', function (): void {
    Http::fake();

    $result = (new Esi)->getCorporationAssetNames(fakeCharacter(), []);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([]);

    Http::assertNothingSent();
});

it('chunks corporation asset names above 1000 ids', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/assets/names/*' => Http::response([
            ['item_id' => 1, 'name' => 'Container'],
        ]),
    ]);

    $result = (new Esi)->getCorporationAssetNames(fakeCharacter(), range(1, 1001));

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->not->toBeEmpty();
});

it('splits and retries corporation asset names when the API reports invalid ids', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/assets/names/*' => Http::response('Invalid IDs in the request', 404),
    ]);

    $result = (new Esi)->getCorporationAssetNames(fakeCharacter(), [1, 2]);

    // Every chunk reports invalid ids, so it recurses down to single ids and yields nothing.
    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([]);
});
