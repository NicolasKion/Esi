<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CorporationProjectDetails extends Dto
{
    public function __construct(
        public string $career,
        public string $created,
        public string $description,
        public ?string $expires,
        public ?string $finished,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            career: $data->string('career', ''),
            created: $data->string('created', ''),
            description: $data->string('description', ''),
            expires: $data->string('expires'),
            finished: $data->string('finished'),
        );
    }
}
