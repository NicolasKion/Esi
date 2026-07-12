<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\Contact;
use NicolasKion\Esi\DTO\ContactLabel;
use NicolasKion\Esi\Enums\ContactType;
use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Esi;
use NicolasKion\Esi\Interfaces\Character;
use NicolasKion\Esi\Interfaces\EsiToken;

function fakeContactCharacter(): Character
{
    $token = new class implements EsiToken
    {
        public function isExpired(): bool
        {
            return false;
        }

        public function getRefreshToken(): string
        {
            return 'refresh';
        }

        public function getAccessToken(): string
        {
            return 'access';
        }

        public function delete(): void {}

        public function update(array $data): void {}
    };

    return new class($token) implements Character
    {
        public function __construct(private EsiToken $token) {}

        public function getEsiTokenWithScope(EsiScope $scope): ?EsiToken
        {
            return $this->token;
        }

        public function getId(): int
        {
            return 123;
        }

        public function getCorporationId(): int
        {
            return 456;
        }
    };
}

it('fetches and maps character contacts', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contacts/*' => Http::response([
            ['contact_id' => 999, 'contact_type' => 'corporation', 'standing' => 5.0, 'is_watched' => true, 'is_blocked' => false, 'label_ids' => [1, 2]],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCharacterContacts(fakeContactCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Contact::class)
        ->and($result->data[0]->contact_id)->toBe(999)
        ->and($result->data[0]->contact_type)->toBe(ContactType::Corporation)
        ->and($result->data[0]->standing)->toBe(5.0)
        ->and($result->data[0]->is_watched)->toBeTrue()
        ->and($result->data[0]->label_ids)->toBe([1, 2]);
});

it('fetches character contact labels', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contacts/labels/*' => Http::response([
            ['label_id' => 7, 'label_name' => 'Friends'],
        ], 200),
    ]);

    $result = (new Esi)->getCharacterContactLabels(fakeContactCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data[0])->toBeInstanceOf(ContactLabel::class)
        ->and($result->data[0]->label_id)->toBe(7)
        ->and($result->data[0]->label_name)->toBe('Friends');
});

it('defaults optional contact fields to null/empty for corporation contacts', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/contacts/*' => Http::response([
            ['contact_id' => 555, 'contact_type' => 'alliance', 'standing' => -2.5],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationContacts(fakeContactCharacter(), 456);

    expect($result->data[0]->is_watched)->toBeNull()
        ->and($result->data[0]->is_blocked)->toBeNull()
        ->and($result->data[0]->label_ids)->toBe([])
        ->and($result->data[0]->standing)->toBe(-2.5);
});

it('adds character contacts with the ids in the body and standing in the query', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contacts/*' => Http::response([111, 222], 201),
    ]);

    $result = (new Esi)->addCharacterContacts(fakeContactCharacter(), [111, 222], 5.0, [9], true);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe([111, 222]);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/contacts/')
        && str_contains($request->url(), 'standing=5')
        && str_contains($request->url(), 'label_ids=9')
        && $request->data() === [111, 222]);
});

it('deletes character contacts with comma-separated ids in the query', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/contacts/*' => Http::response(null, 204),
    ]);

    $result = (new Esi)->deleteCharacterContacts(fakeContactCharacter(), [111, 222]);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains(urldecode($request->url()), 'contact_ids=111,222'));
});
