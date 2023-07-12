<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Driver;

use BombenProdukt\Mailbox\Data\Mail;
use BombenProdukt\Mailbox\Data\MailParser;

/**
 * @see https://support.sparkpost.com/docs/tech-resources/inbound-email-relay-webhook
 * @see https://developers.sparkpost.com/api/relay-webhooks/#header-relay-webhook-payload
 */
final class SparkPost extends AbstractDriver
{
    public function rules(): array
    {
        return [
            '0.msys' => ['required', 'array'],
            '0.msys.relay_message' => ['required', 'array'],
            '0.msys.relay_message.content' => ['required', 'array'],
            '0.msys.relay_message.content.email_rfc822' => ['required', 'string'],
            '0.msys.relay_message.content.email_rfc822_is_base64' => ['required', 'boolean'],
        ];
    }

    public function toMail(): Mail
    {
        $content = $this->json('0.msys.relay_message.content.email_rfc822');

        if ($this->json('0.msys.relay_message.content.email_rfc822_is_base64')) {
            $content = \base64_decode($content, true);
        }

        return MailParser::fromString($content)->parse();
    }
}
