<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox;

use Closure;

final class Mailbox
{
    /**
     * @var array<string, array<string, array<MailboxFilter>>>
     */
    private array $filters = [];

    /**
     * @return array<string, array<MailboxFilter>>
     */
    public function allFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return array<string, array<MailboxFilter>>
     */
    public function allFiltersByConnection(string $connection): array
    {
        return $this->filters[$connection];
    }

    public function filter(string $connection, string $field, string $pattern, string|Closure $classOrAction): void
    {
        $this->filters[$connection][] = new Filter($field, $pattern, $classOrAction);
    }

    public function from(string $connection, string $pattern, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'from', $pattern, $classOrAction);
    }

    public function to(string $connection, string $pattern, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'to', $pattern, $classOrAction);
    }

    public function cc(string $connection, string $pattern, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'cc', $pattern, $classOrAction);
    }

    public function bcc(string $connection, string $pattern, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'bcc', $pattern, $classOrAction);
    }

    public function subject(string $connection, string $pattern, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'subject', $pattern, $classOrAction);
    }

    public function fallback(string $connection, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'fallback', '*', $classOrAction);
    }

    public function catchAll(string $connection, string|Closure $classOrAction): void
    {
        $this->filter($connection, 'catchAll', '*', $classOrAction);
    }
}
