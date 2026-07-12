<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

interface EsiToken
{
    public function isExpired(): bool;

    public function getRefreshToken(): string;

    public function getAccessToken(): string;

    /**
     * The return value is ignored by the library, so the return type is left
     * unconstrained: implementers may return whatever their storage layer does
     * (e.g. Eloquent's bool), or nothing at all.
     *
     * @return mixed
     */
    public function delete();

    /**
     * The return value is ignored by the library, so the return type is left
     * unconstrained: implementers may return whatever their storage layer does
     * (e.g. Eloquent's bool), or nothing at all.
     *
     * @param  array<string, mixed>  $data
     * @return mixed
     */
    public function update(array $data);
}
