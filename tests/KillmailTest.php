<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Aggressor;
use NicolasKion\Esi\DTO\Ally;
use NicolasKion\Esi\DTO\Attacker;
use NicolasKion\Esi\DTO\Defender;
use NicolasKion\Esi\DTO\Item;
use NicolasKion\Esi\DTO\Killmail;
use NicolasKion\Esi\DTO\Position;
use NicolasKion\Esi\DTO\Sovereignty;
use NicolasKion\Esi\DTO\Victim;
use NicolasKion\Esi\DTO\War;
use NicolasKion\Esi\Esi;

it('fetches and maps a killmail', function (): void {
    Http::fake([
        'esi.evetech.net/killmails/123456/abcdef1234567890/' => Http::response(esiFixture('killmails/detail.json')),
    ]);

    $result = (new Esi)->getKillmail(123456, 'abcdef1234567890');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Killmail::class)
        ->and($result->data->killmail_id)->toBe(90000001)
        ->and($result->data->killmail_time)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->solar_system_id)->toBe(90000001)
        ->and($result->data->war_id)->toBe(90000001)
        ->and($result->data->moon_id)->toBe(90000001)
        ->and($result->data->victim)->toBeInstanceOf(Victim::class)
        ->and($result->data->victim->damage_taken)->toBe(90000001)
        ->and($result->data->victim->ship_type_id)->toBe(90000001)
        ->and($result->data->victim->position)->toBeInstanceOf(Position::class)
        ->and($result->data->victim->position->x)->toBe(1.5)
        ->and($result->data->victim->items)->toBeArray()
        ->and($result->data->victim->items[0])->toBeInstanceOf(Item::class)
        ->and($result->data->victim->items[0]->flag)->toBe(90000001)
        ->and($result->data->victim->items[0]->item_type_id)->toBe(90000001)
        ->and($result->data->attackers)->toBeArray()
        ->and($result->data->attackers[0])->toBeInstanceOf(Attacker::class)
        ->and($result->data->attackers[0]->final_blow)->toBeTrue()
        ->and($result->data->attackers[0]->security_status)->toBe(1.5)
        ->and($result->data->attackers[0]->damage_done)->toBe(90000001);
});

it('fetches and maps sovereignty systems', function (): void {
    Http::fake([
        'esi.evetech.net/sovereignty/systems*' => Http::response(esiFixture('sovereignty/systems.json')),
    ]);

    $result = (new Esi)->getSovereignty();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(3)
        ->and($result->data[0])->toBeInstanceOf(Sovereignty::class)
        // alliance-claimed system
        ->and($result->data[0]->system_id)->toBe(30000001)
        ->and($result->data[0]->alliance_id)->toBe(99000001)
        ->and($result->data[0]->corporation_id)->toBe(98000001)
        ->and($result->data[0]->faction_id)->toBeNull()
        // faction-claimed system
        ->and($result->data[1]->system_id)->toBe(30000002)
        ->and($result->data[1]->faction_id)->toBe(500002)
        ->and($result->data[1]->alliance_id)->toBeNull()
        // unclaimed system
        ->and($result->data[2]->system_id)->toBe(30000003)
        ->and($result->data[2]->alliance_id)->toBeNull()
        ->and($result->data[2]->faction_id)->toBeNull()
        ->and($result->data[2]->corporation_id)->toBeNull();
});

it('fetches and maps a war', function (): void {
    Http::fake([
        'esi.evetech.net/wars/1*' => Http::response(esiFixture('wars/detail.json')),
    ]);

    $result = (new Esi)->getWar(1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(War::class)
        ->and($result->data->id)->toBe(90000001)
        ->and($result->data->declared)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->mutual)->toBeTrue()
        ->and($result->data->open_for_allies)->toBeTrue()
        ->and($result->data->finished)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->retracted)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->started)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->aggressor)->toBeInstanceOf(Aggressor::class)
        ->and($result->data->aggressor->isk_destroyed)->toBe(1.5)
        ->and($result->data->aggressor->ships_killed)->toBe(90000001)
        ->and($result->data->defender)->toBeInstanceOf(Defender::class)
        ->and($result->data->defender->corporation_id)->toBe(90000001)
        ->and($result->data->allies)->toBeArray()
        ->and($result->data->allies[0])->toBeInstanceOf(Ally::class)
        ->and($result->data->allies[0]->alliance_id)->toBe(90000001);
});

it('returns an error result when the killmail endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/killmails/123456/abcdef1234567890/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getKillmail(123456, 'abcdef1234567890');

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
