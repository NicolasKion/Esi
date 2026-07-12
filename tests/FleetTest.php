<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Fleet;
use NicolasKion\Esi\DTO\FleetInfo;
use NicolasKion\Esi\DTO\FleetMember;
use NicolasKion\Esi\DTO\FleetWing;
use NicolasKion\Esi\Esi;
use NicolasKion\Esi\Requests\CreateFleetSquadRequest;
use NicolasKion\Esi\Requests\CreateFleetWingRequest;
use NicolasKion\Esi\Requests\DeleteFleetSquadRequest;
use NicolasKion\Esi\Requests\DeleteFleetWingRequest;
use NicolasKion\Esi\Requests\InviteFleetMemberRequest;
use NicolasKion\Esi\Requests\KickFleetMemberRequest;
use NicolasKion\Esi\Requests\MoveFleetMemberRequest;
use NicolasKion\Esi\Requests\RenameFleetSquadRequest;
use NicolasKion\Esi\Requests\RenameFleetWingRequest;
use NicolasKion\Esi\Requests\UpdateFleetRequest;

it('fetches and maps the fleet a character belongs to', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fleet/' => Http::response([
            'fleet_boss_id' => 90000001,
            'fleet_id' => 90000002,
            'role' => 'fleet_commander',
            'squad_id' => 90000003,
            'wing_id' => 90000004,
        ]),
    ]);

    $result = (new Esi)->getCharacterFleet(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(FleetInfo::class)
        ->and($result->data->fleet_boss_id)->toBe(90000001)
        ->and($result->data->fleet_id)->toBe(90000002)
        ->and($result->data->role)->toBe('fleet_commander')
        ->and($result->data->squad_id)->toBe(90000003)
        ->and($result->data->wing_id)->toBe(90000004);
});

it('fetches and maps a fleet', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/' => Http::response([
            'is_free_move' => true,
            'is_registered' => true,
            'is_voice_enabled' => true,
            'motd' => 'string',
        ]),
    ]);

    $result = (new Esi)->getFleet(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Fleet::class)
        ->and($result->data->is_free_move)->toBeTrue()
        ->and($result->data->is_registered)->toBeTrue()
        ->and($result->data->is_voice_enabled)->toBeTrue()
        ->and($result->data->motd)->toBe('string');
});

it('fetches and maps fleet members', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/' => Http::response([
            [
                'character_id' => 90000001,
                'join_time' => '2026-06-09T12:00:00Z',
                'role' => 'squad_member',
                'role_name' => 'string',
                'ship_type_id' => 2,
                'solar_system_id' => 3,
                'squad_id' => 4,
                'station_id' => 5,
                'takes_fleet_warp' => true,
                'wing_id' => 6,
            ],
        ]),
    ]);

    $result = (new Esi)->getFleetMembers(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FleetMember::class)
        ->and($result->data[0]->character_id)->toBe(90000001)
        ->and($result->data[0]->join_time)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->role)->toBe('squad_member')
        ->and($result->data[0]->role_name)->toBe('string')
        ->and($result->data[0]->ship_type_id)->toBe(2)
        ->and($result->data[0]->solar_system_id)->toBe(3)
        ->and($result->data[0]->squad_id)->toBe(4)
        ->and($result->data[0]->station_id)->toBe(5)
        ->and($result->data[0]->takes_fleet_warp)->toBeTrue()
        ->and($result->data[0]->wing_id)->toBe(6);
});

it('fetches and maps fleet members without a station id', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/' => Http::response([
            [
                'character_id' => 90000001,
                'join_time' => '2026-06-09T12:00:00Z',
                'role' => 'squad_member',
                'role_name' => 'string',
                'ship_type_id' => 2,
                'solar_system_id' => 3,
                'squad_id' => 4,
                'takes_fleet_warp' => false,
                'wing_id' => 6,
            ],
        ]),
    ]);

    $result = (new Esi)->getFleetMembers(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data[0]->station_id)->toBeNull()
        ->and($result->data[0]->takes_fleet_warp)->toBeFalse();
});

it('fetches and maps fleet wings with nested squads', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/wings/' => Http::response([
            [
                'id' => 90000001,
                'name' => 'Wing 1',
                'squads' => [
                    ['id' => 90000002, 'name' => 'Squad 1'],
                ],
            ],
        ]),
    ]);

    $result = (new Esi)->getFleetWings(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FleetWing::class)
        ->and($result->data[0]->id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('Wing 1')
        ->and($result->data[0]->squads)->toHaveCount(1)
        ->and($result->data[0]->squads[0]->id)->toBe(90000002)
        ->and($result->data[0]->squads[0]->name)->toBe('Squad 1');
});

it('updates a fleet with only the provided fields', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->updateFleet(fakeCharacter(), 1, true, 'New MOTD');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeNull();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/fleets/1/')
        && $request->data() === [
            'is_free_move' => true,
            'motd' => 'New MOTD',
        ]);
});

it('updates a fleet omitting null fields', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->updateFleet(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/fleets/1/')
        && $request->data() === []);
});

it('invites a fleet member', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->inviteFleetMember(fakeCharacter(), 1, 90000001, 'squad_member', 2, 3);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/fleets/1/members/')
        && $request->data() === [
            'character_id' => 90000001,
            'role' => 'squad_member',
            'squad_id' => 2,
            'wing_id' => 3,
        ]);
});

it('invites a fleet member without optional squad and wing', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->inviteFleetMember(fakeCharacter(), 1, 90000001, 'fleet_commander');

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request->data() === [
            'character_id' => 90000001,
            'role' => 'fleet_commander',
        ]);
});

it('kicks a fleet member', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/90000001/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->kickFleetMember(fakeCharacter(), 1, 90000001);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/fleets/1/members/90000001/'));
});

it('moves a fleet member', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/90000001/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->moveFleetMember(fakeCharacter(), 1, 90000001, 'squad_commander', 2, 3);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/fleets/1/members/90000001/')
        && $request->data() === [
            'role' => 'squad_commander',
            'squad_id' => 2,
            'wing_id' => 3,
        ]);
});

it('moves a fleet member without optional squad and wing', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/members/90000001/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->moveFleetMember(fakeCharacter(), 1, 90000001, 'fleet_commander');

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->data() === [
        'role' => 'fleet_commander',
    ]);
});

it('creates a fleet wing and returns the new wing id', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/wings/' => Http::response(['wing_id' => 90000005], 201),
    ]);

    $result = (new Esi)->createFleetWing(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(90000005);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/fleets/1/wings/'));
});

it('deletes a fleet wing', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/wings/90000005/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->deleteFleetWing(fakeCharacter(), 1, 90000005);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/fleets/1/wings/90000005/'));
});

it('renames a fleet wing', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/wings/90000005/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->renameFleetWing(fakeCharacter(), 1, 90000005, 'Interceptors');

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/fleets/1/wings/90000005/')
        && $request->data() === ['name' => 'Interceptors']);
});

it('creates a fleet squad and returns the new squad id', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/wings/90000005/squads/' => Http::response(['squad_id' => 90000006], 201),
    ]);

    $result = (new Esi)->createFleetSquad(fakeCharacter(), 1, 90000005);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(90000006);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/fleets/1/wings/90000005/squads/'));
});

it('deletes a fleet squad', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/squads/90000006/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->deleteFleetSquad(fakeCharacter(), 1, 90000006);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/fleets/1/squads/90000006/'));
});

it('renames a fleet squad', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/squads/90000006/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->renameFleetSquad(fakeCharacter(), 1, 90000006, 'Bombers');

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/fleets/1/squads/90000006/')
        && $request->data() === ['name' => 'Bombers']);
});

it('returns an error result when a fleet endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/fleets/1/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getFleet(fakeCharacter(), 1);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('never retries fleet member and wing/squad creation or deletion requests', function (): void {
    $serverError = new Response(new Psr7Response(500));

    expect((new InviteFleetMemberRequest(1, 2, 'squad_member'))->shouldRetry($serverError))->toBeFalse()
        ->and((new KickFleetMemberRequest(1, 2))->shouldRetry($serverError))->toBeFalse()
        ->and((new CreateFleetWingRequest(1))->shouldRetry($serverError))->toBeFalse()
        ->and((new DeleteFleetWingRequest(1, 2))->shouldRetry($serverError))->toBeFalse()
        ->and((new CreateFleetSquadRequest(1, 2))->shouldRetry($serverError))->toBeFalse()
        ->and((new DeleteFleetSquadRequest(1, 2))->shouldRetry($serverError))->toBeFalse();
});

it('always retries fleet and member/wing/squad state-setting requests', function (): void {
    $serverError = new Response(new Psr7Response(500));

    expect((new UpdateFleetRequest(1))->shouldRetry($serverError))->toBeTrue()
        ->and((new MoveFleetMemberRequest(1, 2, 'squad_member'))->shouldRetry($serverError))->toBeTrue()
        ->and((new RenameFleetWingRequest(1, 2, 'name'))->shouldRetry($serverError))->toBeTrue()
        ->and((new RenameFleetSquadRequest(1, 2, 'name'))->shouldRetry($serverError))->toBeTrue();
});
