<?php

namespace NicolasKion\Esi\Interfaces;

use NicolasKion\Esi\Enums\EsiScope;

interface Character
{
    function getEsiTokenWithScope(EsiScope $scope): EsiToken;

    function getId(): int;

    function getCorporationId(): int;
}
