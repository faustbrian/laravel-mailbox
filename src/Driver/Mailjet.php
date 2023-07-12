<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Driver;

use BombenProdukt\Mailbox\Data\Address;
use BombenProdukt\Mailbox\Data\Header;
use BombenProdukt\Mailbox\Data\Mail;
use Carbon\Carbon;
use EmailReplyParser\EmailReplyParser;

/**
 * @see https://dev.mailjet.com/mandrill/inbound-calls/
 * @see https://dev.mailjet.com/email/guides/parse-api/
 */
final class Mailjet extends AbstractDriver
{
    public function rules(): array
    {
        return [];
    }

    public function toMail(): Mail
    {
        return new Mail(
            headers: $this->mapHeaders($this->json('Headers')),
            id: $this->json('Headers.Message-ID'),
            date: Carbon::make($this->json('Date')),
            text: $this->json('Text-part'),
            textVisible: EmailReplyParser::parseReply($this->json('Text-part')),
            html: $this->json('Html-part'),
            subject: $this->json('Subject'),
            from: new Address(
                name: $this->json('From'),
                mail: $this->json('From'),
            ),
            to: $this->mapAddresses($this->json('Headers.To')),
            cc: $this->mapAddresses($this->json('Headers.Cc', '')),
            bcc: $this->mapAddresses($this->json('Headers.Bcc', '')),
            attachments: [],
        );
    }

    /**
     * @return Header[]
     */
    private function mapHeaders(array $items): array
    {
        $headers = [];

        foreach ($items as $name => $value) {
            $headers[] = new Header($name, $value);
        }

        return $headers;
    }

    /**
     * @return Address[]
     */
    private function mapAddresses(string $items): array
    {
        $addresses = [];

        foreach (\explode(',', $items) as $item) {
            if (!empty($item)) {
                $addresses[] = new Address($item, $item);
            }
        }

        return $addresses;
    }
}
