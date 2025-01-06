<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

/**
 * Represents the result of an ESI operation.
 *
 * @template T
 *
 * @property-read T $data The data.
 */
readonly class EsiResult
{
    /**
     * Create a new instance.
     *
     * @param  T  $data  The data.
     * @param  EsiError|null  $error  The error.
     */
    public function __construct(
        public ?EsiStats $stats = null,
        public mixed $data = null,
        public ?EsiError $error = null,
    ) {
        //
    }

    public function wasSuccessful(): bool
    {
        return ! $this->failed();
    }

    public function failed(): bool
    {
        return $this->error !== null;
    }
}
