<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

/**
 * Descriptive details of a {@see FreelanceJob}, only present on the detail
 * endpoint.
 */
readonly class FreelanceJobDetails extends Dto
{
    public function __construct(
        public string $description,
        public string $career,
        public string $created,
        public ?FreelanceJobCreator $creator,
        public ?string $expires,
        public ?string $finished,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            description: $data->string('description', ''),
            career: $data->string('career', ''),
            created: $data->string('created', ''),
            creator: $data->has('creator') ? FreelanceJobCreator::fromData($data->object('creator')) : null,
            expires: $data->string('expires'),
            finished: $data->string('finished'),
        );
    }
}
