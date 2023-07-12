<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Data;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use JsonSerializable;
use ZBateson\MailMimeParser\Header\Part\AddressPart;
use ZBateson\MailMimeParser\Message\MessagePart;

final class Mail implements Arrayable, JsonSerializable
{
    /**
     * @param AddressPart[] $to
     * @param AddressPart[] $cc
     * @param AddressPart[] $bcc
     * @param MessagePart[] $attachments
     */
    public function __construct(
        private readonly array $headers,
        private readonly string $id,
        private readonly Carbon $date,
        private readonly ?string $text,
        private readonly ?string $textVisible,
        private readonly ?string $html,
        private readonly ?string $subject,
        private readonly Address $from,
        private readonly array $to,
        private readonly array $cc,
        private readonly array $bcc,
        private readonly array $attachments,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function getTextVisible(): ?string
    {
        return $this->textVisible;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getFrom(): Address
    {
        return $this->from;
    }

    /**
     * @return Address[]
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * @return Address[]
     */
    public function getCc(): array
    {
        return $this->cc;
    }

    /**
     * @return Address[]
     */
    public function getBcc(): array
    {
        return $this->bcc;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getHeader(string $header, ?string $default = null): ?string
    {
        return Arr::get($this->headers, $header, $default);
    }

    public function getBody(): ?string
    {
        if ($this->isHtml()) {
            return $this->getHtml();
        }

        return $this->getText();
    }

    public function isHtml(): bool
    {
        return !empty($this->getHtml());
    }

    public function isText(): bool
    {
        return !empty($this->getText());
    }

    public function isValid(): bool
    {
        return $this->getFrom() !== '' && $this->getBody();
    }

    public function get(string $field): mixed
    {
        return data_get($this, $field);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate()->toIso8601String(),
            'text' => $this->getText(),
            'textVisible' => $this->getTextVisible(),
            'html' => $this->getHtml(),
            'subject' => $this->getSubject(),
            'from' => $this->getFrom()->toArray(),
            'to' => $this->getTo(),
            'cc' => $this->getCc(),
            'bcc' => $this->getBcc(),
            'attachments' => $this->getAttachments(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
