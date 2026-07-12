<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CorporationWallet;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\DTO\WalletTransaction;
use NicolasKion\Esi\Esi;

it('fetches the character wallet balance', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/wallet/' => Http::response('1234.5', 200, ['Content-Type' => 'application/json']),
    ]);

    $result = (new Esi)->getWalletBalance(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(1234.5);
});

it('fetches and maps the character wallet transactions', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/wallet/transactions/*' => Http::response(esiFixture('wallet/transactions.json')),
    ]);

    $result = (new Esi)->getWalletTransactions(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(WalletTransaction::class)
        ->and($result->data[0]->client_id)->toBe(90000001)
        ->and($result->data[0]->date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->is_buy)->toBeTrue()
        ->and($result->data[0]->is_personal)->toBeTrue()
        ->and($result->data[0]->journal_ref_id)->toBe(90000001)
        ->and($result->data[0]->location_id)->toBe(90000001)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->transaction_id)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->unit_price)->toBe(1.5);
});

it('fetches the character wallet transactions with a from_id cursor', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/wallet/transactions/*' => Http::response(esiFixture('wallet/transactions.json')),
    ]);

    $result = (new Esi)->getWalletTransactions(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => str_contains($request->url(), '/characters/123/wallet/transactions/')
        && str_contains($request->url(), 'from_id=90000001'));
});

it('fetches and maps corporation wallets', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/wallets/' => Http::response(esiFixture('wallet/corporation_wallets.json')),
    ]);

    $result = (new Esi)->getCorporationWallets(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CorporationWallet::class)
        ->and($result->data[0]->balance)->toBe(1.5)
        ->and($result->data[0]->division)->toBe(90000001);
});

it('fetches and maps the paginated corporation wallet journal', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/wallets/1/journal/*' => Http::response(esiFixture('wallet/journal.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationWalletJournal(fakeCharacter(), 456, 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(WalletJournalEntry::class)
        ->and($result->data[0]->amount)->toBe(1.5)
        ->and($result->data[0]->balance)->toBe(1.5)
        ->and($result->data[0]->id)->toBe(90000001)
        ->and($result->data[0]->ref_type->value)->toBe('acceleration_gate_fee');
});

it('fetches and maps corporation wallet transactions', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/wallets/1/transactions/*' => Http::response(esiFixture('wallet/corporation_transactions.json')),
    ]);

    $result = (new Esi)->getCorporationWalletTransactions(fakeCharacter(), 456, 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(WalletTransaction::class)
        ->and($result->data[0]->client_id)->toBe(90000001)
        ->and($result->data[0]->date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->is_buy)->toBeTrue()
        ->and($result->data[0]->is_personal)->toBeNull()
        ->and($result->data[0]->journal_ref_id)->toBe(90000001)
        ->and($result->data[0]->location_id)->toBe(90000001)
        ->and($result->data[0]->quantity)->toBe(90000001)
        ->and($result->data[0]->transaction_id)->toBe(90000001)
        ->and($result->data[0]->type_id)->toBe(90000001)
        ->and($result->data[0]->unit_price)->toBe(1.5);
});

it('fetches corporation wallet transactions with a from_id cursor', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/wallets/1/transactions/*' => Http::response(esiFixture('wallet/corporation_transactions.json')),
    ]);

    $result = (new Esi)->getCorporationWalletTransactions(fakeCharacter(), 456, 1, 90000002);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => str_contains($request->url(), '/corporations/456/wallets/1/transactions/')
        && str_contains($request->url(), 'from_id=90000002'));
});

it('returns an error result when a wallet endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/wallet/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getWalletBalance(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
