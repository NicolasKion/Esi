<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\UniverseId;
use NicolasKion\Esi\DTO\UniverseIds;
use NicolasKion\Esi\Esi;

it('resolves names to ids grouped by category', function (): void {
    Http::fake([
        'esi.evetech.net/universe/ids/*' => Http::response([
            'characters' => [
                ['id' => 95465499, 'name' => 'CCP Bartender'],
            ],
            'systems' => [
                ['id' => 30000142, 'name' => 'Jita'],
            ],
        ]),
    ]);

    $result = (new Esi)->getIds(['CCP Bartender', 'Jita']);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(UniverseIds::class)
        ->and($result->data->characters)->toHaveCount(1)
        ->and($result->data->characters[0])->toBeInstanceOf(UniverseId::class)
        ->and($result->data->characters[0]->id)->toBe(95465499)
        ->and($result->data->characters[0]->name)->toBe('CCP Bartender')
        ->and($result->data->systems[0]->id)->toBe(30000142)
        ->and($result->data->agents)->toBeEmpty()
        ->and($result->data->corporations)->toBeEmpty();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/universe/ids/')
        && $request->data() === ['CCP Bartender', 'Jita']);
});

it('handles errors when resolving names', function (): void {
    Http::fake([
        'esi.evetech.net/universe/ids/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getIds(['Jita']);

    expect($result->failed())->toBeTrue();
});
