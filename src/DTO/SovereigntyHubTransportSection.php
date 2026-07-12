<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * A workforce-transport section: ESI models `configuration` (what was
 * requested) and `state` (what is currently happening) as a discriminated
 * union of `import`, `export`, or `transit`. Only one of the three is
 * populated in any given response, so all three are nullable here.
 */
readonly class SovereigntyHubTransportSection extends Dto
{
    public function __construct(
        public ?SovereigntyHubTransportImport $import,
        public ?SovereigntyHubTransportExport $export,
        public ?bool $transit,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            import: $data->has('import') ? SovereigntyHubTransportImport::fromData($data->object('import')) : null,
            export: $data->has('export') ? SovereigntyHubTransportExport::fromData($data->object('export')) : null,
            transit: $data->boolean('transit'),
        );
    }
}
