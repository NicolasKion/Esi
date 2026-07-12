<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The list of compatibility dates supported by ESI.
 */
readonly class MetaCompatibilityDates extends Dto
{
    /**
     * @param  array<int, string>  $compatibility_dates
     */
    public function __construct(
        public array $compatibility_dates,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            compatibility_dates: self::stringList($data->raw('compatibility_dates')),
        );
    }

    /**
     * @return array<int, string>
     */
    private static function stringList(mixed $raw): array
    {
        if (! is_array($raw)) {
            return [];
        }

        return array_values(array_map(
            static fn (mixed $value): string => is_string($value) ? $value : '',
            $raw,
        ));
    }
}
