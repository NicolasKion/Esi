<?php

declare(strict_types=1);

use NicolasKion\Esi\Enums\EsiScope;
use NicolasKion\Esi\Enums\LocationFlag;

it('resolves scope values from a comma-separated request string', function (): void {
    $scopes = EsiScope::fromRequest(EsiScope::ReadAssets->value.','.EsiScope::ReadMail->value);

    expect($scopes)->toBe([EsiScope::ReadAssets->value, EsiScope::ReadMail->value]);
});

it('lists all scope values', function (): void {
    $all = EsiScope::all();

    expect($all)->toBeArray()->not->toBeEmpty()
        ->and($all)->toContain(EsiScope::ReadAssets->value)
        ->and($all)->toHaveCount(count(EsiScope::cases()));
});

it('identifies structure location flags', function (): void {
    expect(LocationFlag::isStructureLocation(LocationFlag::Hangar))->toBeTrue()
        ->and(LocationFlag::isStructureLocation(LocationFlag::ShipHangar))->toBeTrue()
        ->and(LocationFlag::isStructureLocation(LocationFlag::DroneBay))->toBeFalse();
});

it('lists fitting location flags', function (): void {
    $flags = LocationFlag::fittingFlags();

    expect($flags)->toBeArray()->not->toBeEmpty()
        ->and($flags)->toContain(LocationFlag::HiSlot0, LocationFlag::DroneBay)
        ->and($flags)->not->toContain(LocationFlag::Hangar);
});
