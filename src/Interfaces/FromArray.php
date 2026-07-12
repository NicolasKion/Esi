<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

interface FromArray
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self;
}
