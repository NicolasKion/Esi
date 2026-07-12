<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class DogmaEffect extends Dto
{
    /**
     * @param  array<int, DogmaEffectModifier>  $modifiers
     */
    public function __construct(
        public int $effect_id,
        public ?string $description,
        public ?bool $disallow_auto_repeat,
        public ?int $discharge_attribute_id,
        public ?string $display_name,
        public ?int $duration_attribute_id,
        public ?int $effect_category,
        public ?bool $electronic_chance,
        public ?int $falloff_attribute_id,
        public ?int $icon_id,
        public ?bool $is_assistance,
        public ?bool $is_offensive,
        public ?bool $is_warp_safe,
        public array $modifiers,
        public ?string $name,
        public ?int $post_expression,
        public ?int $pre_expression,
        public ?bool $published,
        public ?int $range_attribute_id,
        public ?bool $range_chance,
        public ?int $tracking_speed_attribute_id,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            effect_id: $data->integer('effect_id', 0),
            description: $data->string('description'),
            disallow_auto_repeat: $data->boolean('disallow_auto_repeat'),
            discharge_attribute_id: $data->integer('discharge_attribute_id'),
            display_name: $data->string('display_name'),
            duration_attribute_id: $data->integer('duration_attribute_id'),
            effect_category: $data->integer('effect_category'),
            electronic_chance: $data->boolean('electronic_chance'),
            falloff_attribute_id: $data->integer('falloff_attribute_id'),
            icon_id: $data->integer('icon_id'),
            is_assistance: $data->boolean('is_assistance'),
            is_offensive: $data->boolean('is_offensive'),
            is_warp_safe: $data->boolean('is_warp_safe'),
            modifiers: $data->list('modifiers', DogmaEffectModifier::fromData(...)),
            name: $data->string('name'),
            post_expression: $data->integer('post_expression'),
            pre_expression: $data->integer('pre_expression'),
            published: $data->boolean('published'),
            range_attribute_id: $data->integer('range_attribute_id'),
            range_chance: $data->boolean('range_chance'),
            tracking_speed_attribute_id: $data->integer('tracking_speed_attribute_id'),
        );
    }
}
