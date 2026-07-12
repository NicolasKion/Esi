<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use NicolasKion\Esi\DTO\CalendarEvent;
use NicolasKion\Esi\DTO\CalendarEventAttendee;
use NicolasKion\Esi\DTO\CalendarEventSummary;
use NicolasKion\Esi\DTO\CustomsOffice;
use NicolasKion\Esi\DTO\Fitting;
use NicolasKion\Esi\DTO\PlanetColony;
use NicolasKion\Esi\DTO\PlanetLayout;
use NicolasKion\Esi\Esi;
use NicolasKion\Esi\Requests\CreateFittingRequest;
use NicolasKion\Esi\Requests\DeleteFittingRequest;
use NicolasKion\Esi\Requests\RespondToCalendarEventRequest;

// -----------------------------------------------------------------------
// Calendar
// -----------------------------------------------------------------------

it('fetches and maps a character calendar', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/calendar/' => Http::response([
            [
                'event_date' => '2026-06-09T12:00:00Z',
                'event_id' => 90000001,
                'event_response' => 'accepted',
                'importance' => 1,
                'title' => 'Fleet Op',
            ],
        ]),
    ]);

    $result = (new Esi)->getCalendar(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CalendarEventSummary::class)
        ->and($result->data[0]->event_date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->event_id)->toBe(90000001)
        ->and($result->data[0]->event_response)->toBe('accepted')
        ->and($result->data[0]->importance)->toBe(1)
        ->and($result->data[0]->title)->toBe('Fleet Op');
});

it('returns an error result when the calendar endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/calendar/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCalendar(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps the full details of a calendar event', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/calendar/90000001/' => Http::response([
            'date' => '2026-06-09T12:00:00Z',
            'duration' => 60,
            'event_id' => 90000001,
            'importance' => 1,
            'owner_id' => 1,
            'owner_name' => 'EVE System',
            'owner_type' => 'eve_server',
            'response' => 'Accepted',
            'text' => 'Event text',
            'title' => 'Fleet Op',
        ]),
    ]);

    $result = (new Esi)->getCalendarEvent(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(CalendarEvent::class)
        ->and($result->data->date)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->duration)->toBe(60)
        ->and($result->data->event_id)->toBe(90000001)
        ->and($result->data->importance)->toBe(1)
        ->and($result->data->owner_id)->toBe(1)
        ->and($result->data->owner_name)->toBe('EVE System')
        ->and($result->data->owner_type)->toBe('eve_server')
        ->and($result->data->response)->toBe('Accepted')
        ->and($result->data->text)->toBe('Event text')
        ->and($result->data->title)->toBe('Fleet Op');
});

it('fetches and maps the attendees of a calendar event', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/calendar/90000001/attendees/' => Http::response([
            ['character_id' => 90000002, 'event_response' => 'accepted'],
        ]),
    ]);

    $result = (new Esi)->getCalendarEventAttendees(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CalendarEventAttendee::class)
        ->and($result->data[0]->character_id)->toBe(90000002)
        ->and($result->data[0]->event_response)->toBe('accepted');
});

it('responds to a calendar event invitation', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/calendar/90000001/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->respondToCalendarEvent(fakeCharacter(), 90000001, 'accepted');

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeNull();

    Http::assertSent(fn ($request) => $request->method() === 'PUT'
        && str_contains($request->url(), '/characters/123/calendar/90000001/')
        && $request->data() === ['response' => 'accepted']);
});

it('returns an error result when responding to a calendar event fails', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/calendar/90000001/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->respondToCalendarEvent(fakeCharacter(), 90000001, 'declined');

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('always retries calendar event response requests', function (): void {
    $serverError = new Response(new Psr7Response(500));

    expect((new RespondToCalendarEventRequest(123, 90000001, 'accepted'))->shouldRetry($serverError))->toBeTrue();
});

// -----------------------------------------------------------------------
// Fittings
// -----------------------------------------------------------------------

it('fetches and maps a character fittings', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fittings/' => Http::response([
            [
                'description' => 'A cheap ratting fit',
                'fitting_id' => 1,
                'items' => [
                    ['flag' => 'HiSlot0', 'quantity' => 1, 'type_id' => 2],
                ],
                'name' => 'Ratting Fit',
                'ship_type_id' => 3,
            ],
        ]),
    ]);

    $result = (new Esi)->getFittings(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(Fitting::class)
        ->and($result->data[0]->description)->toBe('A cheap ratting fit')
        ->and($result->data[0]->fitting_id)->toBe(1)
        ->and($result->data[0]->name)->toBe('Ratting Fit')
        ->and($result->data[0]->ship_type_id)->toBe(3)
        ->and($result->data[0]->items)->toHaveCount(1)
        ->and($result->data[0]->items[0]->flag)->toBe('HiSlot0')
        ->and($result->data[0]->items[0]->quantity)->toBe(1)
        ->and($result->data[0]->items[0]->type_id)->toBe(2);
});

it('returns an error result when the fittings endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fittings/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getFittings(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('creates a fitting and returns the new fitting id', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fittings/' => Http::response(['fitting_id' => 90000001], 201),
    ]);

    $items = [
        ['flag' => 'HiSlot0', 'quantity' => 1, 'type_id' => 2],
    ];

    $result = (new Esi)->createFitting(fakeCharacter(), 'Ratting Fit', 'A cheap ratting fit', 3, $items);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBe(90000001);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/characters/123/fittings/')
        && $request->data() === [
            'description' => 'A cheap ratting fit',
            'items' => $items,
            'name' => 'Ratting Fit',
            'ship_type_id' => 3,
        ]);
});

it('returns an error result when creating a fitting fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fittings/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->createFitting(fakeCharacter(), 'Ratting Fit', 'A cheap ratting fit', 3, []);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('deletes a fitting', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/fittings/90000001/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->deleteFitting(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE'
        && str_contains($request->url(), '/characters/123/fittings/90000001/'));
});

it('never retries fitting creation or deletion requests', function (): void {
    $serverError = new Response(new Psr7Response(500));

    expect((new CreateFittingRequest(123, 'name', 'description', 1, []))->shouldRetry($serverError))->toBeFalse()
        ->and((new DeleteFittingRequest(123, 90000001))->shouldRetry($serverError))->toBeFalse();
});

// -----------------------------------------------------------------------
// Planetary Interaction
// -----------------------------------------------------------------------

it('fetches and maps a character\'s planetary colonies', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/planets/' => Http::response([
            [
                'last_update' => '2026-06-09T12:00:00Z',
                'num_pins' => 4,
                'owner_id' => 123,
                'planet_id' => 40000001,
                'planet_type' => 'temperate',
                'solar_system_id' => 30000142,
                'upgrade_level' => 2,
            ],
        ]),
    ]);

    $result = (new Esi)->getPlanets(fakeCharacter());

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(PlanetColony::class)
        ->and($result->data[0]->last_update)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data[0]->num_pins)->toBe(4)
        ->and($result->data[0]->owner_id)->toBe(123)
        ->and($result->data[0]->planet_id)->toBe(40000001)
        ->and($result->data[0]->planet_type)->toBe('temperate')
        ->and($result->data[0]->solar_system_id)->toBe(30000142)
        ->and($result->data[0]->upgrade_level)->toBe(2);
});

it('returns an error result when the planets endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/planets/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getPlanets(fakeCharacter());

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps the full layout of a planetary colony', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/planets/40000001/' => Http::response([
            'links' => [
                ['destination_pin_id' => 2, 'link_level' => 0, 'source_pin_id' => 1],
            ],
            'pins' => [
                [
                    'contents' => [
                        ['amount' => 100, 'type_id' => 2073],
                    ],
                    'expiry_time' => '2026-06-10T12:00:00Z',
                    'extractor_details' => [
                        'cycle_time' => 1800,
                        'head_radius' => 0.5,
                        'heads' => [
                            ['head_id' => 0, 'latitude' => 1.1, 'longitude' => 2.2],
                        ],
                        'product_type_id' => 2073,
                        'qty_per_cycle' => 100,
                    ],
                    'factory_details' => [
                        'schematic_id' => 65,
                    ],
                    'install_time' => '2026-06-09T12:00:00Z',
                    'last_cycle_start' => '2026-06-09T18:00:00Z',
                    'latitude' => 1.5,
                    'longitude' => 2.5,
                    'pin_id' => 1,
                    'schematic_id' => 65,
                    'type_id' => 2848,
                ],
            ],
            'routes' => [
                [
                    'content_type_id' => 2073,
                    'destination_pin_id' => 2,
                    'quantity' => 100.0,
                    'route_id' => 1,
                    'source_pin_id' => 1,
                    'waypoints' => [3, 4],
                ],
            ],
        ]),
    ]);

    $result = (new Esi)->getPlanetLayout(fakeCharacter(), 40000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toBeInstanceOf(PlanetLayout::class)
        ->and($result->data->links)->toHaveCount(1)
        ->and($result->data->links[0]->destination_pin_id)->toBe(2)
        ->and($result->data->links[0]->link_level)->toBe(0)
        ->and($result->data->links[0]->source_pin_id)->toBe(1)
        ->and($result->data->pins)->toHaveCount(1)
        ->and($result->data->pins[0]->pin_id)->toBe(1)
        ->and($result->data->pins[0]->type_id)->toBe(2848)
        ->and($result->data->pins[0]->latitude)->toBe(1.5)
        ->and($result->data->pins[0]->longitude)->toBe(2.5)
        ->and($result->data->pins[0]->schematic_id)->toBe(65)
        ->and($result->data->pins[0]->install_time)->toBe('2026-06-09T12:00:00Z')
        ->and($result->data->pins[0]->expiry_time)->toBe('2026-06-10T12:00:00Z')
        ->and($result->data->pins[0]->last_cycle_start)->toBe('2026-06-09T18:00:00Z')
        ->and($result->data->pins[0]->contents)->toHaveCount(1)
        ->and($result->data->pins[0]->contents[0]->amount)->toBe(100)
        ->and($result->data->pins[0]->contents[0]->type_id)->toBe(2073)
        ->and($result->data->pins[0]->extractor_details?->cycle_time)->toBe(1800)
        ->and($result->data->pins[0]->extractor_details?->head_radius)->toBe(0.5)
        ->and($result->data->pins[0]->extractor_details?->product_type_id)->toBe(2073)
        ->and($result->data->pins[0]->extractor_details?->qty_per_cycle)->toBe(100)
        ->and($result->data->pins[0]->extractor_details?->heads)->toHaveCount(1)
        ->and($result->data->pins[0]->extractor_details?->heads[0]->head_id)->toBe(0)
        ->and($result->data->pins[0]->extractor_details?->heads[0]->latitude)->toBe(1.1)
        ->and($result->data->pins[0]->extractor_details?->heads[0]->longitude)->toBe(2.2)
        ->and($result->data->pins[0]->factory_details?->schematic_id)->toBe(65)
        ->and($result->data->routes)->toHaveCount(1)
        ->and($result->data->routes[0]->route_id)->toBe(1)
        ->and($result->data->routes[0]->source_pin_id)->toBe(1)
        ->and($result->data->routes[0]->destination_pin_id)->toBe(2)
        ->and($result->data->routes[0]->content_type_id)->toBe(2073)
        ->and($result->data->routes[0]->quantity)->toBe(100.0)
        ->and($result->data->routes[0]->waypoints)->toBe([3, 4]);
});

it('fetches a planet layout without optional pin details', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/planets/40000001/' => Http::response([
            'links' => [],
            'pins' => [
                ['latitude' => 1.5, 'longitude' => 2.5, 'pin_id' => 1, 'type_id' => 2848],
            ],
            'routes' => [],
        ]),
    ]);

    $result = (new Esi)->getPlanetLayout(fakeCharacter(), 40000001);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data->pins[0]->contents)->toBeNull()
        ->and($result->data->pins[0]->extractor_details)->toBeNull()
        ->and($result->data->pins[0]->factory_details)->toBeNull()
        ->and($result->data->pins[0]->schematic_id)->toBeNull()
        ->and($result->data->pins[0]->install_time)->toBeNull()
        ->and($result->data->pins[0]->expiry_time)->toBeNull()
        ->and($result->data->pins[0]->last_cycle_start)->toBeNull();
});

it('returns an error result when the planet layout endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/characters/123/planets/40000001/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getPlanetLayout(fakeCharacter(), 40000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('fetches and maps paginated corporation customs offices', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/customs_offices/*' => Http::response([
            [
                'allow_access_with_standings' => true,
                'allow_alliance_access' => true,
                'alliance_tax_rate' => 0.1,
                'bad_standing_tax_rate' => 0.5,
                'corporation_tax_rate' => 0.2,
                'excellent_standing_tax_rate' => 0.05,
                'good_standing_tax_rate' => 0.1,
                'neutral_standing_tax_rate' => 0.15,
                'office_id' => 90000001,
                'reinforce_exit_end' => 18,
                'reinforce_exit_start' => 16,
                'standing_level' => 'bad',
                'system_id' => 30000142,
                'terrible_standing_tax_rate' => 0.6,
                'type_id' => 2233,
            ],
        ], 200, ['X-Pages' => '1']),
    ]);

    $result = (new Esi)->getCorporationCustomsOffices(fakeCharacter(), 456);

    expect($result->wasSuccessful())->toBeTrue()
        ->and($result->data)->toHaveCount(1)
        ->and($result->data[0])->toBeInstanceOf(CustomsOffice::class)
        ->and($result->data[0]->office_id)->toBe(90000001)
        ->and($result->data[0]->system_id)->toBe(30000142)
        ->and($result->data[0]->reinforce_exit_start)->toBe(16)
        ->and($result->data[0]->reinforce_exit_end)->toBe(18)
        ->and($result->data[0]->allow_alliance_access)->toBeTrue()
        ->and($result->data[0]->allow_access_with_standings)->toBeTrue()
        ->and($result->data[0]->alliance_tax_rate)->toBe(0.1)
        ->and($result->data[0]->bad_standing_tax_rate)->toBe(0.5)
        ->and($result->data[0]->corporation_tax_rate)->toBe(0.2)
        ->and($result->data[0]->excellent_standing_tax_rate)->toBe(0.05)
        ->and($result->data[0]->good_standing_tax_rate)->toBe(0.1)
        ->and($result->data[0]->neutral_standing_tax_rate)->toBe(0.15)
        ->and($result->data[0]->standing_level)->toBe('bad')
        ->and($result->data[0]->terrible_standing_tax_rate)->toBe(0.6)
        ->and($result->data[0]->type_id)->toBe(2233);
});

it('returns an error result when the corporation customs offices endpoint fails with a server error', function (): void {
    Http::fake([
        'esi.evetech.net/corporations/456/customs_offices/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->getCorporationCustomsOffices(fakeCharacter(), 456);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

// -----------------------------------------------------------------------
// User Interface
// -----------------------------------------------------------------------

it('opens the information window for a target', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/information/*' => Http::response(null, 204),
    ]);

    $result = (new Esi)->openInformationWindow(fakeCharacter(), 90000001);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/ui/openwindow/information/')
        && str_contains($request->url(), 'target_id=90000001'));
});

it('returns an error result when opening the information window fails', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/information/*' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->openInformationWindow(fakeCharacter(), 90000001);

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});

it('opens the market details window for a type', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/marketdetails/*' => Http::response(null, 204),
    ]);

    $result = (new Esi)->openMarketDetailsWindow(fakeCharacter(), 587);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/ui/openwindow/marketdetails/')
        && str_contains($request->url(), 'type_id=587'));
});

it('opens the new mail window with recipients, subject, and body', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/newmail/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->openNewMailWindow(fakeCharacter(), [90000001, 90000002], 'Subject', 'Body', 98000001);

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/ui/openwindow/newmail/')
        && $request->data() === [
            'body' => 'Body',
            'recipients' => [90000001, 90000002],
            'subject' => 'Subject',
            'to_corp_or_alliance_id' => 98000001,
        ]);
});

it('opens the new mail window without an optional corp or alliance id', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/newmail/' => Http::response(null, 204),
    ]);

    $result = (new Esi)->openNewMailWindow(fakeCharacter(), [90000001], 'Subject', 'Body');

    expect($result->wasSuccessful())->toBeTrue();

    Http::assertSent(fn ($request) => $request->data() === [
        'body' => 'Body',
        'recipients' => [90000001],
        'subject' => 'Subject',
    ]);
});

it('returns an error result when opening the new mail window fails', function (): void {
    Http::fake([
        'esi.evetech.net/ui/openwindow/newmail/' => Http::response(['error' => 'Internal server error'], 500),
    ]);

    $result = (new Esi)->openNewMailWindow(fakeCharacter(), [90000001], 'Subject', 'Body');

    expect($result->failed())->toBeTrue()
        ->and($result->error?->code)->toBe(500);
});
