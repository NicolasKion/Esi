<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The ESI changelog, a map of date string to the list of route changes made
 * on that date.
 */
readonly class MetaChangelog extends Dto
{
    /**
     * @param  array<string, array<int, MetaChangelogEntry>>  $changelog
     */
    public function __construct(
        public array $changelog,
    ) {}

    public static function fromData(Data $data): self
    {
        $raw = $data->raw('changelog');
        $changelog = [];

        if (is_array($raw)) {
            foreach ($raw as $date => $entries) {
                $changelog[(string) $date] = MetaChangelogEntry::hydrateList($entries);
            }
        }

        return new self(changelog: $changelog);
    }
}
