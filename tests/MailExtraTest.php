<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\MailingList;
use NicolasKion\Esi\DTO\MailLabel;
use NicolasKion\Esi\DTO\MailLabels;
use NicolasKion\Esi\Esi;

it('fetches and maps mail labels', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/' => Http::response(esiFixture('mail/labels.json')),
    ]);

    $result = (new Esi)->getMailLabels(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MailLabels::class)
        ->and($result->data->total_unread_count)->toBe(90000001)
        ->and($result->data->labels)->toHaveCount(1)
        ->and($result->data->labels[0])->toBeInstanceOf(MailLabel::class)
        ->and($result->data->labels[0]->label_id)->toBe(90000001)
        ->and($result->data->labels[0]->name)->toBe('string')
        ->and($result->data->labels[0]->color)->toBe('#0000fe')
        ->and($result->data->labels[0]->unread_count)->toBe(90000001);
});

it('fetches and maps mailing lists', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/lists/' => Http::response(esiFixture('mail/lists.json')),
    ]);

    $result = (new Esi)->getMailingLists(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MailingList::class)
        ->and($result->data[0]->mailing_list_id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('string');
});

it('creates a mail label and returns the new label id', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/' => Http::response('42', 201, ['Content-Type' => 'application/json']),
    ]);

    $result = (new Esi)->createMailLabel(fakeCharacter(), 'Important', '#ffffff');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(42);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/mail/labels/')
        && $request->data() === [
            'name' => 'Important',
            'color' => '#ffffff',
        ]);
});

it('creates a mail label without a color', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/' => Http::response('42', 201, ['Content-Type' => 'application/json']),
    ]);

    $result = (new Esi)->createMailLabel(fakeCharacter(), 'Important');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(42);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/mail/labels/')
        && $request->data() === [
            'name' => 'Important',
        ]);
});

it('deletes a mail label', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/1/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->deleteMailLabel(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeNull();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/characters/123/mail/labels/1/'));
});

it('deletes a mail', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/987654/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->deleteMail(fakeCharacter(), 987654);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeNull();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/characters/123/mail/987654/'));
});

it('returns an error result when the mail labels endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getMailLabels(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('returns an error result when creating a mail label fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->createMailLabel(fakeCharacter(), 'Important');

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('returns an error result when deleting a mail label fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/labels/1/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->deleteMailLabel(fakeCharacter(), 1);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('returns an error result when deleting a mail fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/987654/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->deleteMail(fakeCharacter(), 987654);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
