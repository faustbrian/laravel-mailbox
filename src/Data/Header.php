<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Data;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final readonly class Header implements Arrayable, JsonSerializable
{
    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
