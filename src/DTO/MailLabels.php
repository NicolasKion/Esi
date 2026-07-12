<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class MailLabels extends Dto
{
    /**
     * @param  array<int, MailLabel>  $labels
     */
    public function __construct(
        public array $labels,
        public ?int $total_unread_count,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            labels: $data->list('labels', MailLabel::fromData(...)),
            total_unread_count: $data->integer('total_unread_count'),
        );
    }
}
