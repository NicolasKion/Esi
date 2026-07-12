<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class War extends Dto
{
    /**
     * @param  array<int, Ally>  $allies
     */
    public function __construct(
        public Aggressor $aggressor,
        public array $allies,
        public string $declared,
        public Defender $defender,
        public ?string $finished,
        public int $id,
        public bool $mutual,
        public bool $open_for_allies,
        public ?string $retracted,
        public ?string $started
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            aggressor: Aggressor::fromData($data->object('aggressor')),
            allies: $data->list('allies', Ally::fromData(...)),
            declared: $data->string('declared', ''),
            defender: Defender::fromData($data->object('defender')),
            finished: $data->string('finished'),
            id: $data->integer('id', 0),
            mutual: $data->boolean('mutual', false),
            open_for_allies: $data->boolean('open_for_allies', false),
            retracted: $data->string('retracted'),
            started: $data->string('started'),
        );
    }
}
