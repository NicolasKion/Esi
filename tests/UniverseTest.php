<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Name;
use NicolasKion\Esi\DTO\Structure;
use NicolasKion\Esi\Enums\NameCategory;
use NicolasKion\Esi\Esi;

it('resolves ids to names', function (): void {
    Http::fake([
        'esi.evetech.net/universe/names/' => Http::response(esiFixture('universe/names.json')),
    ]);

    $result = (new Esi)->getNames([90000001]);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Name::class)
        ->and($result->data[0]->category)->toBe(NameCategory::Character)
        ->and($result->data[0]->id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('CCP Bartender');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/universe/names/')
        && $request->data() === [90000001]);
});

it('fetches public structures', function (): void {
    Http::fake([
        'esi.evetech.net/universe/structures/*' => Http::response(esiFixture('universe/public_structures.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getPublicStructures();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeArray()
        ->and($result->data)->not->toBeEmpty()
        ->and($result->data[0])->toBeInt()
        ->and($result->data)->toBe([1035466617946, 1035466617947]);
});

it('fetches and maps structure information', function (): void {
    Http::fake([
        'esi.evetech.net/universe/structures/1035466617946/' => Http::response(esiFixture('universe/structure.json')),
    ]);

    $result = (new Esi)->getStructure(fakeCharacter(), 1035466617946);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(Structure::class)
        ->and($result->data->name)->toBe('Jita IV - Moon 4 - Structure')
        ->and($result->data->owner_id)->toBe(98000001)
        ->and($result->data->position->x)->toBe(1.5)
        ->and($result->data->position->y)->toBe(2.5)
        ->and($result->data->position->z)->toBe(3.5)
        ->and($result->data->solar_system_id)->toBe(30000142)
        ->and($result->data->type_id)->toBe(35832);
});

it('returns an error result when the names endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/universe/names/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getNames([90000001]);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
