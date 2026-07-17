<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The name ESI is currently going by, plus every name it has ever had.
 */
readonly class MetaName extends Dto
{
    /**
     * @param  array<int, MetaNameEntry>  $history
     */
    public function __construct(
        public string $current,
        public array $history,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            current: $data->string('current', ''),
            history: MetaNameEntry::hydrateList($data->raw('history')),
        );
    }
}
