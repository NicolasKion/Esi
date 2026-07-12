<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Alliance;
use NicolasKion\Esi\DTO\AllianceIcons;
use NicolasKion\Esi\Esi;

it('fetches and maps an alliance', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/' => Http::response(esiFixture('alliances/detail.json')),
    ]);

    $result = (new Esi)->getAlliance(99000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Alliance::class)
        ->and($result->data->creator_corporation_id)->toBe(98777771)
        ->and($result->data->creator_id)->toBe(90000001)
        ->and($result->data->date_founded)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->name)->toBe('string')
        ->and($result->data->ticker)->toBe('string')
        ->and($result->data->executor_corporation_id)->toBe(98777771)
        ->and($result->data->faction_id)->toBe(500002);
});

it('fetches a paginated list of alliance ids', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/*' => Http::response(esiFixture('alliances/ids.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getAlliances();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeArray()
        ->and($result->data)->not->toBeEmpty();

    foreach ($result->data as $id) {
        expect($id)->toBeInt();
    }
});

it('returns an error result when the alliance endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getAlliance(99000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches the member corporation ids of an alliance', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/corporations*' => Http::response([98000001, 98000002]),
    ]);

    $result = (new Esi)->getAllianceCorporations(99000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([98000001, 98000002]);
});

it('fetches and maps alliance icons', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/icons*' => Http::response(esiFixture('alliances/icons.json')),
    ]);

    $result = (new Esi)->getAllianceIcons(99000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(AllianceIcons::class)
        ->and($result->data->px64x64)->toBe('string')
        ->and($result->data->px128x128)->toBe('string');
});
