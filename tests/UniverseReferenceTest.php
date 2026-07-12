<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Ancestry;
use NicolasKion\Esi\DTO\AsteroidBelt;
use NicolasKion\Esi\DTO\Bloodline;
use NicolasKion\Esi\DTO\Constellation;
use NicolasKion\Esi\DTO\Faction;
use NicolasKion\Esi\DTO\Graphic;
use NicolasKion\Esi\DTO\Moon;
use NicolasKion\Esi\DTO\Planet;
use NicolasKion\Esi\DTO\Race;
use NicolasKion\Esi\DTO\Region;
use NicolasKion\Esi\DTO\Schematic;
use NicolasKion\Esi\DTO\Star;
use NicolasKion\Esi\DTO\Stargate;
use NicolasKion\Esi\DTO\Station;
use NicolasKion\Esi\DTO\System;
use NicolasKion\Esi\DTO\SystemJumps;
use NicolasKion\Esi\DTO\SystemKills;
use NicolasKion\Esi\DTO\SystemPlanet;
use NicolasKion\Esi\DTO\UniverseCategory;
use NicolasKion\Esi\DTO\UniverseGroup;
use NicolasKion\Esi\DTO\UniverseType;
use NicolasKion\Esi\Esi;

it('fetches the list of universe category ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/categories/*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getUniverseCategories();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a universe category', function (): void {
    Http::fake([
        'esi.evetech.net/universe/categories/90000001*' => Http::response(esiFixture('universe/category.json')),
    ]);

    $result = (new Esi)->getUniverseCategory(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(UniverseCategory::class)
        ->and($result->data->category_id)->toBe(90000001)
        ->and($result->data->name)->toBe('string')
        ->and($result->data->published)->toBeTrue()
        ->and($result->data->groups)->toBe([90000001]);
});

it('fetches the list of universe group ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/groups/*' => Http::response([1, 2, 3], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getUniverseGroups();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a universe group', function (): void {
    Http::fake([
        'esi.evetech.net/universe/groups/90000001*' => Http::response(esiFixture('universe/group.json')),
    ]);

    $result = (new Esi)->getUniverseGroup(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(UniverseGroup::class)
        ->and($result->data->group_id)->toBe(90000001)
        ->and($result->data->category_id)->toBe(90000001)
        ->and($result->data->published)->toBeTrue()
        ->and($result->data->types)->toBe([90000001]);
});

it('fetches the list of universe type ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/types/*' => Http::response([1, 2, 3], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getUniverseTypes();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a universe type with its dogma attributes and effects', function (): void {
    Http::fake([
        'esi.evetech.net/universe/types/90000001*' => Http::response(esiFixture('universe/type.json')),
    ]);

    $result = (new Esi)->getUniverseType(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(UniverseType::class)
        ->and($result->data->type_id)->toBe(90000001)
        ->and($result->data->group_id)->toBe(90000001)
        ->and($result->data->capacity)->toBe(1.5)
        ->and($result->data->published)->toBeTrue()
        ->and($result->data->dogma_attributes)->toHaveCount(1)
        ->and($result->data->dogma_attributes[0]->attribute_id)->toBe(90000001)
        ->and($result->data->dogma_attributes[0]->value)->toBe(1.5)
        ->and($result->data->dogma_effects)->toHaveCount(1)
        ->and($result->data->dogma_effects[0]->effect_id)->toBe(90000001)
        ->and($result->data->dogma_effects[0]->is_default)->toBeTrue();
});

it('fetches the list of constellation ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/constellations/*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getUniverseConstellations();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a constellation', function (): void {
    Http::fake([
        'esi.evetech.net/universe/constellations/90000001*' => Http::response(esiFixture('universe/constellation.json')),
    ]);

    $result = (new Esi)->getConstellation(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Constellation::class)
        ->and($result->data->constellation_id)->toBe(90000001)
        ->and($result->data->region_id)->toBe(90000001)
        ->and($result->data->position->x)->toBe(1.5)
        ->and($result->data->systems)->toBe([90000001]);
});

it('fetches the list of graphic ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/graphics/*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getUniverseGraphics();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a graphic', function (): void {
    Http::fake([
        'esi.evetech.net/universe/graphics/90000001*' => Http::response(esiFixture('universe/graphic.json')),
    ]);

    $result = (new Esi)->getGraphic(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Graphic::class)
        ->and($result->data->graphic_id)->toBe(90000001)
        ->and($result->data->collision_file)->toBe('string')
        ->and($result->data->sof_fation_name)->toBe('string');
});

it('fetches the list of region ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/regions/*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getUniverseRegions();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a region', function (): void {
    Http::fake([
        'esi.evetech.net/universe/regions/90000001*' => Http::response(esiFixture('universe/region.json')),
    ]);

    $result = (new Esi)->getRegion(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Region::class)
        ->and($result->data->region_id)->toBe(90000001)
        ->and($result->data->description)->toBe('string')
        ->and($result->data->constellations)->toBe([90000001]);
});

it('fetches the list of solar system ids', function (): void {
    Http::fake([
        'esi.evetech.net/universe/systems/*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getUniverseSystems();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a solar system with its planets', function (): void {
    Http::fake([
        'esi.evetech.net/universe/systems/90000001*' => Http::response(esiFixture('universe/system.json')),
    ]);

    $result = (new Esi)->getSystem(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(System::class)
        ->and($result->data->system_id)->toBe(90000001)
        ->and($result->data->constellation_id)->toBe(90000001)
        ->and($result->data->security_status)->toBe(1.5)
        ->and($result->data->security_class)->toBe('string')
        ->and($result->data->star_id)->toBe(90000001)
        ->and($result->data->stargates)->toBe([90000001])
        ->and($result->data->stations)->toBe([90000001])
        ->and($result->data->planets)->toHaveCount(1)
        ->and($result->data->planets[0])->toBeInstanceOf(SystemPlanet::class)
        ->and($result->data->planets[0]->planet_id)->toBe(90000001)
        ->and($result->data->planets[0]->asteroid_belts)->toBe([90000001])
        ->and($result->data->planets[0]->moons)->toBe([90000001]);
});

it('fetches and maps a station', function (): void {
    Http::fake([
        'esi.evetech.net/universe/stations/90000001*' => Http::response(esiFixture('universe/station.json')),
    ]);

    $result = (new Esi)->getStation(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Station::class)
        ->and($result->data->station_id)->toBe(90000001)
        ->and($result->data->owner)->toBe(90000001)
        ->and($result->data->race_id)->toBe(90000001)
        ->and($result->data->position->z)->toBe(1.5)
        ->and($result->data->services)->toBe(['bounty-missions']);
});

it('fetches and maps a stargate with its destination', function (): void {
    Http::fake([
        'esi.evetech.net/universe/stargates/90000001*' => Http::response(esiFixture('universe/stargate.json')),
    ]);

    $result = (new Esi)->getStargate(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Stargate::class)
        ->and($result->data->stargate_id)->toBe(90000001)
        ->and($result->data->system_id)->toBe(90000001)
        ->and($result->data->destination->stargate_id)->toBe(90000001)
        ->and($result->data->destination->system_id)->toBe(90000001);
});

it('fetches and maps a star', function (): void {
    Http::fake([
        'esi.evetech.net/universe/stars/90000001*' => Http::response(esiFixture('universe/star.json')),
    ]);

    $result = (new Esi)->getStar(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Star::class)
        ->and($result->data->solar_system_id)->toBe(90000001)
        ->and($result->data->spectral_class)->toBe('K2 V')
        ->and($result->data->age)->toBe(90000001)
        ->and($result->data->luminosity)->toBe(1.5);
});

it('fetches and maps a planet', function (): void {
    Http::fake([
        'esi.evetech.net/universe/planets/90000001*' => Http::response(esiFixture('universe/planet.json')),
    ]);

    $result = (new Esi)->getPlanet(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Planet::class)
        ->and($result->data->planet_id)->toBe(90000001)
        ->and($result->data->system_id)->toBe(90000001)
        ->and($result->data->type_id)->toBe(90000001);
});

it('fetches and maps a moon', function (): void {
    Http::fake([
        'esi.evetech.net/universe/moons/90000001*' => Http::response(esiFixture('universe/moon.json')),
    ]);

    $result = (new Esi)->getMoon(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Moon::class)
        ->and($result->data->moon_id)->toBe(90000001)
        ->and($result->data->system_id)->toBe(90000001);
});

it('fetches and maps an asteroid belt', function (): void {
    Http::fake([
        'esi.evetech.net/universe/asteroid_belts/90000001*' => Http::response(esiFixture('universe/asteroid_belt.json')),
    ]);

    $result = (new Esi)->getAsteroidBelt(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(AsteroidBelt::class)
        ->and($result->data->name)->toBe('string')
        ->and($result->data->system_id)->toBe(90000001);
});

it('fetches and maps a schematic', function (): void {
    Http::fake([
        'esi.evetech.net/universe/schematics/90000001*' => Http::response(esiFixture('universe/schematic.json')),
    ]);

    $result = (new Esi)->getSchematic(90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Schematic::class)
        ->and($result->data->schematic_name)->toBe('string')
        ->and($result->data->cycle_time)->toBe(90000001);
});

it('fetches and maps ancestries', function (): void {
    Http::fake([
        'esi.evetech.net/universe/ancestries/*' => Http::response([
            [
                'bloodline_id' => 1,
                'description' => 'desc',
                'icon_id' => 2,
                'id' => 3,
                'name' => 'name',
                'short_description' => 'short',
            ],
        ]),
    ]);

    $result = (new Esi)->getAncestries();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Ancestry::class)
        ->and($result->data[0]->id)->toBe(3)
        ->and($result->data[0]->bloodline_id)->toBe(1)
        ->and($result->data[0]->icon_id)->toBe(2)
        ->and($result->data[0]->short_description)->toBe('short');
});

it('fetches and maps bloodlines', function (): void {
    Http::fake([
        'esi.evetech.net/universe/bloodlines/*' => Http::response([
            [
                'bloodline_id' => 1,
                'charisma' => 2,
                'corporation_id' => 3,
                'description' => 'desc',
                'intelligence' => 4,
                'memory' => 5,
                'name' => 'name',
                'perception' => 6,
                'race_id' => 7,
                'ship_type_id' => 8,
                'willpower' => 9,
            ],
        ]),
    ]);

    $result = (new Esi)->getBloodlines();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Bloodline::class)
        ->and($result->data[0]->bloodline_id)->toBe(1)
        ->and($result->data[0]->race_id)->toBe(7)
        ->and($result->data[0]->willpower)->toBe(9);
});

it('fetches and maps factions', function (): void {
    Http::fake([
        'esi.evetech.net/universe/factions/*' => Http::response([
            [
                'corporation_id' => 1,
                'description' => 'desc',
                'faction_id' => 2,
                'is_unique' => true,
                'militia_corporation_id' => 3,
                'name' => 'name',
                'size_factor' => 1.5,
                'solar_system_id' => 4,
                'station_count' => 5,
                'station_system_count' => 6,
            ],
        ]),
    ]);

    $result = (new Esi)->getFactions();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Faction::class)
        ->and($result->data[0]->faction_id)->toBe(2)
        ->and($result->data[0]->is_unique)->toBeTrue()
        ->and($result->data[0]->size_factor)->toBe(1.5);
});

it('fetches and maps races', function (): void {
    Http::fake([
        'esi.evetech.net/universe/races/*' => Http::response([
            [
                'alliance_id' => 1,
                'description' => 'desc',
                'name' => 'name',
                'race_id' => 2,
            ],
        ]),
    ]);

    $result = (new Esi)->getRaces();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Race::class)
        ->and($result->data[0]->race_id)->toBe(2)
        ->and($result->data[0]->alliance_id)->toBe(1);
});

it('fetches and maps system jumps', function (): void {
    Http::fake([
        'esi.evetech.net/universe/system_jumps/*' => Http::response([
            ['ship_jumps' => 1, 'system_id' => 2],
        ]),
    ]);

    $result = (new Esi)->getSystemJumps();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(SystemJumps::class)
        ->and($result->data[0]->system_id)->toBe(2)
        ->and($result->data[0]->ship_jumps)->toBe(1);
});

it('fetches and maps system kills', function (): void {
    Http::fake([
        'esi.evetech.net/universe/system_kills/*' => Http::response([
            ['npc_kills' => 1, 'pod_kills' => 2, 'ship_kills' => 3, 'system_id' => 4],
        ]),
    ]);

    $result = (new Esi)->getSystemKills();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(SystemKills::class)
        ->and($result->data[0]->system_id)->toBe(4)
        ->and($result->data[0]->ship_kills)->toBe(3)
        ->and($result->data[0]->npc_kills)->toBe(1)
        ->and($result->data[0]->pod_kills)->toBe(2);
});

it('returns an error result when a universe reference endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/universe/categories/90000001*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getUniverseCategory(90000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
