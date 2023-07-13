<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Manager;

use BombenProdukt\Mailbox\Driver\DriverInterface;
use BombenProdukt\Manager\AbstractManager;

final class MailboxManager extends AbstractManager
{
    protected function createConnection(array $config): DriverInterface
    {
        return new $config['driver']();
    }

    protected function getConfigName(): string
    {
        return 'mailbox';
    }
}
