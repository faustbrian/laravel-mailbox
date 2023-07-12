<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Facades;

use BombenProdukt\Mailbox\Filter;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Filter[] allFilters()
 * @method static Filter[] allFiltersByConnection(string $connection)
 * @method static void     bcc(string $connection, string $pattern, string|Closure $classOrAction)
 * @method static void     catchAll(string $connection, string|Closure $classOrAction)
 * @method static void     cc(string $connection, string $pattern, string|Closure $classOrAction)
 * @method static void     fallback(string $connection, string|Closure $classOrAction)
 * @method static void     filter(string $connection, string $field, string $pattern, string|Closure $classOrAction)
 * @method static void     from(string $connection, string $pattern, string|Closure $classOrAction)
 * @method static void     subject(string $connection, string $pattern, string|Closure $classOrAction)
 * @method static void     to(string $connection, string $pattern, string|Closure $classOrAction)
 */
final class Mailbox extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BombenProdukt\Mailbox\Mailbox::class;
    }
}
