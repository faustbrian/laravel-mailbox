<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Http\Controller;

use BombenProdukt\Mailbox\Driver\DriverInterface;
use BombenProdukt\Mailbox\Event\MailReceived;
use BombenProdukt\Mailbox\Facades\Mailbox;
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

        MailReceived::dispatch($mail = $connection->toMail());

        foreach (Mailbox::allFiltersByConnection($connection) as $filter) {
            if ($filter->matches($mail)) {
                $filter->handle($mail);
            }
        }

        return Response::noContent();
    }
}
