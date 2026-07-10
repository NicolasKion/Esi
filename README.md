# ESI Integration for EVE Online

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nicolaskion/eve.svg?style=flat-square)](https://packagist.org/packages/nicolaskion/eve)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/nicolaskion/esi/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nicolaskion/esi/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/nicolaskion/esi/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/nicolaskion/esi/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/nicolaskion/esi.svg?style=flat-square)](https://packagist.org/packages/nicolaskion/esi)

A Laravel package that integrates [EVE Online's ESI API](https://developers.eveonline.com/) into your application. It wraps ESI endpoints in typed request classes and returns fully typed, readonly DTOs — no juggling raw JSON arrays.

## Features

- **Typed DTOs** for every response (characters, corporations, alliances, assets, contracts, killmails, market history, and more)
- **Automatic OAuth token refresh** for authenticated endpoints via your own `Character` / `EsiToken` implementations
- **Automatic pagination** for paginated endpoints
- **Configurable retry policy** with sensible defaults
- **ESI compatibility date** support, pinned per release

## Requirements

- PHP 8.3+
- Laravel 12 or 13

## Installation

Install the package via composer:

```bash
composer require nicolaskion/eve
```

Publish the config file:

```bash
php artisan vendor:publish --tag="esi-config"
```

Set your ESI application credentials (only needed for authenticated endpoints — create an app at [developers.eveonline.com](https://developers.eveonline.com/)):

```env
EVE_CLIENT_ID=your-client-id
EVE_CLIENT_SECRET=your-client-secret
```

The config file lets you tweak the user agent, retry policy, base URL and ESI compatibility date.

## Usage

### Public endpoints

```php
use NicolasKion\Esi\Facades\Esi;

$result = Esi::getStatus();

if ($result->wasSuccessful()) {
    $result->data->players; // e.g. 24_512
}

$alliance = Esi::getAlliance(434243723)->data;
$history = Esi::getMarketHistory(region_id: 10000002, type_id: 44992)->data;
```

### Resolving names and IDs

```php
// IDs to names
$names = Esi::getNames([95465499, 30000142])->data;

// Names to IDs, grouped by category
$ids = Esi::getIds(['CCP Bartender', 'Jita'])->data;
$ids->characters[0]->id; // 95465499
$ids->systems[0]->id;    // 30000142
```

### Authenticated endpoints

Endpoints that require authentication accept a `Character`. Implement the
`NicolasKion\Esi\Interfaces\Character` and `NicolasKion\Esi\Interfaces\EsiToken`
interfaces on your models, and the package takes care of refreshing expired
access tokens for you:

```php
$assets = Esi::getAssets($character)->data;
$contacts = Esi::getCharacterContacts($character)->data;

Esi::setWaypoint($character, destination_id: 30000142);
```

### Error handling

Every call returns an `EsiResult`. Nothing throws on HTTP errors:

```php
$result = Esi::getCharacter(95465499);

if ($result->failed()) {
    $result->error->code; // e.g. 404
    $result->error->body;
}
```

## Supported endpoints

| Area | Methods |
| --- | --- |
| Alliances | `getAlliance`, `getAlliances`, `getAllianceContacts`, `getAllianceContactLabels` |
| Assets | `getAssets`, `getAssetNames`, `getCorporationAssets`, `getCorporationAssetNames` |
| Characters | `getCharacter`, `getAffiliations`, `getLocation`, `getOnline`, `getShip` |
| Contacts | `getCharacterContacts`, `getCharacterContactLabels`, `addCharacterContacts`, `editCharacterContacts`, `deleteCharacterContacts`, `getCorporationContacts`, `getCorporationContactLabels` |
| Contracts | `getCharacterContracts`, `getCharacterContractItems`, `getPublicContracts`, `getPublicContractItems`, `getPublicContractBids`, `openContract` |
| Corporations | `getCorporation`, `getCorporationDivisions`, `getCorporationStructures` |
| Dogma | `getDogmaItem` |
| Killmails | `getKillmail` |
| Mail | `getEveMails`, `getEveMail`, `sendMail`, `updateEveMail` |
| Market | `getMarketHistory` |
| Sovereignty | `getSovereignty`, `getRaidableSkyhooks` |
| Universe | `getNames`, `getIds`, `getStructure`, `getPublicStructures` |
| UI | `setWaypoint` |
| Wallet | `getWalletJournal` |
| Wars | `getWar` |
| Meta | `getStatus` |

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
