<?php

namespace NicolasKion\Esi\Interfaces;

interface EsiToken
{
    public function isExpired(): bool;

    public function getRefreshToken(): string;

    public function getAccessToken(): string;

    public function delete();

    public function update(array $data);

}
