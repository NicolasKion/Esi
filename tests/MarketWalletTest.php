<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\DogmaItem;
use NicolasKion\Esi\DTO\DogmaItemAttribute;
use NicolasKion\Esi\DTO\DogmaItemEffect;
use NicolasKion\Esi\DTO\MarketHistory;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\Enums\ContextIdType;
use NicolasKion\Esi\Enums\TransactionType;
use NicolasKion\Esi\Esi;

it('fetches and maps market history', function (): void {
    Http::fake([
        'esi.evetech.net/markets/10000002/history/*' => Http::response(esiFixture('markets/history.json')),
    ]);

    $result = (new Esi)->getMarketHistory(10000002, 34);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MarketHistory::class)
        ->and($result->data[0]->average)->toBe(1.5)
        ->and($result->data[0]->date)->toBe('2026-06-09')
        ->and($result->data[0]->highest)->toBe(1.5)
        ->and($result->data[0]->lowest)->toBe(1.5)
        ->and($result->data[0]->order_count)->toBe(90000001)
        ->and($result->data[0]->volume)->toBe(90000001);

    Http::assertSent(fn ($request) => str_contains($request->url(), '/markets/10000002/history/')
        && str_contains($request->url(), 'type_id=34'));
});

it('fetches and maps the character wallet journal', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/wallet/journal/*' => Http::response(esiFixture('wallet/journal.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getWalletJournal(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(WalletJournalEntry::class)
        ->and($result->data[0]->amount)->toBe(1.5)
        ->and($result->data[0]->balance)->toBe(1.5)
        ->and($result->data[0]->context_id)->toBe(90000001)
        ->and($result->data[0]->context_id_type)->toBe(ContextIdType::StructureId)
        ->and($result->data[0]->date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->first_party_id)->toBe(90000001)
        ->and($result->data[0]->id)->toBe(90000001)
        ->and($result->data[0]->reason)->toBe('string')
        ->and($result->data[0]->ref_type)->toBe(TransactionType::AccelerationGateFee)
        ->and($result->data[0]->second_party_id)->toBe(90000001)
        ->and($result->data[0]->tax)->toBe(1.5)
        ->and($result->data[0]->tax_receiver_id)->toBe(90000001);
});

it('fetches and maps dogma item attributes', function (): void {
    Http::fake([
        'esi.evetech.net/dogma/dynamic/items/587/1000000000001/*' => Http::response(esiFixture('dogma/item.json')),
    ]);

    $result = (new Esi)->getDogmaItem(587, 1000000000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(DogmaItem::class)
        ->and($result->data->created_by)->toBe(90000001)
        ->and($result->data->mutator_type_id)->toBe(90000001)
        ->and($result->data->source_type_id)->toBe(90000001)
        ->and($result->data->dogma_attributes)->toHaveCount(1)
        ->and($result->data->dogma_attributes[0])->toBeInstanceOf(DogmaItemAttribute::class)
        ->and($result->data->dogma_attributes[0]->attribute_id)->toBe(90000001)
        ->and($result->data->dogma_attributes[0]->value)->toBe(1.5)
        ->and($result->data->dogma_effects)->toHaveCount(1)
        ->and($result->data->dogma_effects[0])->toBeInstanceOf(DogmaItemEffect::class)
        ->and($result->data->dogma_effects[0]->effect_id)->toBe(90000001)
        ->and($result->data->dogma_effects[0]->is_default)->toBeTrue();
});

it('returns an error result when the market history endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/markets/10000002/history/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getMarketHistory(10000002, 34);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
