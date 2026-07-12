<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class IndustryJob extends Dto
{
    public function __construct(
        public int $job_id,
        public int $installer_id,
        public int $facility_id,
        public int $activity_id,
        public int $blueprint_id,
        public int $blueprint_type_id,
        public int $blueprint_location_id,
        public int $output_location_id,
        public int $runs,
        public string $status,
        public string $start_date,
        public string $end_date,
        public int $duration,
        public ?float $cost,
        public ?int $licensed_runs,
        public ?float $probability,
        public ?int $product_type_id,
        public ?int $completed_character_id,
        public ?string $completed_date,
        public ?string $pause_date,
        public ?int $successful_runs,
        public ?int $station_id,
        public ?int $location_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            job_id: $data->integer('job_id', 0),
            installer_id: $data->integer('installer_id', 0),
            facility_id: $data->integer('facility_id', 0),
            activity_id: $data->integer('activity_id', 0),
            blueprint_id: $data->integer('blueprint_id', 0),
            blueprint_type_id: $data->integer('blueprint_type_id', 0),
            blueprint_location_id: $data->integer('blueprint_location_id', 0),
            output_location_id: $data->integer('output_location_id', 0),
            runs: $data->integer('runs', 0),
            status: $data->string('status', ''),
            start_date: $data->string('start_date', ''),
            end_date: $data->string('end_date', ''),
            duration: $data->integer('duration', 0),
            cost: $data->float('cost'),
            licensed_runs: $data->integer('licensed_runs'),
            probability: $data->float('probability'),
            product_type_id: $data->integer('product_type_id'),
            completed_character_id: $data->integer('completed_character_id'),
            completed_date: $data->string('completed_date'),
            pause_date: $data->string('pause_date'),
            successful_runs: $data->integer('successful_runs'),
            station_id: $data->integer('station_id'),
            location_id: $data->integer('location_id'),
        );
    }
}
