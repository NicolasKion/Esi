<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Corporation;
use NicolasKion\Esi\DTO\CorporationDivisions;
use NicolasKion\Esi\DTO\CorporationStructure;
use NicolasKion\Esi\Esi;

it('fetches and maps a public corporation', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/' => Http::response(esiFixture('corporations/detail.json')),
    ]);

    $result = (new Esi)->getCorporation(456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Corporation::class)
        ->and($result->data->alliance_id)->toBe(99000001)
        ->and($result->data->ceo_id)->toBe(90000001)
        ->and($result->data->creator_id)->toBe(90000001)
        ->and($result->data->date_founded)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->description)->toBe('string')
        ->and($result->data->faction_id)->toBe(500002)
        ->and($result->data->home_station_id)->toBe(60000001)
        ->and($result->data->member_count)->toBe(90000001)
        ->and($result->data->name)->toBe('string')
        ->and($result->data->shares)->toBe(90000001)
        ->and($result->data->tax_rate)->toBe(1.5)
        ->and($result->data->ticker)->toBe('string')
        ->and($result->data->url)->toBe('string')
        ->and($result->data->war_eligible)->toBeTrue();
});

it('fetches and maps corporation divisions', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/divisions/' => Http::response(esiFixture('corporations/divisions.json')),
    ]);

    $result = (new Esi)->getCorporationDivisions(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CorporationDivisions::class)
        ->and($result->data->hangar)->toHaveCount(1)
        ->and($result->data->hangar[0]->division)->toBe(90000001)
        ->and($result->data->hangar[0]->name)->toBe('string')
        ->and($result->data->wallet)->toHaveCount(1)
        ->and($result->data->wallet[0]->division)->toBe(90000001)
        ->and($result->data->wallet[0]->name)->toBe('string');
});

it('fetches and maps paginated corporation structures', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/structures/*' => Http::response(esiFixture('corporations/structures.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationStructures(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CorporationStructure::class)
        ->and($result->data[0]->corporation_id)->toBe(90000001)
        ->and($result->data[0]->profile_id)->toBe(90000001)
        ->and($result->data[0]->state)->toBe('anchor_vulnerable')
        ->and($result->data[0]->structure_id)->toBe(90000001)
        ->and($result->data[0]->system_id)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('string')
        ->and($result->data[0]->fuel_expires)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->reinforce_hour)->toBe(90000001)
        ->and($result->data[0]->next_reinforce_hour)->toBe(90000001)
        ->and($result->data[0]->next_reinforce_apply)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->state_timer_start)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->state_timer_end)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->unanchors_at)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->services)->toHaveCount(1)
        ->and($result->data[0]->services[0]->name)->toBe('string')
        ->and($result->data[0]->services[0]->state)->toBe('online');
});

it('returns an error result when the corporation endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCorporation(456);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
