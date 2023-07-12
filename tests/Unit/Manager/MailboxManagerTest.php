<?php

declare(strict_types=1);

namespace Tests\Unit\Driver;

use BombenProdukt\Mailbox\Facades\MailboxManager;
use Illuminate\Foundation\Http\FormRequest;

it('should create a connection by default (main)', function (): void {
    $connection = MailboxManager::connection();

    expect($connection)->toBeInstanceOf(FormRequest::class);
});

it('should create a connection by name', function (): void {
    $connection = MailboxManager::connection('main');

    expect($connection)->toBeInstanceOf(FormRequest::class);
});
