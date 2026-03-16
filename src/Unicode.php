<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Normalizer;

final class Unicode
{
    /**
     * Decode literal unicode escape sequences found in ESI response strings.
     *
     * Handles patterns like:
     *   u'\u038f'       → Ώ
     *   \u038f          → Ώ
     *   \u0410\u043b    → Ал
     *   \uD83D\uDE80    → 🚀 (surrogate pairs)
     */
    public static function decodeEscapes(string $value): string
    {
        if (! str_contains($value, '\\u')) {
            return $value;
        }

        $value = self::stripPythonWrappers($value);

        return self::convertEscapeSequences($value);
    }

    /**
     * Strip Python-style u'...' wrappers from unicode sequences.
     *
     * Example: u'\u038f' → \u038f
     */
    private static function stripPythonWrappers(string $value): string
    {
        return preg_replace("/u'((?:\\\\u[0-9a-fA-F]{4})+)'/", '$1', $value) ?? $value;
    }

    /**
     * Convert \uXXXX escape sequences to their UTF-8 characters.
     *
     * Only touches the escape sequences themselves, leaving surrounding text untouched.
     * Uses json_decode to correctly handle surrogate pairs for emoji and rare CJK.
     */
    private static function convertEscapeSequences(string $value): string
    {
        return preg_replace_callback(
            '/(?:\\\\u[0-9a-fA-F]{4})+/',
            fn (array $m) => self::escapeSequenceToUtf8($m[0]),
            $value
        ) ?? $value;
    }

    /**
     * Decode a matched \uXXXX sequence (including surrogate pairs) to UTF-8.
     */
    private static function escapeSequenceToUtf8(string $sequence): string
    {
        return json_decode('"'.str_replace('\\u', '\\u', $sequence).'"') ?? $sequence;
    }

    /**
     * Normalize a string to NFC form and decode any unicode escape sequences.
     */
    public static function normalize(string $value): string
    {
        $value = self::decodeEscapes($value);

        if (Normalizer::isNormalized($value, Normalizer::FORM_C)) {
            return $value;
        }

        return Normalizer::normalize($value, Normalizer::FORM_C) ?: $value;
    }

    /**
     * Recursively normalize all string values in an array.
     *
     * @param  array<array-key, mixed>  $data
     * @return array<array-key, mixed>
     */
    public static function normalizeArray(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = self::normalize($value);
            } elseif (is_array($value)) {
                $data[$key] = self::normalizeArray($value);
            }
        }

        return $data;
    }
}
