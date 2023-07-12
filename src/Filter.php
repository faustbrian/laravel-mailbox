<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox;

use BombenProdukt\Mailbox\Data\Mail;
use Closure;
use Illuminate\Support\Facades\App;

final readonly class Filter
{
    public function __construct(
        private string $field,
        private string $pattern,
        private string|Closure $handler,
    ) {}

    public function getField(): string
    {
        return $this->field;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getHandler(): string|Closure
    {
        return $this->handler;
    }

    public function matches(Mail $mail): bool
    {
        return \preg_match($this->pattern, $mail->get($this->field)) === 1;
    }

    public function handle(Mail $mail): void
    {
        if (\is_string($this->handler)) {
            App::call([$this->handler, 'handle'], ['mail' => $mail]);
        } else {
            ($this->handler)($mail);
        }
    }
}
