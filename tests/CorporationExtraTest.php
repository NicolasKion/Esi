<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\AllianceHistory;
use NicolasKion\Esi\DTO\Blueprint;
use NicolasKion\Esi\DTO\ContainerLog;
use NicolasKion\Esi\DTO\CorporationIcons;
use NicolasKion\Esi\DTO\CorporationMedal;
use NicolasKion\Esi\DTO\CorporationRoles;
use NicolasKion\Esi\DTO\CorporationTitle;
use NicolasKion\Esi\DTO\Facility;
use NicolasKion\Esi\DTO\IssuedMedal;
use NicolasKion\Esi\DTO\MemberTitles;
use NicolasKion\Esi\DTO\MemberTracking;
use NicolasKion\Esi\DTO\RoleHistory;
use NicolasKion\Esi\DTO\Shareholder;
use NicolasKion\Esi\DTO\Standing;
use NicolasKion\Esi\DTO\Starbase;
use NicolasKion\Esi\DTO\StarbaseDetail;
use NicolasKion\Esi\Esi;

it('fetches the list of NPC corporation IDs', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/npccorps/' => Http::response([1000001, 1000002]),
    ]);

    $result = (new Esi)->getNpcCorporations();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1000001, 1000002]);
});

it('fetches and maps a corporation alliance history', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/alliancehistory/' => Http::response(esiFixture('corporations/alliancehistory.json')),
    ]);

    $result = (new Esi)->getCorporationAllianceHistory(456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(AllianceHistory::class)
        ->and($result->data[0]->alliance_id)->toBe(90000001)
        ->and($result->data[0]->is_deleted)->toBeTrue()
        ->and($result->data[0]->record_id)->toBe(90000001)
        ->and($result->data[0]->start_date)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps corporation icons', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/icons/' => Http::response(esiFixture('corporations/icons.json')),
    ]);

    $result = (new Esi)->getCorporationIcons(456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CorporationIcons::class)
        ->and($result->data->px128x128)->toBe('string')
        ->and($result->data->px256x256)->toBe('string')
        ->and($result->data->px64x64)->toBe('string');
});

it('fetches and maps paginated corporation blueprints', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/blueprints/*' => Http::response([
            [
                'item_id' => 1,
                'location_flag' => 'AssetSafety',
                'location_id' => 2,
                'material_efficiency' => 3,
                'quantity' => 4,
                'runs' => 5,
                'time_efficiency' => 6,
                'type_id' => 7,
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationBlueprints(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Blueprint::class)
        ->and($result->data[0]->item_id)->toBe(1)
        ->and($result->data[0]->location_flag)->toBe('AssetSafety')
        ->and($result->data[0]->location_id)->toBe(2)
        ->and($result->data[0]->material_efficiency)->toBe(3)
        ->and($result->data[0]->quantity)->toBe(4)
        ->and($result->data[0]->runs)->toBe(5)
        ->and($result->data[0]->time_efficiency)->toBe(6)
        ->and($result->data[0]->type_id)->toBe(7);
});

it('fetches and maps paginated corporation container logs', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/containers/logs/*' => Http::response([
            [
                'action' => 'add',
                'character_id' => 90000001,
                'container_id' => 90000002,
                'container_type_id' => 90000003,
                'location_flag' => 'AssetSafety',
                'location_id' => 90000004,
                'logged_at' => '2026-06-09T12:00:00Z',
                'new_config_bitmask' => 1,
                'old_config_bitmask' => 2,
                'password_type' => 'config',
                'quantity' => 3,
                'type_id' => 90000005,
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationContainerLogs(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ContainerLog::class)
        ->and($result->data[0]->action)->toBe('add')
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->container_id)->toBe(90000002)
        ->and($result->data[0]->container_type_id)->toBe(90000003)
        ->and($result->data[0]->location_flag)->toBe('AssetSafety')
        ->and($result->data[0]->location_id)->toBe(90000004)
        ->and($result->data[0]->logged_at)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->new_config_bitmask)->toBe(1)
        ->and($result->data[0]->old_config_bitmask)->toBe(2)
        ->and($result->data[0]->password_type)->toBe('config')
        ->and($result->data[0]->quantity)->toBe(3)
        ->and($result->data[0]->type_id)->toBe(90000005);
});

it('fetches and maps corporation facilities', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/facilities/' => Http::response([
            ['facility_id' => 1, 'system_id' => 2, 'type_id' => 3],
        ]),
    ]);

    $result = (new Esi)->getCorporationFacilities(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Facility::class)
        ->and($result->data[0]->facility_id)->toBe(1)
        ->and($result->data[0]->system_id)->toBe(2)
        ->and($result->data[0]->type_id)->toBe(3);
});

it('fetches and maps paginated corporation medals', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/medals/*' => Http::response([
            [
                'created_at' => '2026-06-09T12:00:00Z',
                'creator_id' => 1,
                'description' => 'string',
                'medal_id' => 2,
                'title' => 'string',
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationMedals(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CorporationMedal::class)
        ->and($result->data[0]->created_at)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->creator_id)->toBe(1)
        ->and($result->data[0]->description)->toBe('string')
        ->and($result->data[0]->medal_id)->toBe(2)
        ->and($result->data[0]->title)->toBe('string');
});

it('fetches and maps paginated corporation issued medals', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/medals/issued/*' => Http::response([
            [
                'character_id' => 1,
                'issued_at' => '2026-06-09T12:00:00Z',
                'issuer_id' => 2,
                'medal_id' => 3,
                'reason' => 'string',
                'status' => 'private',
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationIssuedMedals(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(IssuedMedal::class)
        ->and($result->data[0]->character_id)->toBe(1)
        ->and($result->data[0]->issued_at)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->issuer_id)->toBe(2)
        ->and($result->data[0]->medal_id)->toBe(3)
        ->and($result->data[0]->reason)->toBe('string')
        ->and($result->data[0]->status)->toBe('private');
});

it('fetches the list of corporation member character IDs', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/members/' => Http::response([90000001, 90000002]),
    ]);

    $result = (new Esi)->getCorporationMembers(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([90000001, 90000002]);
});

it('fetches the corporation member limit', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/members/limit/' => Http::response('9001', 200, ['Content-Type' => 'application/json']),
    ]);

    $result = (new Esi)->getCorporationMemberLimit(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(9001);
});

it('fetches and maps corporation member titles', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/members/titles/' => Http::response([
            ['character_id' => 90000001, 'titles' => [1, 2, 3]],
        ]),
    ]);

    $result = (new Esi)->getCorporationMemberTitles(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MemberTitles::class)
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->titles)->toBe([1, 2, 3]);
});

it('fetches and maps corporation member tracking', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/membertracking/' => Http::response([
            [
                'base_id' => 1,
                'character_id' => 90000001,
                'location_id' => 2,
                'logoff_date' => '2026-06-09T12:00:00Z',
                'logon_date' => '2026-06-08T12:00:00Z',
                'ship_type_id' => 3,
                'start_date' => '2026-06-01T12:00:00Z',
            ],
        ]),
    ]);

    $result = (new Esi)->getCorporationMemberTracking(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MemberTracking::class)
        ->and($result->data[0]->base_id)->toBe(1)
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->location_id)->toBe(2)
        ->and($result->data[0]->logoff_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->logon_date)->toBe('2026-06-08T12:00:00Z')
        ->and($result->data[0]->ship_type_id)->toBe(3)
        ->and($result->data[0]->start_date)->toBe('2026-06-01T12:00:00Z');
});

it('fetches and maps corporation member roles', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/roles/' => Http::response([
            [
                'character_id' => 90000001,
                'grantable_roles' => ['Account_Take_1', 456],
                'grantable_roles_at_base' => ['Account_Take_1'],
                'grantable_roles_at_hq' => ['Account_Take_1'],
                'grantable_roles_at_other' => ['Account_Take_1'],
                'roles' => ['Director'],
                'roles_at_base' => ['Director'],
                'roles_at_hq' => ['Director'],
                'roles_at_other' => ['Director'],
            ],
            [
                // A sparse entry: every role array field is absent.
                'character_id' => 90000002,
            ],
        ]),
    ]);

    $result = (new Esi)->getCorporationRoles(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(CorporationRoles::class)
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->grantable_roles)->toBe(['Account_Take_1', ''])
        ->and($result->data[0]->grantable_roles_at_base)->toBe(['Account_Take_1'])
        ->and($result->data[0]->grantable_roles_at_hq)->toBe(['Account_Take_1'])
        ->and($result->data[0]->grantable_roles_at_other)->toBe(['Account_Take_1'])
        ->and($result->data[0]->roles)->toBe(['Director'])
        ->and($result->data[0]->roles_at_base)->toBe(['Director'])
        ->and($result->data[0]->roles_at_hq)->toBe(['Director'])
        ->and($result->data[0]->roles_at_other)->toBe(['Director'])
        ->and($result->data[1]->character_id)->toBe(90000002)
        ->and($result->data[1]->grantable_roles)->toBe([])
        ->and($result->data[1]->roles)->toBe([]);
});

it('fetches and maps paginated corporation roles history', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/roles/history/*' => Http::response([
            [
                'changed_at' => '2026-06-09T12:00:00Z',
                'character_id' => 90000001,
                'issuer_id' => 90000002,
                'new_roles' => ['Director', 123],
                'old_roles' => ['Accountant'],
                'role_type' => 'grantable_roles',
            ],
            [
                'changed_at' => '2026-06-10T12:00:00Z',
                'character_id' => 90000003,
                'issuer_id' => 90000004,
                'role_type' => 'roles',
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationRolesHistory(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(RoleHistory::class)
        ->and($result->data[0]->changed_at)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->issuer_id)->toBe(90000002)
        ->and($result->data[0]->new_roles)->toBe(['Director', ''])
        ->and($result->data[0]->old_roles)->toBe(['Accountant'])
        ->and($result->data[0]->role_type)->toBe('grantable_roles')
        ->and($result->data[1]->new_roles)->toBe([])
        ->and($result->data[1]->old_roles)->toBe([]);
});

it('fetches and maps paginated corporation shareholders', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/shareholders/*' => Http::response([
            ['share_count' => 1000, 'shareholder_id' => 90000001, 'shareholder_type' => 'character'],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationShareholders(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Shareholder::class)
        ->and($result->data[0]->share_count)->toBe(1000)
        ->and($result->data[0]->shareholder_id)->toBe(90000001)
        ->and($result->data[0]->shareholder_type)->toBe('character');
});

it('fetches and maps paginated corporation standings', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/standings/*' => Http::response([
            ['from_id' => 90000001, 'from_type' => 'agent', 'standing' => 1.5],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationStandings(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Standing::class)
        ->and($result->data[0]->from_id)->toBe(90000001)
        ->and($result->data[0]->from_type)->toBe('agent')
        ->and($result->data[0]->standing)->toBe(1.5);
});

it('fetches and maps paginated corporation starbases', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/starbases/*' => Http::response([
            [
                'moon_id' => 1,
                'onlined_since' => '2026-06-09T12:00:00Z',
                'reinforced_until' => '2026-06-10T12:00:00Z',
                'starbase_id' => 90000001,
                'state' => 'online',
                'system_id' => 2,
                'type_id' => 3,
                'unanchor_at' => '2026-06-11T12:00:00Z',
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationStarbases(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Starbase::class)
        ->and($result->data[0]->moon_id)->toBe(1)
        ->and($result->data[0]->onlined_since)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->reinforced_until)->toBe('2026-06-10T12:00:00Z')
        ->and($result->data[0]->starbase_id)->toBe(90000001)
        ->and($result->data[0]->state)->toBe('online')
        ->and($result->data[0]->system_id)->toBe(2)
        ->and($result->data[0]->type_id)->toBe(3)
        ->and($result->data[0]->unanchor_at)->toBe('2026-06-11T12:00:00Z');
});

it('fetches and maps a single corporation starbase with the required system_id query param', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/starbases/90000001/*' => Http::response(esiFixture('corporations/starbase.json')),
    ]);

    $result = (new Esi)->getCorporationStarbase(fakeCharacter(), 456, 90000001, 30000142);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(StarbaseDetail::class)
        ->and($result->data->allow_alliance_members)->toBeTrue()
        ->and($result->data->allow_corporation_members)->toBeTrue()
        ->and($result->data->anchor)->toBe('alliance_member')
        ->and($result->data->attack_if_at_war)->toBeTrue()
        ->and($result->data->attack_if_other_security_status_dropping)->toBeTrue()
        ->and($result->data->attack_security_status_threshold)->toBe(1.5)
        ->and($result->data->attack_standing_threshold)->toBe(1.5)
        ->and($result->data->fuel_bay_take)->toBe('alliance_member')
        ->and($result->data->fuel_bay_view)->toBe('alliance_member')
        ->and($result->data->fuels)->toHaveCount(1)
        ->and($result->data->fuels[0]->quantity)->toBe(90000001)
        ->and($result->data->fuels[0]->type_id)->toBe(90000001)
        ->and($result->data->offline)->toBe('alliance_member')
        ->and($result->data->online)->toBe('alliance_member')
        ->and($result->data->unanchor)->toBe('alliance_member')
        ->and($result->data->use_alliance_standings)->toBeTrue();

    Http::assertSent(fn ($request) => str_contains($request->url(), 'system_id=30000142'));
});

it('fetches and maps corporation titles', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/titles/' => Http::response([
            [
                'grantable_roles' => ['Account_Take_1', 456],
                'grantable_roles_at_base' => ['Account_Take_1'],
                'grantable_roles_at_hq' => ['Account_Take_1'],
                'grantable_roles_at_other' => ['Account_Take_1'],
                'name' => 'string',
                'roles' => ['Director'],
                'roles_at_base' => ['Director'],
                'roles_at_hq' => ['Director'],
                'roles_at_other' => ['Director'],
                'title_id' => 90000001,
            ],
            [
                // A sparse entry: every array field is absent, name/title_id are null.
            ],
        ]),
    ]);

    $result = (new Esi)->getCorporationTitles(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(CorporationTitle::class)
        ->and($result->data[0]->grantable_roles)->toBe(['Account_Take_1', ''])
        ->and($result->data[0]->grantable_roles_at_base)->toBe(['Account_Take_1'])
        ->and($result->data[0]->grantable_roles_at_hq)->toBe(['Account_Take_1'])
        ->and($result->data[0]->grantable_roles_at_other)->toBe(['Account_Take_1'])
        ->and($result->data[0]->name)->toBe('string')
        ->and($result->data[0]->roles)->toBe(['Director'])
        ->and($result->data[0]->roles_at_base)->toBe(['Director'])
        ->and($result->data[0]->roles_at_hq)->toBe(['Director'])
        ->and($result->data[0]->roles_at_other)->toBe(['Director'])
        ->and($result->data[0]->title_id)->toBe(90000001)
        ->and($result->data[1]->grantable_roles)->toBe([])
        ->and($result->data[1]->roles)->toBe([])
        ->and($result->data[1]->name)->toBeNull()
        ->and($result->data[1]->title_id)->toBeNull();
});

it('returns an error result when a corporation endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/facilities/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCorporationFacilities(fakeCharacter(), 456);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
