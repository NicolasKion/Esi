<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Enums;

enum EsiScope: string
{
    case ReadAssets = 'esi-assets.read_assets.v1';
    case PublicData = 'publicData';
    case OpenWindow = 'esi-ui.open_window.v1';
    case ReadContracts = 'esi-contracts.read_character_contracts.v1';
    case ReadMail = 'esi-mail.read_mail.v1';
    case SendMail = 'esi-mail.send_mail.v1';
    case OrganizeMail = 'esi-mail.organize_mail.v1';
    case ReadStructures = 'esi-universe.read_structures.v1';
    case ReadCorporationAssets = 'esi-assets.read_corporation_assets.v1';
    case ReadWallet = 'esi-wallet.read_character_wallet.v1';
    case ReadLocations = 'esi-location.read_location.v1';
    case ReadOnlineStatus = 'esi-location.read_online.v1';
    case ReadShip = 'esi-location.read_ship_type.v1';

    public static function fromRequest(string $scopes): array
    {
        $scopes = explode(',', $scopes);

        return array_map(fn ($scope) => self::from($scope)->value, $scopes);
    }

    public static function all(): array
    {
        return collect(self::cases())->map(fn ($scope) => $scope->value)->toArray();
    }
}
