<?php

declare(strict_types=1);

use NicolasKion\Esi\Unicode;

it('returns strings without escape sequences unchanged', function (): void {
    expect(Unicode::decodeEscapes('plain ascii'))->toBe('plain ascii');
});

it('decodes bare unicode escape sequences', function (): void {
    expect(Unicode::decodeEscapes('\\u038f'))->toBe('Ώ')
        ->and(Unicode::decodeEscapes('\\u0410\\u043b'))->toBe('Ал');
});

it('strips python-style wrappers around escape sequences', function (): void {
    expect(Unicode::decodeEscapes('u\'\\u038f\''))->toBe('Ώ');
});

it('decodes surrogate pairs for emoji', function (): void {
    expect(Unicode::decodeEscapes('\\uD83D\\uDE80'))->toBe('🚀');
});

it('leaves already NFC-normalized strings untouched', function (): void {
    expect(Unicode::normalize('Jita'))->toBe('Jita');
});

it('normalizes decomposed strings to NFC', function (): void {
    // "e" + combining acute accent (NFD) should normalize to precomposed "é".
    expect(Unicode::normalize("e\u{0301}"))->toBe('é');
});

it('recursively normalizes string values in nested arrays', function (): void {
    $result = Unicode::normalizeArray([
        'name' => '\\u038f',
        'nested' => ['deep' => "e\u{0301}", 'id' => 42],
        'flag' => true,
    ]);

    expect($result['name'])->toBe('Ώ')
        ->and($result['nested']['deep'])->toBe('é')
        ->and($result['nested']['id'])->toBe(42)
        ->and($result['flag'])->toBeTrue();
});
