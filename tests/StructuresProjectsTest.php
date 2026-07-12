<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CorporationProject;
use NicolasKion\Esi\DTO\MercenaryDen;
use NicolasKion\Esi\DTO\ProjectContribution;
use NicolasKion\Esi\DTO\ProjectContributor;
use NicolasKion\Esi\DTO\Skyhook;
use NicolasKion\Esi\DTO\SovereigntyHub;
use NicolasKion\Esi\Esi;

it('fetches and maps a sparse listing of a character\'s Mercenary Dens', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/structures/mercenary-dens' => Http::response([
            'mercenary_dens' => [
                ['id' => 1000000000001, 'planet_id' => 40000002],
            ],
        ]),
    ]);

    $result = (new Esi)->getMercenaryDens(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MercenaryDen::class)
        ->and($result->data[0]->id)->toBe(1000000000001)
        ->and($result->data[0]->planet_id)->toBe(40000002)
        ->and($result->data[0]->state)->toBeNull()
        ->and($result->data[0]->type_id)->toBeNull()
        ->and($result->data[0]->skyhook)->toBeNull()
        ->and($result->data[0]->infomorphs)->toBeNull()
        ->and($result->data[0]->evolution)->toBeNull()
        ->and($result->data[0]->reinforcement_timer_end)->toBeNull();
});

it('fetches and maps the full detail of a character\'s Mercenary Den', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/structures/mercenary-dens/1000000000001' => Http::response([
            'id' => 1000000000001,
            'skyhook' => ['id' => 1000000000002, 'planet_id' => 40000003, 'corporation_id' => 98777771],
            'state' => 'Running',
            'type_id' => 587,
            'infomorphs' => ['amount' => 100],
            'evolution' => [
                'anarchy' => ['amount' => 0, 'level' => 'Level0'],
                'development' => ['amount' => 50, 'level' => 'Level2'],
            ],
            'reinforcement_timer' => ['end' => '2026-06-09T12:00:00Z'],
        ]),
    ]);

    $result = (new Esi)->getMercenaryDen(fakeCharacter(), 1000000000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MercenaryDen::class)
        ->and($result->data->id)->toBe(1000000000001)
        ->and($result->data->planet_id)->toBeNull()
        ->and($result->data->state)->toBe('Running')
        ->and($result->data->type_id)->toBe(587)
        ->and($result->data->skyhook?->id)->toBe(1000000000002)
        ->and($result->data->skyhook?->planet_id)->toBe(40000003)
        ->and($result->data->skyhook?->corporation_id)->toBe(98777771)
        ->and($result->data->infomorphs?->amount)->toBe(100)
        ->and($result->data->evolution?->anarchy->amount)->toBe(0)
        ->and($result->data->evolution?->anarchy->level)->toBe('Level0')
        ->and($result->data->evolution?->development->amount)->toBe(50)
        ->and($result->data->evolution?->development->level)->toBe('Level2')
        ->and($result->data->reinforcement_timer_end)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps a sparse listing of a corporation\'s Skyhooks', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/structures/skyhooks' => Http::response([
            'skyhooks' => [
                ['id' => 2000000000001, 'planet_id' => 40000004],
            ],
        ]),
    ]);

    $result = (new Esi)->getCorporationSkyhooks(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Skyhook::class)
        ->and($result->data[0]->id)->toBe(2000000000001)
        ->and($result->data[0]->planet_id)->toBe(40000004)
        ->and($result->data[0]->effective_workforce)->toBeNull()
        ->and($result->data[0]->is_active)->toBeNull()
        ->and($result->data[0]->state)->toBeNull()
        ->and($result->data[0]->reagents)->toBe([])
        ->and($result->data[0]->reinforcement_timer_end)->toBeNull()
        ->and($result->data[0]->theft_vulnerability)->toBeNull();
});

it('fetches and maps the full detail of a corporation\'s Skyhook', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/structures/skyhooks/2000000000001' => Http::response([
            'id' => 2000000000001,
            'planet_id' => 40000004,
            'effective_workforce' => 1000,
            'is_active' => true,
            'reagents' => [
                ['type_id' => 587, 'secured_stock' => 1000, 'unsecured_stock' => 300, 'last_cycle' => '2026-02-23T12:00:00Z'],
            ],
            'reinforcement_timer' => ['end' => '2026-02-23T16:00:00Z'],
            'state' => 'ShieldVulnerable',
            'theft_vulnerability' => ['start' => '2026-02-23T12:00:00Z', 'end' => '2026-02-23T16:00:00Z'],
        ]),
    ]);

    $result = (new Esi)->getCorporationSkyhook(fakeCharacter(), 456, 2000000000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Skyhook::class)
        ->and($result->data->id)->toBe(2000000000001)
        ->and($result->data->planet_id)->toBe(40000004)
        ->and($result->data->effective_workforce)->toBe(1000)
        ->and($result->data->is_active)->toBeTrue()
        ->and($result->data->state)->toBe('ShieldVulnerable')
        ->and($result->data->reagents)->toHaveCount(1)
        ->and($result->data->reagents[0]->type_id)->toBe(587)
        ->and($result->data->reagents[0]->secured_stock)->toBe(1000)
        ->and($result->data->reagents[0]->unsecured_stock)->toBe(300)
        ->and($result->data->reagents[0]->last_cycle)->toBe('2026-02-23T12:00:00Z')
        ->and($result->data->reinforcement_timer_end)->toBe('2026-02-23T16:00:00Z')
        ->and($result->data->theft_vulnerability?->start)->toBe('2026-02-23T12:00:00Z')
        ->and($result->data->theft_vulnerability?->end)->toBe('2026-02-23T16:00:00Z');
});

it('fetches and maps a sparse listing of a corporation\'s Sovereignty Hubs', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/structures/sovereignty-hubs' => Http::response([
            'sovereignty_hubs' => [
                ['id' => 3000000000001, 'solar_system_id' => 30000001],
            ],
        ]),
    ]);

    $result = (new Esi)->getCorporationSovereigntyHubs(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(SovereigntyHub::class)
        ->and($result->data[0]->id)->toBe(3000000000001)
        ->and($result->data[0]->solar_system_id)->toBe(30000001)
        ->and($result->data[0]->fuel_access_list_id)->toBeNull()
        ->and($result->data[0]->reagent_bay)->toBeNull()
        ->and($result->data[0]->resources)->toBeNull()
        ->and($result->data[0]->upgrades)->toBe([])
        ->and($result->data[0]->vulnerability_window)->toBeNull()
        ->and($result->data[0]->workforce_transport)->toBeNull();
});

it('fetches and maps the full detail of a corporation\'s Sovereignty Hub', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/structures/sovereignty-hubs/3000000000001' => Http::response([
            'fuel_access_list_id' => 1,
            'id' => 3000000000001,
            'reagent_bay' => [
                'last_updated' => '2026-02-23T12:00:00Z',
                'reagents' => [
                    ['amount' => 1000, 'burning_per_hour' => 10, 'type_id' => 587],
                ],
            ],
            'resources' => [
                'power' => ['allocated' => 100, 'available' => 1000],
                'workforce' => ['allocated' => 200, 'available' => 2000],
            ],
            'solar_system_id' => 30000001,
            'upgrades' => [
                ['power_state' => 'Online', 'type_id' => 587],
            ],
            'vulnerability_window' => ['start' => '2026-02-23T12:00:00Z', 'end' => '2026-02-23T16:00:00Z'],
            'workforce_transport' => [
                'configuration' => [
                    'import' => ['sources' => [['solar_system_id' => 30000002]]],
                ],
                'state' => [
                    'export' => ['amount' => 500, 'solar_system_id' => 30000003],
                ],
            ],
        ]),
    ]);

    $result = (new Esi)->getCorporationSovereigntyHub(fakeCharacter(), 456, 3000000000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(SovereigntyHub::class)
        ->and($result->data->id)->toBe(3000000000001)
        ->and($result->data->solar_system_id)->toBe(30000001)
        ->and($result->data->fuel_access_list_id)->toBe(1)
        ->and($result->data->reagent_bay?->last_updated)->toBe('2026-02-23T12:00:00Z')
        ->and($result->data->reagent_bay?->reagents)->toHaveCount(1)
        ->and($result->data->reagent_bay?->reagents[0]->amount)->toBe(1000)
        ->and($result->data->reagent_bay?->reagents[0]->burning_per_hour)->toBe(10)
        ->and($result->data->reagent_bay?->reagents[0]->type_id)->toBe(587)
        ->and($result->data->resources?->power->allocated)->toBe(100)
        ->and($result->data->resources?->power->available)->toBe(1000)
        ->and($result->data->resources?->workforce->allocated)->toBe(200)
        ->and($result->data->resources?->workforce->available)->toBe(2000)
        ->and($result->data->upgrades)->toHaveCount(1)
        ->and($result->data->upgrades[0]->power_state)->toBe('Online')
        ->and($result->data->upgrades[0]->type_id)->toBe(587)
        ->and($result->data->vulnerability_window?->start)->toBe('2026-02-23T12:00:00Z')
        ->and($result->data->vulnerability_window?->end)->toBe('2026-02-23T16:00:00Z')
        ->and($result->data->workforce_transport?->configuration?->import?->sources[0]->solar_system_id)->toBe(30000002)
        ->and($result->data->workforce_transport?->configuration?->import?->sources[0]->amount)->toBeNull()
        ->and($result->data->workforce_transport?->configuration?->export)->toBeNull()
        ->and($result->data->workforce_transport?->configuration?->transit)->toBeNull()
        ->and($result->data->workforce_transport?->state?->export?->amount)->toBe(500)
        ->and($result->data->workforce_transport?->state?->export?->solar_system_id)->toBe(30000003)
        ->and($result->data->workforce_transport?->state?->import)->toBeNull();
});

it('fetches and maps a listing of corporation projects', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/projects*' => Http::sequence()
            ->push([
                'cursor' => ['after' => 'a', 'before' => 'b'],
                'projects' => [
                    [
                        'id' => '3868eaed-8278-4cb7-9709-7d7de9c20dc7',
                        'last_modified' => '2025-06-01T00:00:00Z',
                        'name' => 'Project Name',
                        'progress' => ['current' => 50, 'desired' => 100],
                        'reward' => ['initial' => 12345.5, 'remaining' => 5432.1],
                        'state' => 'Active',
                    ],
                ],
            ])
            ->push(['cursor' => ['after' => ''], 'projects' => []]),
    ]);

    $result = (new Esi)->getCorporationProjects(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CorporationProject::class)
        ->and($result->data[0]->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7')
        ->and($result->data[0]->name)->toBe('Project Name')
        ->and($result->data[0]->state)->toBe('Active')
        ->and($result->data[0]->last_modified)->toBe('2025-06-01T00:00:00Z')
        ->and($result->data[0]->progress->current)->toBe(50)
        ->and($result->data[0]->progress->desired)->toBe(100)
        ->and($result->data[0]->reward?->initial)->toBe(12345.5)
        ->and($result->data[0]->reward?->remaining)->toBe(5432.1)
        ->and($result->data[0]->creator)->toBeNull()
        ->and($result->data[0]->details)->toBeNull()
        ->and($result->data[0]->configuration)->toBeNull()
        ->and($result->data[0]->contribution)->toBeNull();
});

it('fetches and maps the full detail of a corporation project', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/projects/3868eaed-8278-4cb7-9709-7d7de9c20dc7' => Http::response([
            'configuration' => [
                'capture_fw_complex' => [
                    'archetypes' => [['archetype_id' => 33]],
                    'factions' => [['faction_id' => 500002]],
                    'locations' => [['solar_system_id' => 30000001]],
                ],
            ],
            'contribution' => [
                'participation_limit' => 1000,
                'reward_per_contribution' => 123.5,
                'submission_limit' => 100,
                'submission_multiplier' => 1.5,
            ],
            'creator' => ['id' => 90000001, 'name' => 'Creator Name'],
            'details' => [
                'career' => 'Explorer',
                'created' => '2025-06-01T00:00:00Z',
                'description' => 'Project Description',
                'expires' => '2025-06-01T00:01:00Z',
                'finished' => '2025-06-01T00:00:00Z',
            ],
            'id' => '3868eaed-8278-4cb7-9709-7d7de9c20dc7',
            'last_modified' => '2025-06-01T00:00:00Z',
            'name' => 'Project Name',
            'progress' => ['current' => 50, 'desired' => 100],
            'reward' => ['initial' => 12345.5, 'remaining' => 5432.1],
            'state' => 'Active',
        ]),
    ]);

    $result = (new Esi)->getCorporationProject(fakeCharacter(), 456, '3868eaed-8278-4cb7-9709-7d7de9c20dc7');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CorporationProject::class)
        ->and($result->data->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7')
        ->and($result->data->name)->toBe('Project Name')
        ->and($result->data->state)->toBe('Active')
        ->and($result->data->progress->current)->toBe(50)
        ->and($result->data->reward?->initial)->toBe(12345.5)
        ->and($result->data->creator?->id)->toBe(90000001)
        ->and($result->data->creator?->name)->toBe('Creator Name')
        ->and($result->data->details?->career)->toBe('Explorer')
        ->and($result->data->details?->created)->toBe('2025-06-01T00:00:00Z')
        ->and($result->data->details?->description)->toBe('Project Description')
        ->and($result->data->details?->expires)->toBe('2025-06-01T00:01:00Z')
        ->and($result->data->details?->finished)->toBe('2025-06-01T00:00:00Z')
        ->and($result->data->configuration)->toBe([
            'capture_fw_complex' => [
                'archetypes' => [['archetype_id' => 33]],
                'factions' => [['faction_id' => 500002]],
                'locations' => [['solar_system_id' => 30000001]],
            ],
        ])
        ->and($result->data->contribution?->participation_limit)->toBe(1000)
        ->and($result->data->contribution?->reward_per_contribution)->toBe(123.5)
        ->and($result->data->contribution?->submission_limit)->toBe(100)
        ->and($result->data->contribution?->submission_multiplier)->toBe(1.5);
});

it('fetches and maps a character\'s contribution to a corporation project', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/projects/3868eaed-8278-4cb7-9709-7d7de9c20dc7/contribution/90000002' => Http::response([
            'contributed' => 10,
            'last_modified' => '2025-08-26T00:00:00Z',
        ]),
    ]);

    $result = (new Esi)->getCorporationProjectContribution(fakeCharacter(), 456, '3868eaed-8278-4cb7-9709-7d7de9c20dc7', 90000002);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(ProjectContribution::class)
        ->and($result->data->contributed)->toBe(10)
        ->and($result->data->last_modified)->toBe('2025-08-26T00:00:00Z');
});

it('fetches and maps the contributors to a corporation project', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/projects/3868eaed-8278-4cb7-9709-7d7de9c20dc7/contributors*' => Http::sequence()
            ->push([
                'contributors' => [
                    ['contributed' => 10, 'id' => 90000001, 'name' => 'Contributor Name'],
                ],
                'cursor' => ['after' => 'a', 'before' => 'b'],
            ])
            ->push(['contributors' => [], 'cursor' => ['after' => '']]),
    ]);

    $result = (new Esi)->getCorporationProjectContributors(fakeCharacter(), 456, '3868eaed-8278-4cb7-9709-7d7de9c20dc7');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ProjectContributor::class)
        ->and($result->data[0]->id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('Contributor Name')
        ->and($result->data[0]->contributed)->toBe(10);
});

it('returns an error result when a structures/projects endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/structures/skyhooks' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCorporationSkyhooks(fakeCharacter(), 456);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
