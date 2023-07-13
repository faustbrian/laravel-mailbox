<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Driver;

use BombenProdukt\Mailbox\Data\Address;
use BombenProdukt\Mailbox\Data\Attachment;
use BombenProdukt\Mailbox\Data\Header;
use BombenProdukt\Mailbox\Data\Mail;
use Carbon\Carbon;
use EmailReplyParser\EmailReplyParser;
use Illuminate\Support\Arr;

/**
 * @see https://developers.brevo.com/docs/inbound-parse-webhooks
 */
final class Brevo extends AbstractDriver
{
    public function rules(): array
    {
        return [];
    }

    public function toMail(): Mail
    {
        return new Mail(
            headers: $this->mapHeaders($this->json('items.0.Headers')),
            id: $this->json('items.0.Uuid.0'),
            date: Carbon::make($this->json('items.0.SentAtDate')),
            text: $this->json('items.0.RawTextBody'),
            textVisible: EmailReplyParser::parseReply($this->json('items.0.RawTextBody')),
            html: $this->json('items.0.RawHtmlBody'),
            subject: $this->json('items.0.Subject'),
            from: new Address(
                name: $this->json('items.0.From.Name'),
                mail: $this->json('items.0.From.Address'),
            ),
            to: $this->mapAddresses($this->json('items.0.To')),
            cc: $this->mapAddresses($this->json('items.0.Cc', [])),
            bcc: $this->mapAddresses($this->json('items.0.Bcc', [])),
            attachments: $this->mapAttachments($this->json('items.0.Attachments')),
        );
    }

    /**
     * @return Header[]
     */
    private function mapHeaders(array $items): array
    {
        $headers = [];

        foreach ($items as $key => $value) {
            $headers[] = new Header($key, $value);
        }

        return $headers;
    }

    /**
     * @return Address[]
     */
    private function mapAddresses(array $items): array
    {
        $addresses = [];

        foreach ($items as $item) {
            $addresses[] = new Address(
                name: Arr::get($item, 'Name') ?: null,
                mail: Arr::get($item, 'Address') ?: null,
            );
        }

        return $addresses;
    }

    /**
     * @return Attachment[]
     */
    private function mapAttachments(array $items): array
    {
        $files = [];

        foreach ($items as $item) {
            $files[] = new Attachment(
                type: $item['ContentType'],
                name: $item['Name'],
                content: $item['ContentID'],
            );
        }

        return $files;
    }
}
