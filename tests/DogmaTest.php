<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\DogmaAttribute;
use NicolasKion\Esi\DTO\DogmaEffect;
use NicolasKion\Esi\DTO\DogmaEffectModifier;
use NicolasKion\Esi\Esi;

it('fetches the list of dogma attribute ids', function (): void {
    Http::fake([
        'esi.evetech.net/dogma/attributes*' => Http::response([1, 2, 3]),
    ]);

    $result = (new Esi)->getDogmaAttributes();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([1, 2, 3]);
});

it('fetches and maps a dogma attribute', function (): void {
    Http::fake([
        'esi.evetech.net/dogma/attributes/32*' => Http::response(esiFixture('dogma/attribute.json')),
    ]);

    $result = (new Esi)->getDogmaAttribute(32);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(DogmaAttribute::class)
        ->and($result->data->attribute_id)->toBe(90000001)
        ->and($result->data->default_value)->toBe(1.5)
        ->and($result->data->high_is_good)->toBeTrue()
        ->and($result->data->stackable)->toBeTrue()
        ->and($result->data->unit_id)->toBe(90000001);
});

it('fetches the list of dogma effect ids', function (): void {
    Http::fake([
        'esi.evetech.net/dogma/effects*' => Http::response([10, 20]),
    ]);

    $result = (new Esi)->getDogmaEffects();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([10, 20]);
});

it('fetches and maps a dogma effect with its modifiers', function (): void {
    Http::fake([
        'esi.evetech.net/dogma/effects/16*' => Http::response(esiFixture('dogma/effect.json')),
    ]);

    $result = (new Esi)->getDogmaEffect(16);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(DogmaEffect::class)
        ->and($result->data->effect_id)->toBe(90000001)
        ->and($result->data->is_offensive)->toBeTrue()
        ->and($result->data->effect_category)->toBe(90000001)
        ->and($result->data->modifiers)->toHaveCount(1)
        ->and($result->data->modifiers[0])->toBeInstanceOf(DogmaEffectModifier::class)
        ->and($result->data->modifiers[0]->modified_attribute_id)->toBe(90000001)
        ->and($result->data->modifiers[0]->domain)->toBe('string');
});

it('returns an error result when a dogma endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/dogma/attributes/32*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getDogmaAttribute(32);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
