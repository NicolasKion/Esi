<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class ContainerLog extends Dto
{
    public function __construct(
        public string $action,
        public int $character_id,
        public int $container_id,
        public int $container_type_id,
        public string $location_flag,
        public int $location_id,
        public string $logged_at,
        public ?int $new_config_bitmask,
        public ?int $old_config_bitmask,
        public ?string $password_type,
        public ?int $quantity,
        public ?int $type_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            action: $data->string('action', ''),
            character_id: $data->integer('character_id', 0),
            container_id: $data->integer('container_id', 0),
            container_type_id: $data->integer('container_type_id', 0),
            location_flag: $data->string('location_flag', ''),
            location_id: $data->integer('location_id', 0),
            logged_at: $data->string('logged_at', ''),
            new_config_bitmask: $data->integer('new_config_bitmask'),
            old_config_bitmask: $data->integer('old_config_bitmask'),
            password_type: $data->string('password_type'),
            quantity: $data->integer('quantity'),
            type_id: $data->integer('type_id'),
        );
    }
}
