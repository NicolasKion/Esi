<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\IndustryFacility;
use NicolasKion\Esi\DTO\IndustryJob;
use NicolasKion\Esi\DTO\IndustrySystem;
use NicolasKion\Esi\DTO\MiningExtraction;
use NicolasKion\Esi\DTO\MiningLedgerEntry;
use NicolasKion\Esi\DTO\MiningObserver;
use NicolasKion\Esi\DTO\MiningObserverEntry;
use NicolasKion\Esi\Esi;

it('fetches and maps industry facilities', function (): void {
    Http::fake([
        'esi.evetech.net/industry/facilities*' => Http::response([
            [
                'facility_id' => 90000001,
                'owner_id' => 90000002,
                'region_id' => 90000003,
                'solar_system_id' => 90000004,
                'tax' => 1.5,
                'type_id' => 90000005,
            ],
            [
                'facility_id' => 90000006,
                'owner_id' => 90000007,
                'region_id' => 90000008,
                'solar_system_id' => 90000009,
                'type_id' => 90000010,
            ],
        ]),
    ]);

    $result = (new Esi)->getIndustryFacilities();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(IndustryFacility::class)
        ->and($result->data[0]->facility_id)->toBe(90000001)
        ->and($result->data[0]->owner_id)->toBe(90000002)
        ->and($result->data[0]->region_id)->toBe(90000003)
        ->and($result->data[0]->solar_system_id)->toBe(90000004)
        ->and($result->data[0]->tax)->toBe(1.5)
        ->and($result->data[0]->type_id)->toBe(90000005)
        ->and($result->data[1]->tax)->toBeNull();
});

it('fetches and maps industry systems with their cost indices', function (): void {
    Http::fake([
        'esi.evetech.net/industry/systems*' => Http::response([
            [
                'solar_system_id' => 90000001,
                'cost_indices' => [
                    ['activity' => 'copying', 'cost_index' => 1.5],
                    ['activity' => 'manufacturing', 'cost_index' => 2.5],
                ],
            ],
            [
                'solar_system_id' => 90000002,
                'cost_indices' => [],
            ],
        ]),
    ]);

    $result = (new Esi)->getIndustrySystems();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(IndustrySystem::class)
        ->and($result->data[0]->solar_system_id)->toBe(90000001)
        ->and($result->data[0]->cost_indices)->toHaveCount(2)
        ->and($result->data[0]->cost_indices[0]->activity)->toBe('copying')
        ->and($result->data[0]->cost_indices[0]->cost_index)->toBe(1.5)
        ->and($result->data[0]->cost_indices[1]->activity)->toBe('manufacturing')
        ->and($result->data[0]->cost_indices[1]->cost_index)->toBe(2.5)
        ->and($result->data[1]->cost_indices)->toBe([]);
});

it('fetches and maps character industry jobs', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/industry/jobs*' => Http::response([
            [
                'job_id' => 1,
                'installer_id' => 2,
                'facility_id' => 3,
                'activity_id' => 4,
                'blueprint_id' => 5,
                'blueprint_type_id' => 6,
                'blueprint_location_id' => 7,
                'output_location_id' => 8,
                'runs' => 9,
                'status' => 'active',
                'duration' => 10,
                'start_date' => '2026-06-09T12:00:00Z',
                'end_date' => '2026-06-10T12:00:00Z',
                'station_id' => 11,
                'cost' => 1.5,
                'licensed_runs' => 12,
                'probability' => 0.5,
                'product_type_id' => 13,
                'completed_character_id' => 14,
                'completed_date' => '2026-06-11T12:00:00Z',
                'pause_date' => '2026-06-12T12:00:00Z',
                'successful_runs' => 15,
            ],
            [
                'job_id' => 21,
                'installer_id' => 22,
                'facility_id' => 23,
                'activity_id' => 24,
                'blueprint_id' => 25,
                'blueprint_type_id' => 26,
                'blueprint_location_id' => 27,
                'output_location_id' => 28,
                'runs' => 29,
                'status' => 'active',
                'duration' => 30,
                'start_date' => '2026-06-09T12:00:00Z',
                'end_date' => '2026-06-10T12:00:00Z',
                'station_id' => 31,
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterIndustryJobs(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(IndustryJob::class)
        ->and($result->data[0]->job_id)->toBe(1)
        ->and($result->data[0]->installer_id)->toBe(2)
        ->and($result->data[0]->facility_id)->toBe(3)
        ->and($result->data[0]->activity_id)->toBe(4)
        ->and($result->data[0]->blueprint_id)->toBe(5)
        ->and($result->data[0]->blueprint_type_id)->toBe(6)
        ->and($result->data[0]->blueprint_location_id)->toBe(7)
        ->and($result->data[0]->output_location_id)->toBe(8)
        ->and($result->data[0]->runs)->toBe(9)
        ->and($result->data[0]->status)->toBe('active')
        ->and($result->data[0]->duration)->toBe(10)
        ->and($result->data[0]->start_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->end_date)->toBe('2026-06-10T12:00:00Z')
        ->and($result->data[0]->station_id)->toBe(11)
        ->and($result->data[0]->location_id)->toBeNull()
        ->and($result->data[0]->cost)->toBe(1.5)
        ->and($result->data[0]->licensed_runs)->toBe(12)
        ->and($result->data[0]->probability)->toBe(0.5)
        ->and($result->data[0]->product_type_id)->toBe(13)
        ->and($result->data[0]->completed_character_id)->toBe(14)
        ->and($result->data[0]->completed_date)->toBe('2026-06-11T12:00:00Z')
        ->and($result->data[0]->pause_date)->toBe('2026-06-12T12:00:00Z')
        ->and($result->data[0]->successful_runs)->toBe(15)
        ->and($result->data[1]->cost)->toBeNull()
        ->and($result->data[1]->licensed_runs)->toBeNull()
        ->and($result->data[1]->probability)->toBeNull()
        ->and($result->data[1]->product_type_id)->toBeNull()
        ->and($result->data[1]->completed_character_id)->toBeNull()
        ->and($result->data[1]->completed_date)->toBeNull()
        ->and($result->data[1]->pause_date)->toBeNull()
        ->and($result->data[1]->successful_runs)->toBeNull();
});

it('fetches and maps paginated corporation industry jobs', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/industry/jobs*' => Http::response([
            [
                'job_id' => 1,
                'installer_id' => 2,
                'facility_id' => 3,
                'activity_id' => 4,
                'blueprint_id' => 5,
                'blueprint_type_id' => 6,
                'blueprint_location_id' => 7,
                'output_location_id' => 8,
                'runs' => 9,
                'status' => 'active',
                'duration' => 10,
                'start_date' => '2026-06-09T12:00:00Z',
                'end_date' => '2026-06-10T12:00:00Z',
                'location_id' => 11,
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationIndustryJobs(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(IndustryJob::class)
        ->and($result->data[0]->job_id)->toBe(1)
        ->and($result->data[0]->location_id)->toBe(11)
        ->and($result->data[0]->station_id)->toBeNull();
});

it('fetches and maps paginated character mining ledger entries', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mining*' => Http::response([
            [
                'date' => '2026-06-09',
                'quantity' => 100,
                'solar_system_id' => 90000001,
                'type_id' => 90000002,
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCharacterMining(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MiningLedgerEntry::class)
        ->and($result->data[0]->date)->toBe('2026-06-09')
        ->and($result->data[0]->quantity)->toBe(100)
        ->and($result->data[0]->solar_system_id)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000002);
});

it('fetches and maps paginated corporation mining extractions using the singular corporation path', function (): void {
    Http::fake([
        'esi.evetech.net/corporation/456/mining/extractions*' => Http::response([
            [
                'structure_id' => 90000001,
                'moon_id' => 90000002,
                'extraction_start_time' => '2026-06-09T12:00:00Z',
                'chunk_arrival_time' => '2026-06-10T12:00:00Z',
                'natural_decay_time' => '2026-06-11T12:00:00Z',
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationMiningExtractions(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MiningExtraction::class)
        ->and($result->data[0]->structure_id)->toBe(90000001)
        ->and($result->data[0]->moon_id)->toBe(90000002)
        ->and($result->data[0]->extraction_start_time)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->chunk_arrival_time)->toBe('2026-06-10T12:00:00Z')
        ->and($result->data[0]->natural_decay_time)->toBe('2026-06-11T12:00:00Z');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/corporation/456/mining/extractions'));
});

it('fetches and maps paginated corporation mining observers', function (): void {
    Http::fake([
        'esi.evetech.net/corporation/456/mining/observers*' => Http::response([
            [
                'last_updated' => '2026-06-09',
                'observer_id' => 90000001,
                'observer_type' => 'structure',
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationMiningObservers(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MiningObserver::class)
        ->and($result->data[0]->last_updated)->toBe('2026-06-09')
        ->and($result->data[0]->observer_id)->toBe(90000001)
        ->and($result->data[0]->observer_type)->toBe('structure');
});

it('fetches and maps paginated corporation mining observer entries', function (): void {
    Http::fake([
        'esi.evetech.net/corporation/456/mining/observers/90000001*' => Http::response([
            [
                'last_updated' => '2026-06-09',
                'character_id' => 90000002,
                'recorded_corporation_id' => 456,
                'type_id' => 90000003,
                'quantity' => 100,
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationMiningObserver(fakeCharacter(), 456, 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MiningObserverEntry::class)
        ->and($result->data[0]->last_updated)->toBe('2026-06-09')
        ->and($result->data[0]->character_id)->toBe(90000002)
        ->and($result->data[0]->recorded_corporation_id)->toBe(456)
        ->and($result->data[0]->type_id)->toBe(90000003)
        ->and($result->data[0]->quantity)->toBe(100);
});

it('returns an error result when an industry endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/industry/facilities*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getIndustryFacilities();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
