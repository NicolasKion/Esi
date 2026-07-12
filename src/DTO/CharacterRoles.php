<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterRoles extends Dto
{
    /**
     * @param  array<int, string>  $roles
     * @param  array<int, string>  $roles_at_base
     * @param  array<int, string>  $roles_at_hq
     * @param  array<int, string>  $roles_at_other
     */
    public function __construct(
        public array $roles,
        public array $roles_at_base,
        public array $roles_at_hq,
        public array $roles_at_other,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            roles: self::stringList($data->raw('roles')),
            roles_at_base: self::stringList($data->raw('roles_at_base')),
            roles_at_hq: self::stringList($data->raw('roles_at_hq')),
            roles_at_other: self::stringList($data->raw('roles_at_other')),
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
