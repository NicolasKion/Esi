<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

interface EsiToken
{
    public function isExpired(): bool;

    public function getRefreshToken(): string;

    public function getAccessToken(): string;

    /**
     * The return value is ignored by the library; implementers may return
     * whatever their storage layer does (e.g. Eloquent's bool).
     */
    public function delete(): mixed;

    /**
     * The return value is ignored by the library; implementers may return
     * whatever their storage layer does (e.g. Eloquent's bool).
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): mixed;
}
