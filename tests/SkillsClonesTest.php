<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CharacterAttributes;
use NicolasKion\Esi\DTO\CharacterClones;
use NicolasKion\Esi\DTO\CharacterSkills;
use NicolasKion\Esi\DTO\CloneHomeLocation;
use NicolasKion\Esi\DTO\JumpClone;
use NicolasKion\Esi\DTO\Skill;
use NicolasKion\Esi\DTO\SkillQueueEntry;
use NicolasKion\Esi\Esi;

it('fetches and maps character skills', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/skills/' => Http::response(esiFixture('characters/skills.json')),
    ]);

    $result = (new Esi)->getCharacterSkills(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CharacterSkills::class)
        ->and($result->data->skills)->toHaveCount(1)
        ->and($result->data->skills[0])->toBeInstanceOf(Skill::class)
        ->and($result->data->skills[0]->skill_id)->toBe(90000001)
        ->and($result->data->skills[0]->active_skill_level)->toBe(90000001)
        ->and($result->data->skills[0]->skillpoints_in_skill)->toBe(90000001)
        ->and($result->data->skills[0]->trained_skill_level)->toBe(90000001)
        ->and($result->data->total_sp)->toBe(90000001)
        ->and($result->data->unallocated_sp)->toBe(90000001);
});

it('fetches and maps character skills with unallocated_sp absent', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/skills/' => Http::response([
            'skills' => [],
            'total_sp' => 1,
        ]),
    ]);

    $result = (new Esi)->getCharacterSkills(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->skills)->toBe([])
        ->and($result->data->total_sp)->toBe(1)
        ->and($result->data->unallocated_sp)->toBeNull();
});

it('fetches and maps a character skill queue', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/skillqueue/' => Http::response([
            [
                'finish_date' => '2026-06-09T12:00:00Z',
                'finished_level' => 5,
                'level_end_sp' => 1000,
                'level_start_sp' => 500,
                'queue_position' => 0,
                'skill_id' => 3300,
                'start_date' => '2026-05-09T12:00:00Z',
                'training_start_sp' => 600,
            ],
            [
                // A sparse entry: only the required fields are present.
                'finished_level' => 3,
                'queue_position' => 1,
                'skill_id' => 3301,
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterSkillQueue(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(SkillQueueEntry::class)
        ->and($result->data[0]->skill_id)->toBe(3300)
        ->and($result->data[0]->finished_level)->toBe(5)
        ->and($result->data[0]->queue_position)->toBe(0)
        ->and($result->data[0]->finish_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->level_end_sp)->toBe(1000)
        ->and($result->data[0]->level_start_sp)->toBe(500)
        ->and($result->data[0]->start_date)->toBe('2026-05-09T12:00:00Z')
        ->and($result->data[0]->training_start_sp)->toBe(600)
        ->and($result->data[1]->skill_id)->toBe(3301)
        ->and($result->data[1]->finished_level)->toBe(3)
        ->and($result->data[1]->queue_position)->toBe(1)
        ->and($result->data[1]->finish_date)->toBeNull()
        ->and($result->data[1]->level_end_sp)->toBeNull()
        ->and($result->data[1]->level_start_sp)->toBeNull()
        ->and($result->data[1]->start_date)->toBeNull()
        ->and($result->data[1]->training_start_sp)->toBeNull();
});

it('fetches and maps character attributes', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/attributes/' => Http::response(esiFixture('characters/attributes.json')),
    ]);

    $result = (new Esi)->getCharacterAttributes(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CharacterAttributes::class)
        ->and($result->data->charisma)->toBe(90000001)
        ->and($result->data->intelligence)->toBe(90000001)
        ->and($result->data->memory)->toBe(90000001)
        ->and($result->data->perception)->toBe(90000001)
        ->and($result->data->willpower)->toBe(90000001)
        ->and($result->data->accrued_remap_cooldown_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->bonus_remaps)->toBe(90000001)
        ->and($result->data->last_remap_date)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps character attributes with optional fields absent', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/attributes/' => Http::response([
            'charisma' => 1,
            'intelligence' => 2,
            'memory' => 3,
            'perception' => 4,
            'willpower' => 5,
        ]),
    ]);

    $result = (new Esi)->getCharacterAttributes(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->accrued_remap_cooldown_date)->toBeNull()
        ->and($result->data->bonus_remaps)->toBeNull()
        ->and($result->data->last_remap_date)->toBeNull();
});

it('fetches and maps character clones', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/clones/' => Http::response(esiFixture('characters/clones.json')),
    ]);

    $result = (new Esi)->getCharacterClones(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CharacterClones::class)
        ->and($result->data->home_location)->toBeInstanceOf(CloneHomeLocation::class)
        ->and($result->data->home_location->location_id)->toBe(90000001)
        ->and($result->data->home_location->location_type)->toBe('station')
        ->and($result->data->jump_clones)->toHaveCount(1)
        ->and($result->data->jump_clones[0])->toBeInstanceOf(JumpClone::class)
        ->and($result->data->jump_clones[0]->jump_clone_id)->toBe(90000001)
        ->and($result->data->jump_clones[0]->location_id)->toBe(90000001)
        ->and($result->data->jump_clones[0]->location_type)->toBe('station')
        ->and($result->data->jump_clones[0]->implants)->toBe([90000001])
        ->and($result->data->jump_clones[0]->name)->toBe('string')
        ->and($result->data->last_clone_jump_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->last_station_change_date)->toBe('2026-06-09T12:00:00Z');
});

it('fetches and maps character clones with optional fields absent', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/clones/' => Http::response([
            'jump_clones' => [
                [
                    'implants' => [],
                    'jump_clone_id' => 1,
                    'location_id' => 2,
                    'location_type' => 'structure',
                ],
            ],
        ]),
    ]);

    $result = (new Esi)->getCharacterClones(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->home_location)->toBeInstanceOf(CloneHomeLocation::class)
        ->and($result->data->home_location->location_id)->toBeNull()
        ->and($result->data->home_location->location_type)->toBeNull()
        ->and($result->data->jump_clones[0]->implants)->toBe([])
        ->and($result->data->jump_clones[0]->name)->toBeNull()
        ->and($result->data->last_clone_jump_date)->toBeNull()
        ->and($result->data->last_station_change_date)->toBeNull();
});

it('fetches and maps character implants', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/implants/' => Http::response([90000001, 90000002]),
    ]);

    $result = (new Esi)->getCharacterImplants(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([90000001, 90000002]);
});

it('returns an error result when a skills/clones endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/skills/' => Http::response(['error' => 'Internal server error'], 500),
        'esi.evetech.net/characters/123/skillqueue/' => Http::response(['error' => 'Internal server error'], 500),
        'esi.evetech.net/characters/123/attributes/' => Http::response(['error' => 'Internal server error'], 500),
        'esi.evetech.net/characters/123/clones/' => Http::response(['error' => 'Internal server error'], 500),
        'esi.evetech.net/characters/123/implants/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $esi = new Esi;

    expect($esi->getCharacterSkills(fakeCharacter())->failed())->toBeTrue()
        ->and($esi->getCharacterSkillQueue(fakeCharacter())->failed())->toBeTrue()
        ->and($esi->getCharacterAttributes(fakeCharacter())->failed())->toBeTrue()
        ->and($esi->getCharacterClones(fakeCharacter())->failed())->toBeTrue()
        ->and($esi->getCharacterImplants(fakeCharacter())->failed())->toBeTrue();
});
