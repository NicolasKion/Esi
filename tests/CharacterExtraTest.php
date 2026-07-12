<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\AgentResearch;
use NicolasKion\Esi\DTO\Blueprint;
use NicolasKion\Esi\DTO\CharacterMedal;
use NicolasKion\Esi\DTO\CharacterPortrait;
use NicolasKion\Esi\DTO\CharacterRoles;
use NicolasKion\Esi\DTO\CharacterTitle;
use NicolasKion\Esi\DTO\ContactNotification;
use NicolasKion\Esi\DTO\CorporationHistory;
use NicolasKion\Esi\DTO\JumpFatigue;
use NicolasKion\Esi\DTO\Notification;
use NicolasKion\Esi\DTO\Standing;
use NicolasKion\Esi\Esi;

it('fetches and maps a character corporation history', function (): void {
    Http::fake([
        'esi.evetech.net/characters/90000001/corporationhistory/' => Http::response([
            [
                'corporation_id' => 98777771,
                'is_deleted' => true,
                'record_id' => 1,
                'start_date' => '2026-06-09T12:00:00Z',
            ],
            [
                // A sparse entry: is_deleted is absent.
                'corporation_id' => 98777772,
                'record_id' => 2,
                'start_date' => '2026-05-09T12:00:00Z',
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterCorporationHistory(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(CorporationHistory::class)
        ->and($result->data[0]->corporation_id)->toBe(98777771)
        ->and($result->data[0]->is_deleted)->toBeTrue()
        ->and($result->data[0]->record_id)->toBe(1)
        ->and($result->data[0]->start_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[1]->is_deleted)->toBeNull();
});

it('fetches and maps a character portrait', function (): void {
    Http::fake([
        'esi.evetech.net/characters/90000001/portrait/' => Http::response(esiFixture('characters/portrait.json')),
    ]);

    $result = (new Esi)->getCharacterPortrait(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CharacterPortrait::class)
        ->and($result->data->px128x128)->toBe('string')
        ->and($result->data->px256x256)->toBe('string')
        ->and($result->data->px512x512)->toBe('string')
        ->and($result->data->px64x64)->toBe('string');
});

it('fetches and maps a character agents research', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/agents_research/' => Http::response([
            [
                'agent_id' => 1,
                'points_per_day' => 1.5,
                'remainder_points' => 2.5,
                'skill_type_id' => 3,
                'started_at' => '2026-06-09T12:00:00Z',
            ],
        ]),
    ]);

    $result = (new Esi)->getAgentsResearch(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(AgentResearch::class)
        ->and($result->data[0]->agent_id)->toBe(1)
        ->and($result->data[0]->points_per_day)->toBe(1.5)
        ->and($result->data[0]->remainder_points)->toBe(2.5)
        ->and($result->data[0]->skill_type_id)->toBe(3)
        ->and($result->data[0]->started_at)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps paginated character blueprints, reusing the corporation Blueprint DTO', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/blueprints/*' => Http::response([
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

    $result = (new Esi)->getCharacterBlueprints(fakeCharacter());

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

it('fetches and maps a character jump fatigue', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fatigue/' => Http::response(esiFixture('characters/fatigue.json')),
    ]);

    $result = (new Esi)->getCharacterFatigue(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(JumpFatigue::class)
        ->and($result->data->jump_fatigue_expire_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->last_jump_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->last_update_date)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps character medals', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/medals/' => Http::response([
            [
                'corporation_id' => 1,
                'date' => '2026-06-09T12:00:00Z',
                'description' => 'string',
                'graphics' => [
                    ['color' => 1, 'graphic' => 'string', 'layer' => 2, 'part' => 3],
                ],
                'issuer_id' => 4,
                'medal_id' => 5,
                'reason' => 'string',
                'status' => 'public',
                'title' => 'string',
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterMedals(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CharacterMedal::class)
        ->and($result->data[0]->corporation_id)->toBe(1)
        ->and($result->data[0]->date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->description)->toBe('string')
        ->and($result->data[0]->graphics)->toHaveCount(1)
        ->and($result->data[0]->graphics[0]->color)->toBe(1)
        ->and($result->data[0]->graphics[0]->graphic)->toBe('string')
        ->and($result->data[0]->graphics[0]->layer)->toBe(2)
        ->and($result->data[0]->graphics[0]->part)->toBe(3)
        ->and($result->data[0]->issuer_id)->toBe(4)
        ->and($result->data[0]->medal_id)->toBe(5)
        ->and($result->data[0]->reason)->toBe('string')
        ->and($result->data[0]->status)->toBe('public')
        ->and($result->data[0]->title)->toBe('string');
});

it('fetches and maps character notifications', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/notifications/' => Http::response([
            [
                'is_read' => true,
                'notification_id' => 1,
                'sender_id' => 2,
                'sender_type' => 'character',
                'text' => 'string',
                'timestamp' => '2026-06-09T12:00:00Z',
                'type' => 'AcceptedAlly',
            ],
            [
                // A sparse entry: is_read and text are absent.
                'notification_id' => 3,
                'sender_id' => 4,
                'sender_type' => 'corporation',
                'timestamp' => '2026-06-10T12:00:00Z',
                'type' => 'CorpNewsMsg',
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterNotifications(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(Notification::class)
        ->and($result->data[0]->is_read)->toBeTrue()
        ->and($result->data[0]->notification_id)->toBe(1)
        ->and($result->data[0]->sender_id)->toBe(2)
        ->and($result->data[0]->sender_type)->toBe('character')
        ->and($result->data[0]->text)->toBe('string')
        ->and($result->data[0]->timestamp)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->type)->toBe('AcceptedAlly')
        ->and($result->data[1]->is_read)->toBeNull()
        ->and($result->data[1]->text)->toBeNull();
});

it('fetches and maps character contact notifications', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/notifications/contacts/' => Http::response([
            [
                'message' => 'string',
                'notification_id' => 1,
                'send_date' => '2026-06-09T12:00:00Z',
                'sender_character_id' => 2,
                'standing_level' => 5.0,
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterContactNotifications(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ContactNotification::class)
        ->and($result->data[0]->message)->toBe('string')
        ->and($result->data[0]->notification_id)->toBe(1)
        ->and($result->data[0]->send_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->sender_character_id)->toBe(2)
        ->and($result->data[0]->standing_level)->toBe(5.0);
});

it('fetches and maps character corporation roles', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/roles/' => Http::response(esiFixture('characters/roles.json')),
    ]);

    $result = (new Esi)->getCharacterRoles(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CharacterRoles::class)
        ->and($result->data->roles)->toBe(['Account_Take_1'])
        ->and($result->data->roles_at_base)->toBe(['Account_Take_1'])
        ->and($result->data->roles_at_hq)->toBe(['Account_Take_1'])
        ->and($result->data->roles_at_other)->toBe(['Account_Take_1']);
});

it('fetches and maps character corporation roles with sparse role arrays', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/roles/' => Http::response([
            'roles' => ['Director', 456],
        ]),
    ]);

    $result = (new Esi)->getCharacterRoles(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->roles)->toBe(['Director', ''])
        ->and($result->data->roles_at_base)->toBe([])
        ->and($result->data->roles_at_hq)->toBe([])
        ->and($result->data->roles_at_other)->toBe([]);
});

it('fetches and maps character standings, reusing the corporation Standing DTO', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/standings/' => Http::response([
            ['from_id' => 90000001, 'from_type' => 'agent', 'standing' => 1.5],
        ]),
    ]);

    $result = (new Esi)->getCharacterStandings(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Standing::class)
        ->and($result->data[0]->from_id)->toBe(90000001)
        ->and($result->data[0]->from_type)->toBe('agent')
        ->and($result->data[0]->standing)->toBe(1.5);
});

it('fetches and maps character titles', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/titles/' => Http::response([
            ['name' => 'string', 'title_id' => 1],
            [
                // A sparse entry: name and title_id are both absent.
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterTitles(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(CharacterTitle::class)
        ->and($result->data[0]->name)->toBe('string')
        ->and($result->data[0]->title_id)->toBe(1)
        ->and($result->data[1]->name)->toBeNull()
        ->and($result->data[1]->title_id)->toBeNull();
});

it('calculates the cspa charge cost for a set of characters', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/cspa/' => Http::response('150.5', 201, ['Content-Type' => 'application/json']),
    ]);

    $result = (new Esi)->getCspaCharge(fakeCharacter(), [90000001, 90000002]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(150.5);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/cspa/')
        && $request->data() === [90000001, 90000002]);
});

it('returns an error result when a character endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/medals/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCharacterMedals(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
