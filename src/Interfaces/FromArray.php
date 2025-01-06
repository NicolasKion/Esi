<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

interface FromArray
{
    public static function fromArray(array $data): self;
}
