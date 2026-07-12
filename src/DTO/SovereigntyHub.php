<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A corporation's Sovereignty Hub.
 *
 * This is a superset of the two shapes ESI returns: the listing endpoint
 * only reports `id` and `solar_system_id`, while the detail endpoint adds
 * the remaining fields. Fields only present in the detail response are
 * nullable.
 */
readonly class SovereigntyHub extends Dto
{
    /**
     * @param  array<int, SovereigntyHubUpgrade>  $upgrades
     */
    public function __construct(
        public int $id,
        public int $solar_system_id,
        public ?int $fuel_access_list_id,
        public ?SovereigntyHubReagentBay $reagent_bay,
        public ?SovereigntyHubResources $resources,
        public array $upgrades,
        public ?SovereigntyHubVulnerabilityWindow $vulnerability_window,
        public ?SovereigntyHubWorkforceTransport $workforce_transport,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            id: $data->integer('id', 0),
            solar_system_id: $data->integer('solar_system_id', 0),
            fuel_access_list_id: $data->integer('fuel_access_list_id'),
            reagent_bay: $data->has('reagent_bay') ? SovereigntyHubReagentBay::fromData($data->object('reagent_bay')) : null,
            resources: $data->has('resources') ? SovereigntyHubResources::fromData($data->object('resources')) : null,
            upgrades: $data->list('upgrades', SovereigntyHubUpgrade::fromData(...)),
            vulnerability_window: $data->has('vulnerability_window') ? SovereigntyHubVulnerabilityWindow::fromData($data->object('vulnerability_window')) : null,
            workforce_transport: $data->has('workforce_transport') ? SovereigntyHubWorkforceTransport::fromData($data->object('workforce_transport')) : null,
        );
    }
}
