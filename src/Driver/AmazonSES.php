<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Driver;

use BombenProdukt\Mailbox\Data\Mail;
use BombenProdukt\Mailbox\Data\MailParser;
use Illuminate\Support\Facades\Validator;

final class AmazonSES extends AbstractDriver
{
    public function validator()
    {
        return Validator::make(
            \json_decode($this->getContent(), true),
            ['Message' => 'required'],
        );
    }

    public function toMail(): Mail
    {
        return MailParser::fromString(
            \json_decode(\json_decode($this->getContent(), true)['Message'], true)['content'],
        )->parse();
    }
}
