<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Http\Controller;

use BombenProdukt\Mailbox\Driver\DriverInterface;
use BombenProdukt\Mailbox\Event\MailReceived;
use BombenProdukt\Mailbox\Facades\MailboxManager;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

final class WebhookController extends Controller
{
    public function __invoke(string $connection)
    {
        /** @var DriverInterface $connection */
        $connection = App::make(MailboxManager::connection($connection));

        MailReceived::dispatch($connection->toMail());

        return Response::noContent();
    }
}
