<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Driver;

use BombenProdukt\Mailbox\Data\Mail;

interface DriverInterface
{
    public function toMail(): Mail;
}
