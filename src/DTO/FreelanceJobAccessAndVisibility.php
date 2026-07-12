<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The access and visibility settings of a {@see FreelanceJob}, only present
 * on the detail endpoint.
 */
readonly class FreelanceJobAccessAndVisibility extends Dto
{
    /**
     * @param  array<int, FreelanceJobBroadcastLocation>  $broadcast_locations
     */
    public function __construct(
        public ?bool $acl_protected,
        public array $broadcast_locations,
        public ?FreelanceJobRestrictions $restrictions,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            acl_protected: $data->boolean('acl_protected'),
            broadcast_locations: $data->list('broadcast_locations', FreelanceJobBroadcastLocation::fromData(...)),
            restrictions: $data->has('restrictions') ? FreelanceJobRestrictions::fromData($data->object('restrictions')) : null,
        );
    }
}
