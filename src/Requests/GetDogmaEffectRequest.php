<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\DogmaEffect;
use NicolasKion\Esi\Request;

/**
 * @extends Request<DogmaEffect>
 */
class GetDogmaEffectRequest extends Request
{
    public function __construct(public int $effect_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/dogma/effects/%d', $this->effect_id);
    }

    public function createDto(Response $response, mixed $data): DogmaEffect
    {
        return DogmaEffect::hydrate($data);
    }
}
