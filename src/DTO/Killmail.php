<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

class Killmail
{
    /**
     * @param  Attacker[]  $attackers
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

    public static function fromArray(array $data): self
    {
        $attackers = array_map(fn ($attacker) => Attacker::fromArray($attacker), $data['attackers']);
        $victim = Victim::fromArray($data['victim']);

        return new self(
            attackers: $attackers,
            killmail_id: $data['killmail_id'],
            killmail_time: $data['killmail_time'],
            solar_system_id: $data['solar_system_id'],
            victim: $victim,
            war_id: $data['war_id'] ?? null,
            moon_id: $data['moon_id'] ?? null,
        );
    }
}
