<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * The contribution configuration of a {@see FreelanceJob}, only present on
 * the detail endpoint.
 *
 * `parameters` describes the job-type-specific parameters (e.g. a type
 * matcher, a set of options, a toggle, or a corporation item delivery
 * target) as one of several differently-shaped variants keyed by parameter
 * name. It is left as a raw decoded array rather than modeled as individual
 * DTOs for each variant.
 */
readonly class FreelanceJobConfiguration extends Dto
{
    /**
     * @param  array<string, mixed>  $parameters
     */
    public function __construct(
        public string $method,
        public ?int $version,
        public array $parameters,
    ) {}

    public static function fromData(Data $data): self
    {
        /** @var array<string, mixed>|null $parameters */
        $parameters = $data->raw('parameters');

        return new self(
            method: $data->string('method', ''),
            version: $data->integer('version'),
            parameters: is_array($parameters) ? $parameters : [],
        );
    }
}
