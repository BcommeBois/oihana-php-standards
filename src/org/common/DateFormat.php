<?php

namespace org\common;

use org\iso\Iso8601Format;

/**
 * Standard date and time format patterns from various sources.
 *
 * Extends {@see Iso8601Format} and adds non-ISO formats commonly used in
 * the wild: IETF RFC date formats, the HTTP date format (RFC 7231),
 * SQL/database literal formats and the Unix timestamp.
 *
 * Because this class inherits all ISO 8601 constants, it acts as a
 * **single entry point** for any date-time format the project understands.
 *
 * RFC 3339 and ATOM are intentionally not redeclared here: their PHP pattern
 * (`Y-m-d\TH:i:sP`) is identical to {@see Iso8601Format::DATE_TIME}, and
 * RFC 3339 with fractional seconds matches {@see Iso8601Format::DATE_TIME_MILLI}
 * / {@see Iso8601Format::DATE_TIME_MICRO}. Reusing these constants keeps
 * `getConstant()` reverse-lookup deterministic.
 *
 * Example usage:
 * ```php
 * use org\common\DateFormat;
 *
 * $dt = new DateTimeImmutable('2026-05-14 08:15:30', new DateTimeZone('+02:00'));
 *
 * echo $dt->format( DateFormat::RFC2822 );  // "Thu, 14 May 2026 08:15:30 +0200"
 * echo $dt->format( DateFormat::RFC7231 );  // "Thu, 14 May 2026 06:15:30 GMT"
 * echo $dt->format( DateFormat::MYSQL );    // "2026-05-14 08:15:30"
 *
 * // ISO constants are also available via inheritance:
 * echo $dt->format( DateFormat::DATE_TIME_ZULU ) ;
 *
 * DateFormat::includes( Iso8601Format::DATE ) ;     // true (inherited)
 * DateFormat::getConstant('D, d M Y H:i:s O') ;     // "RFC2822"
 * ```
 *
 * @link https://www.rfc-editor.org/rfc/rfc2822 RFC 2822 (Internet Message Format)
 * @link https://www.rfc-editor.org/rfc/rfc7231 RFC 7231 (HTTP/1.1 Semantics)
 *
 * @package org\common
 * @author  Marc Alcaraz (ekameleon)
 * @since   1.0.2
 */
class DateFormat extends Iso8601Format
{
    /**
     * Cookie expiration date (HTTP cookies, RFC 6265): `l, d-M-Y H:i:s T`
     * (e.g. "Thursday, 14-May-2026 08:15:30 UTC").
     */
    public const string COOKIE = 'l, d-M-Y H:i:s T' ;

    /**
     * MySQL / SQLite `DATETIME` literal: `Y-m-d H:i:s`
     * (e.g. "2026-05-14 08:15:30"). Note the space separator instead of `T`.
     */
    public const string MYSQL = 'Y-m-d H:i:s' ;

    /**
     * RFC 822 email date (obsolete; uses 2-digit year): `D, d M y H:i:s O`
     * (e.g. "Thu, 14 May 26 08:15:30 +0200").
     */
    public const string RFC822 = 'D, d M y H:i:s O' ;

    /**
     * RFC 850 Usenet date (obsolete): `l, d-M-y H:i:s T`
     * (e.g. "Thursday, 14-May-26 08:15:30 UTC").
     */
    public const string RFC850 = 'l, d-M-y H:i:s T' ;

    /**
     * RFC 1036 Usenet date: `D, d M y H:i:s O` (same as RFC 822).
     */
    public const string RFC1036 = 'D, d M y H:i:s O' ;

    /**
     * RFC 1123 date (modern email/HTTP, 4-digit year): `D, d M Y H:i:s O`
     * (e.g. "Thu, 14 May 2026 08:15:30 +0200").
     */
    public const string RFC1123 = 'D, d M Y H:i:s O' ;

    /**
     * RFC 2822 Internet Message Format date: `D, d M Y H:i:s O`
     * (e.g. "Thu, 14 May 2026 08:15:30 +0200").
     */
    public const string RFC2822 = 'D, d M Y H:i:s O' ;

    /**
     * RFC 7231 HTTP-date (IMF-fixdate, always GMT): `D, d M Y H:i:s \G\M\T`
     * (e.g. "Thu, 14 May 2026 06:15:30 GMT"). The value must be converted to
     * UTC by the caller before formatting.
     */
    public const string RFC7231 = 'D, d M Y H:i:s \G\M\T' ;

    /**
     * RSS 2.0 pubDate (RFC 822 / 2822 profile): `D, d M Y H:i:s O`
     * (e.g. "Thu, 14 May 2026 08:15:30 +0200").
     */
    public const string RSS = 'D, d M Y H:i:s O' ;

    /**
     * Unix timestamp (seconds since 1970-01-01 00:00:00 UTC): `U`.
     */
    public const string UNIX = 'U' ;
}
