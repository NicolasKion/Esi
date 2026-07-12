<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\EveMail;
use NicolasKion\Esi\Enums\RecipientType;
use NicolasKion\Esi\Esi;

it('fetches and maps eve mails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/' => Http::response(esiFixture('mail/list.json')),
    ]);

    $result = (new Esi)->getEveMails(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(EveMail::class)
        ->and($result->data[0]->mail_id)->toBe(90000001)
        ->and($result->data[0]->from)->toBe(90000001)
        ->and($result->data[0]->is_read)->toBeTrue()
        ->and($result->data[0]->labels)->toBe([90000001])
        ->and($result->data[0]->subject)->toBe('string')
        ->and($result->data[0]->timestamp)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->body)->toBeNull()
        ->and($result->data[0]->recipients)->toHaveCount(1)
        ->and($result->data[0]->recipients[0]->recipient_id)->toBe(90000001)
        ->and($result->data[0]->recipients[0]->recipient_type)->toBe(RecipientType::Alliance);
});

it('fetches and maps a single eve mail', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/987654/' => Http::response(esiFixture('mail/detail.json')),
    ]);

    $result = (new Esi)->getEveMail(fakeCharacter(), 987654);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(EveMail::class)
        ->and($result->data->mail_id)->toBeNull()
        ->and($result->data->from)->toBe(90000001)
        ->and($result->data->is_read)->toBeTrue()
        ->and($result->data->labels)->toBe([90000001])
        ->and($result->data->subject)->toBe('string')
        ->and($result->data->timestamp)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->body)->toBe('string')
        ->and($result->data->recipients[0]->recipient_id)->toBe(90000001)
        ->and($result->data->recipients[0]->recipient_type)->toBe(RecipientType::Alliance);
});

it('sends a mail and returns the new mail id', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/' => Http::response('1234567', 201),
    ]);

    $recipients = [
        ['recipient_id' => 90000001, 'recipient_type' => 'character'],
    ];

    $result = (new Esi)->sendMail(fakeCharacter(), $recipients, 'Test subject', 'Test body');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(1234567);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/mail/')
        && $request->data() === [
            'approved_cost' => 0,
            'body' => 'Test body',
            'recipients' => $recipients,
            'subject' => 'Test subject',
        ]);
});

it('updates an eve mail with read state and labels', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/987654/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->updateEveMail(fakeCharacter(), 987654, true, [1]);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/characters/123/mail/987654/')
        && $request->data() === [
            'read' => true,
            'labels' => [1],
        ]);
});

it('returns an error result when the mail endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mail/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getEveMails(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
