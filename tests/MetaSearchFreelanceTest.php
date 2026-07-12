<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\AccessList;
use NicolasKion\Esi\DTO\FreelanceJob;
use NicolasKion\Esi\DTO\FreelanceJobParticipant;
use NicolasKion\Esi\DTO\FreelanceJobParticipation;
use NicolasKion\Esi\DTO\MercenaryTacticalOperation;
use NicolasKion\Esi\DTO\MetaChangelog;
use NicolasKion\Esi\DTO\MetaChangelogEntry;
use NicolasKion\Esi\DTO\MetaCompatibilityDates;
use NicolasKion\Esi\DTO\MetaStatus;
use NicolasKion\Esi\DTO\SearchResult;
use NicolasKion\Esi\DTO\SovereigntyCampaign;
use NicolasKion\Esi\Esi;

// ---------------------------------------------------------------------
// Meta
// ---------------------------------------------------------------------

it('fetches and maps the meta changelog', function (): void {
    Http::fake([
        'esi.evetech.net/meta/changelog*' => Http::response(esiFixture('meta/changelog.json')),
    ]);

    $result = (new Esi)->getMetaChangelog();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MetaChangelog::class)
        ->and($result->data->changelog)->toHaveKey('2025-08-26')
        ->and($result->data->changelog['2025-08-26'])->toHaveCount(1)
        ->and($result->data->changelog['2025-08-26'][0])->toBeInstanceOf(MetaChangelogEntry::class)
        ->and($result->data->changelog['2025-08-26'][0]->method)->toBe('GET')
        ->and($result->data->changelog['2025-08-26'][0]->path)->toBe('/characters/{character_id}/search')
        ->and($result->data->changelog['2025-08-26'][0]->compatibility_date)->toBe('2025-08-26')
        ->and($result->data->changelog['2025-08-26'][0]->type)->toBe('changed')
        ->and($result->data->changelog['2025-08-26'][0]->description)->toBe('Updated response schema.');
});

it('defaults the changelog to an empty array when the field is missing', function (): void {
    Http::fake([
        'esi.evetech.net/meta/changelog*' => Http::response([]),
    ]);

    $result = (new Esi)->getMetaChangelog();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->changelog)->toBe([]);
});

it('fetches and maps the meta compatibility dates', function (): void {
    Http::fake([
        'esi.evetech.net/meta/compatibility-dates*' => Http::response(esiFixture('meta/compatibility-dates.json')),
    ]);

    $result = (new Esi)->getMetaCompatibilityDates();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MetaCompatibilityDates::class)
        ->and($result->data->compatibility_dates)->toBe(['2025-08-26', '2026-06-09']);
});

it('defaults compatibility dates to an empty array when the field is missing', function (): void {
    Http::fake([
        'esi.evetech.net/meta/compatibility-dates*' => Http::response([]),
    ]);

    $result = (new Esi)->getMetaCompatibilityDates();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->compatibility_dates)->toBe([]);
});

it('fetches and maps the meta status routes', function (): void {
    Http::fake([
        'esi.evetech.net/meta/status*' => Http::response(esiFixture('meta/status.json')),
    ]);

    $result = (new Esi)->getMetaStatus();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MetaStatus::class)
        ->and($result->data->routes)->toHaveCount(2)
        ->and($result->data->routes[0]->method)->toBe('GET')
        ->and($result->data->routes[0]->path)->toBe('/status')
        ->and($result->data->routes[0]->status)->toBe('OK')
        ->and($result->data->routes[1]->status)->toBe('Degraded');
});

it('returns an error result when the meta status endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/meta/status*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getMetaStatus();

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

// ---------------------------------------------------------------------
// Sovereignty campaigns
// ---------------------------------------------------------------------

it('fetches and maps sovereignty campaigns', function (): void {
    Http::fake([
        'esi.evetech.net/sovereignty/campaigns*' => Http::response(esiFixture('sovereignty/campaigns.json')),
    ]);

    $result = (new Esi)->getSovereigntyCampaigns();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(SovereigntyCampaign::class)
        ->and($result->data[0]->campaign_id)->toBe(12345)
        ->and($result->data[0]->structure_id)->toBe(999999)
        ->and($result->data[0]->solar_system_id)->toBe(30000142)
        ->and($result->data[0]->constellation_id)->toBe(20000020)
        ->and($result->data[0]->event_type)->toBe('station_freeport')
        ->and($result->data[0]->start_time)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->defender_id)->toBeNull()
        ->and($result->data[0]->defender_score)->toBeNull()
        ->and($result->data[0]->attackers_score)->toBeNull()
        ->and($result->data[0]->participants)->toHaveCount(2)
        ->and($result->data[0]->participants[0]->alliance_id)->toBe(99000001)
        ->and($result->data[0]->participants[0]->score)->toBe(0.75)
        ->and($result->data[1]->defender_id)->toBe(99000003)
        ->and($result->data[1]->defender_score)->toBe(0.6)
        ->and($result->data[1]->attackers_score)->toBe(0.4)
        ->and($result->data[1]->participants)->toBe([]);
});

// ---------------------------------------------------------------------
// Search
// ---------------------------------------------------------------------

it('searches for entities and groups the results by category', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/search*' => Http::response(esiFixture('search/result.json')),
    ]);

    $result = (new Esi)->search(fakeCharacter(), ['agent', 'character', 'solar_system'], 'Jita', true);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(SearchResult::class)
        ->and($result->data->agent)->toBe([3019582])
        ->and($result->data->character)->toBe([95465499])
        ->and($result->data->solar_system)->toBe([30000142])
        ->and($result->data->alliance)->toBeEmpty()
        ->and($result->data->corporation)->toBeEmpty()
        ->and($result->data->faction)->toBeEmpty()
        ->and($result->data->inventory_type)->toBeEmpty()
        ->and($result->data->region)->toBeEmpty()
        ->and($result->data->station)->toBeEmpty()
        ->and($result->data->structure)->toBeEmpty();

    Http::assertSent(fn ($request) => str_contains($request->url(), 'categories=agent%2Ccharacter%2Csolar_system')
        && str_contains($request->url(), 'search=Jita')
        && str_contains($request->url(), 'strict=1'));
});

it('defaults strict to false when searching', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/search*' => Http::response(esiFixture('search/result.json')),
    ]);

    (new Esi)->search(fakeCharacter(), ['character'], 'Jita');

    Http::assertSent(fn ($request) => str_contains($request->url(), 'categories=character')
        && str_contains($request->url(), 'strict=0'));
});

it('returns an error result when the search endpoint fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/search*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->search(fakeCharacter(), ['character'], 'Jita');

    expect($result->failed())->toBeTrue();
});

// ---------------------------------------------------------------------
// Access lists
// ---------------------------------------------------------------------

it('fetches and maps access lists owned by a character', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/access-lists*' => Http::response(esiFixture('access/lists.json')),
    ]);

    $result = (new Esi)->getAccessLists(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(2)
        ->and($result->data[0])->toBeInstanceOf(AccessList::class)
        ->and($result->data[0]->id)->toBe(1)
        ->and($result->data[0]->name)->toBeNull()
        ->and($result->data[0]->description)->toBeNull()
        ->and($result->data[0]->membership)->toBeNull()
        ->and($result->data[1]->id)->toBe(2);
});

it('fetches and maps the details of an access list', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/access-lists/1*' => Http::response(esiFixture('access/list.json')),
    ]);

    $result = (new Esi)->getAccessList(fakeCharacter(), 1);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(AccessList::class)
        ->and($result->data->id)->toBe(1)
        ->and($result->data->name)->toBe('Corp Leadership')
        ->and($result->data->description)->toBe('Access for corp leadership')
        ->and($result->data->membership?->allow_everyone)->toBeFalse()
        ->and($result->data->membership?->alliances[0]->alliance_id)->toBe(99000001)
        ->and($result->data->membership?->alliances[0]->access)->toBe('Allowed')
        ->and($result->data->membership?->corporations[0]->corporation_id)->toBe(98000001)
        ->and($result->data->membership?->corporations[0]->access)->toBe('Manager')
        ->and($result->data->membership?->characters[0]->character_id)->toBe(95465499)
        ->and($result->data->membership?->characters[0]->access)->toBe('Admin');
});

it('returns an error result when fetching access lists fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/access-lists*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getAccessLists(fakeCharacter());

    expect($result->failed())->toBeTrue();
});

// ---------------------------------------------------------------------
// Mercenary tactical operations (activities)
// ---------------------------------------------------------------------

it('fetches and maps mercenary tactical operations', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mercenary-tactical-operations*' => Http::response(esiFixture('activities/operations.json')),
    ]);

    $result = (new Esi)->getMercenaryTacticalOperations(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(MercenaryTacticalOperation::class)
        ->and($result->data[0]->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7')
        ->and($result->data[0]->mercenary_den_id)->toBe(1000000000001)
        ->and($result->data[0]->state)->toBeNull()
        ->and($result->data[0]->dungeon_type_id)->toBeNull()
        ->and($result->data[0]->expires)->toBeNull();
});

it('fetches and maps the details of a mercenary tactical operation', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mercenary-tactical-operations/3868eaed-8278-4cb7-9709-7d7de9c20dc7*' => Http::response(esiFixture('activities/operation.json')),
    ]);

    $result = (new Esi)->getMercenaryTacticalOperation(fakeCharacter(), '3868eaed-8278-4cb7-9709-7d7de9c20dc7');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(MercenaryTacticalOperation::class)
        ->and($result->data->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7')
        ->and($result->data->mercenary_den_id)->toBe(1000000000001)
        ->and($result->data->state)->toBe('Started')
        ->and($result->data->dungeon_type_id)->toBe(12367)
        ->and($result->data->expires)->toBe('2026-02-23T12:00:00Z');
});

it('returns an error result when fetching mercenary tactical operations fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/mercenary-tactical-operations*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getMercenaryTacticalOperations(fakeCharacter());

    expect($result->failed())->toBeTrue();
});

// ---------------------------------------------------------------------
// Freelance jobs
// ---------------------------------------------------------------------

it('fetches and maps the public freelance jobs listing', function (): void {
    Http::fake([
        'esi.evetech.net/freelance-jobs*' => Http::response(esiFixture('freelance/jobs.json')),
    ]);

    $result = (new Esi)->getFreelanceJobs();

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FreelanceJob::class)
        ->and($result->data[0]->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7')
        ->and($result->data[0]->name)->toBe('Freelance Job Name')
        ->and($result->data[0]->state)->toBe('Active')
        ->and($result->data[0]->last_modified)->toBe('2025-11-01T00:00:00Z')
        ->and($result->data[0]->progress?->current)->toBe(50)
        ->and($result->data[0]->progress?->desired)->toBe(100)
        ->and($result->data[0]->reward?->initial)->toBe(12345.5)
        ->and($result->data[0]->reward?->remaining)->toBe(5432.1)
        ->and($result->data[0]->access_and_visibility)->toBeNull()
        ->and($result->data[0]->configuration)->toBeNull()
        ->and($result->data[0]->contribution)->toBeNull()
        ->and($result->data[0]->details)->toBeNull();
});

it('fetches and maps the full details of a freelance job', function (): void {
    Http::fake([
        'esi.evetech.net/freelance-jobs/3868eaed-8278-4cb7-9709-7d7de9c20dc7*' => Http::response(esiFixture('freelance/job.json')),
    ]);

    $result = (new Esi)->getFreelanceJob('3868eaed-8278-4cb7-9709-7d7de9c20dc7');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(FreelanceJob::class)
        ->and($result->data->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7')
        ->and($result->data->access_and_visibility?->acl_protected)->toBeFalse()
        ->and($result->data->access_and_visibility?->broadcast_locations[0]->id)->toBe(30000142)
        ->and($result->data->access_and_visibility?->broadcast_locations[0]->name)->toBe('Jita')
        ->and($result->data->access_and_visibility?->restrictions?->maximum_age)->toBe(100)
        ->and($result->data->access_and_visibility?->restrictions?->minimum_age)->toBe(10)
        ->and($result->data->configuration?->method)->toBe('BoostShield')
        ->and($result->data->configuration?->parameters)->toBe(['target' => ['matcher' => ['type_id' => 34]]])
        ->and($result->data->contribution?->contribution_per_participant_limit)->toBe(1000)
        ->and($result->data->contribution?->max_committed_participants)->toBe(10000)
        ->and($result->data->contribution?->reward_per_contribution)->toBe(123.5)
        ->and($result->data->contribution?->submission_limit)->toBe(100)
        ->and($result->data->contribution?->submission_multiplier)->toBe(1.5)
        ->and($result->data->details?->career)->toBe('Explorer')
        ->and($result->data->details?->created)->toBe('2025-11-01T00:00:00Z')
        ->and($result->data->details?->description)->toBe('Freelance Job Description')
        ->and($result->data->details?->expires)->toBe('2025-11-01T00:01:00Z')
        ->and($result->data->details?->finished)->toBe('2025-11-01T00:00:00Z')
        ->and($result->data->details?->creator?->character->id)->toBe(90000001)
        ->and($result->data->details?->creator?->character->name)->toBe('Creator Name')
        ->and($result->data->details?->creator?->corporation->id)->toBe(98777771)
        ->and($result->data->details?->creator?->corporation->name)->toBe('Creator Corporation');
});

it('fetches and maps the freelance jobs created by a character', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/freelance-jobs*' => Http::response(esiFixture('freelance/jobs.json')),
    ]);

    $result = (new Esi)->getCharacterFreelanceJobs(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FreelanceJob::class)
        ->and($result->data[0]->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7');
});

it("fetches and maps a character's participation in a freelance job", function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/freelance-jobs/3868eaed-8278-4cb7-9709-7d7de9c20dc7/participation*' => Http::response(esiFixture('freelance/participation.json')),
    ]);

    $result = (new Esi)->getCharacterFreelanceJobParticipation(fakeCharacter(), '3868eaed-8278-4cb7-9709-7d7de9c20dc7');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(FreelanceJobParticipation::class)
        ->and($result->data->state)->toBe('Committed')
        ->and($result->data->contributed)->toBe(100)
        ->and($result->data->last_modified)->toBe('2025-11-01T00:00:00Z');
});

it('fetches and maps the freelance jobs created by a corporation', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/freelance-jobs*' => Http::response(esiFixture('freelance/jobs.json')),
    ]);

    $result = (new Esi)->getCorporationFreelanceJobs(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FreelanceJob::class)
        ->and($result->data[0]->id)->toBe('3868eaed-8278-4cb7-9709-7d7de9c20dc7');
});

it("fetches and maps a corporation's freelance job participants", function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/freelance-jobs/3868eaed-8278-4cb7-9709-7d7de9c20dc7/participants*' => Http::response(esiFixture('freelance/participants.json')),
    ]);

    $result = (new Esi)->getCorporationFreelanceJobParticipants(fakeCharacter(), 456, '3868eaed-8278-4cb7-9709-7d7de9c20dc7');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(FreelanceJobParticipant::class)
        ->and($result->data[0]->id)->toBe(90000001)
        ->and($result->data[0]->name)->toBe('Participant Name')
        ->and($result->data[0]->state)->toBe('Committed')
        ->and($result->data[0]->contributed)->toBe(100);
});

it('returns an error result when fetching freelance jobs fails', function (): void {
    Http::fake([
        'esi.evetech.net/freelance-jobs*' => Http::response('error', 500),
    ]);

    $result = (new Esi)->getFreelanceJobs();

    expect($result->failed())->toBeTrue();
});
