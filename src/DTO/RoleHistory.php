<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class RoleHistory extends Dto
{
    /**
     * @param  array<int, string>  $new_roles
     * @param  array<int, string>  $old_roles
     */
    public function __construct(
        public string $changed_at,
        public int $character_id,
        public int $issuer_id,
        public array $new_roles,
        public array $old_roles,
        public string $role_type,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            changed_at: $data->string('changed_at', ''),
            character_id: $data->integer('character_id', 0),
            issuer_id: $data->integer('issuer_id', 0),
            new_roles: self::stringList($data->raw('new_roles')),
            old_roles: self::stringList($data->raw('old_roles')),
            role_type: $data->string('role_type', ''),
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
