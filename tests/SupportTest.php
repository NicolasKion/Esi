<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Character;
use NicolasKion\Esi\DTO\EveMailRecipient;
use NicolasKion\Esi\Enums\RecipientType;
use NicolasKion\Esi\Esi;
use NicolasKion\Esi\Facades\Esi as EsiFacade;
use NicolasKion\Esi\Requests\AddCharacterContactsRequest;
use NicolasKion\Esi\Requests\DeleteCharacterContactsRequest;
use NicolasKion\Esi\Requests\EditCharacterContactsRequest;
use NicolasKion\Esi\Requests\GetStatusRequest;
use NicolasKion\Esi\Requests\SendMailRequest;
use NicolasKion\Esi\Requests\UpdateEveMailRequest;
use NicolasKion\Esi\Support\Data;

it('returns the default for non-numeric float and integer values', function (): void {
    expect(Data::of(['x' => 'not-a-number'])->float('x'))->toBeNull()
        ->and(Data::of(['x' => 'not-a-number'])->float('x', 1.5))->toBe(1.5)
        ->and(Data::of(['x' => 'not-a-number'])->integer('x', 7))->toBe(7);
});

it('coerces non-string scalars to string', function (): void {
    expect(Data::of(['x' => 42])->string('x'))->toBe('42')
        ->and(Data::of(['x' => true])->string('x'))->toBe('1')
        ->and(Data::of(['x' => 1.5])->string('x'))->toBe('1.5')
        ->and(Data::of(['x' => ['not', 'scalar']])->string('x', 'fallback'))->toBe('fallback');
});

it('exposes raw values and the underlying array', function (): void {
    $data = Data::of(['a' => 1, 'b' => 2]);

    expect($data->toArray())->toBe(['a' => 1, 'b' => 2])
        ->and($data->raw('a'))->toBe(1)
        ->and($data->raw('missing'))->toBeNull()
        ->and($data->has('a'))->toBeTrue()
        ->and($data->has('missing'))->toBeFalse();
});

it('hydrates a dto through the fromArray entrypoint', function (): void {
    $character = Character::fromArray(['name' => 'CCP Test', 'corporation_id' => 98000001]);

    expect($character)->toBeInstanceOf(Character::class)
        ->and($character->name)->toBe('CCP Test')
        ->and($character->corporation_id)->toBe(98000001);
});

it('serializes a mail recipient', function (): void {
    $recipient = new EveMailRecipient(123, RecipientType::Character);

    expect($recipient->__serialize())->toBe([
        'recipient_id' => 123,
        'recipient_type' => 'character',
    ]);
});

it('resolves the Esi facade to the underlying service', function (): void {
    expect(EsiFacade::getFacadeRoot())->toBeInstanceOf(Esi::class);
});

it('retries read requests on server errors but not client errors', function (): void {
    $request = new GetStatusRequest;

    expect($request->shouldRetry(new Response(new Psr7Response(500))))->toBeTrue()
        ->and($request->shouldRetry(new Response(new Psr7Response(404))))->toBeFalse();
});

it('never retries write requests', function (): void {
    $serverError = new Response(new Psr7Response(500));

    expect((new AddCharacterContactsRequest(123, [1], 5.0))->shouldRetry($serverError))->toBeFalse()
        ->and((new DeleteCharacterContactsRequest(123, [1]))->shouldRetry($serverError))->toBeFalse()
        ->and((new EditCharacterContactsRequest(123, [1], 5.0))->shouldRetry($serverError))->toBeFalse()
        ->and((new SendMailRequest(123, [], 'subject', 'body'))->shouldRetry($serverError))->toBeFalse();
});

it('always retries update-mail requests', function (): void {
    expect((new UpdateEveMailRequest(123, 987654))->shouldRetry(new Response(new Psr7Response(500))))->toBeTrue();
});
