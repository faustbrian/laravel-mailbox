<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox;

use BombenProdukt\Mailbox\Http\Controller\WebhookController;
use BombenProdukt\Mailbox\Manager\MailboxManager;
use BombenProdukt\PackagePowerPack\Package\AbstractServiceProvider;
use Illuminate\Support\Facades\Route;

final class ServiceProvider extends AbstractServiceProvider
{
    public function packageRegistered(): void
    {
        $this->app->singleton(MailboxManager::class);

        Route::post('/mailbox/webhook/{connection}', WebhookController::class)->name('mailbox.webhook');
    }
}
