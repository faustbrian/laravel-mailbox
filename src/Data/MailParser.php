<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Data;

use Carbon\Carbon;
use EmailReplyParser\EmailReplyParser;
use Illuminate\Support\Str;
use ZBateson\MailMimeParser\Header\AddressHeader;
use ZBateson\MailMimeParser\Header\IHeader;
use ZBateson\MailMimeParser\Message;
use ZBateson\MailMimeParser\Message\IMessagePart;

final class MailParser
{
    private function __construct(private readonly Message $message) {}

    public static function fromMessage(Message $message): self
    {
        return new self($message);
    }

    public static function fromString(string $message): self
    {
        return self::fromMessage(Message::from($message, true));
    }

    public function parse(): Mail
    {
        return new Mail(
            headers: $this->mapHeaders($this->message->getAllHeaders()),
            id: $this->message->getHeaderValue('Message-Id', Str::random()),
            date: Carbon::make($this->message->getHeaderValue('Date')),
            text: $this->message->getTextContent(),
            textVisible: EmailReplyParser::parseReply($this->message->getTextContent()),
            html: $this->message->getHtmlContent(),
            subject: $this->message->getHeaderValue('Subject'),
            from: $this->from(),
            to: $this->mapAddresses($this->message->getHeader('To')),
            cc: $this->mapAddresses($this->message->getHeader('Cc')),
            bcc: $this->mapAddresses($this->message->getHeader('Bcc')),
            attachments: $this->mapAttachments($this->message->getAllAttachmentParts()),
        );
    }

    public function from(): Address
    {
        $from = $this->message->getHeader('From');

        if ($from instanceof AddressHeader) {
            return new Address(
                name: $from->getPersonName(),
                mail: $from->getEmail(),
            );
        }

        return new Address(null, null);
    }

    /**
     * @param  IHeader[] $items
     * @return Header[]
     */
    private function mapHeaders(array $items): array
    {
        $headers = [];

        foreach ($items as $item) {
            $headers[] = new Header($item->getName(), $item->getValue());
        }

        return $headers;
    }

    /**
     * @return Address[]
     */
    private function mapAddresses(?AddressHeader $header): array
    {
        $addresses = [];

        if ($header instanceof AddressHeader) {
            foreach ($header->getAddresses() as $address) {
                $addresses[] = new Address(
                    name: $address->getName() ?: null,
                    mail: $address->getEmail() ?: null,
                );
            }
        }

        return $addresses;
    }

    /**
     * @param  IMessagePart[] $attachments
     * @return Attachment[]
     */
    private function mapAttachments(array $attachments): array
    {
        $files = [];

        foreach ($attachments as $attachment) {
            $files[] = new Attachment(
                type: $attachment->getContentType(),
                name: $attachment->getFilename(),
                content: $attachment->getContent(),
            );
        }

        return $files;
    }
}
