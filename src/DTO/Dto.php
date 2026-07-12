<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;
use NicolasKion\Esi\Support\Data;

/**
 * Base class for every DTO hydrated from an ESI response.
 *
 * Children only implement fromData(), which builds the DTO from a fluent
 * {@see Data} view of the payload. The array/mixed entry points are provided
 * here: fromArray() satisfies the {@see FromArray} contract, while hydrate()
 * and hydrateList() are the conveniences request classes use to turn a decoded
 * response (typed `mixed`) into DTOs. A child may override fromArray() when it
 * needs bespoke handling.
 */
abstract readonly class Dto implements FromArray
{
    abstract public static function fromData(Data $data): self;

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        /** @var static $dto */
        $dto = static::fromData(Data::of($data));

        return $dto;
    }

    /**
     * Build a single DTO from a raw decoded payload.
     */
    public static function hydrate(mixed $data): static
    {
        /** @var static $dto */
        $dto = static::fromData(Data::of($data));

        return $dto;
    }

    /**
     * Build a list of DTOs from a raw decoded payload.
     *
     * @return array<int, static>
     */
    public static function hydrateList(mixed $data): array
    {
        /** @var array<int, static> $list */
        $list = Data::mapList($data, static::fromData(...));

        return $list;
    }
}
