<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

/**
 * Represents the result of an ESI operation.
 *
 * @template-covariant T
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

    /**
     * Build a failed result. The data type is `never` so it composes with an
     * expected EsiResult<T> for any T (a failed result carries no data).
     *
     * @return EsiResult<never>
     */
    public static function fromError(EsiError $error, ?EsiStats $stats = null): self
    {
        /** @var EsiResult<never> $result */
        $result = new self(stats: $stats, error: $error);

        return $result;
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
