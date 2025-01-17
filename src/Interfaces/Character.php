<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

use NicolasKion\Esi\Enums\EsiScope;

interface Character
{
    public function getEsiTokenWithScope(EsiScope $scope): ?EsiToken;

    public function getId(): int;

    public function getCorporationId(): int;
}
