<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Killmail extends Dto
{
    /**
     * @param  array<int, Attacker>  $attackers
     */
    public function __construct(
        public array $attackers,
        public int $killmail_id,
        public string $killmail_time,
        public int $solar_system_id,
        public Victim $victim,
        public ?int $war_id = null,
        public ?int $moon_id = null,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            attackers: $data->list('attackers', Attacker::fromData(...)),
            killmail_id: $data->integer('killmail_id', 0),
            killmail_time: $data->string('killmail_time', ''),
            solar_system_id: $data->integer('solar_system_id', 0),
            victim: Victim::fromData($data->object('victim')),
            war_id: $data->integer('war_id'),
            moon_id: $data->integer('moon_id'),
        );
    }
}
