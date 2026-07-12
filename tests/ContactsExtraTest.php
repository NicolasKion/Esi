<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Contact;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\Enums\ContactType;
use NicolasKion\Esi\Esi;

it('edits character contacts with the ids in the body and standing in the query', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contacts/*' => Http::response(null, 204),
    ]);

    $result = (new Esi)->editCharacterContacts(fakeCharacter(), [111, 222], 5.0, [9], true);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/characters/123/contacts/')
        && str_contains($request->url(), 'standing=5')
        && str_contains($request->url(), 'label_ids=9')
        && $request->data() === [111, 222]);
});

it('fetches corporation contact labels', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/contacts/labels/' => Http::response(esiFixture('contacts/corporation_labels.json')),
    ]);

    $result = (new Esi)->getCorporationContactLabels(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ContactLabel::class)
        ->and($result->data[0]->label_id)->toBe(90000001)
        ->and($result->data[0]->label_name)->toBe('string');
});

it('fetches and maps alliance contacts', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/contacts/*' => Http::response(esiFixture('contacts/alliance_contacts.json'), 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getAllianceContacts(fakeCharacter(), 99000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Contact::class)
        ->and($result->data[0]->contact_id)->toBe(90000001)
        ->and($result->data[0]->contact_type)->toBe(ContactType::Character)
        ->and($result->data[0]->standing)->toBe(1.5)
        ->and($result->data[0]->is_watched)->toBeNull()
        ->and($result->data[0]->is_blocked)->toBeNull()
        ->and($result->data[0]->label_ids)->toBe([90000001]);
});

it('fetches alliance contact labels', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/contacts/labels/' => Http::response(esiFixture('contacts/alliance_labels.json')),
    ]);

    $result = (new Esi)->getAllianceContactLabels(fakeCharacter(), 99000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(ContactLabel::class)
        ->and($result->data[0]->label_id)->toBe(90000001)
        ->and($result->data[0]->label_name)->toBe('string');
});

it('returns an error result when the alliance contact labels endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/alliances/99000001/contacts/labels/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getAllianceContactLabels(fakeCharacter(), 99000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
