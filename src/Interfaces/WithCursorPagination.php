<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

/**
 * Marks a request whose endpoint uses ESI cursor pagination: the response
 * carries a `cursor` object ({after, before}) and the next page is fetched by
 * passing `?after=<cursor.after>` until `after` is empty. The request's
 * createDto() unwraps and hydrates the page's items.
 *
 * @template-covariant TData
 *
 * @extends Request<TData>
 */
interface WithCursorPagination extends Request {}
