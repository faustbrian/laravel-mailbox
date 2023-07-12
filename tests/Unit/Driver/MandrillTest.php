<?php

declare(strict_types=1);

namespace Tests\Unit\Driver;

use BombenProdukt\Mailbox\Data\Mail;
use BombenProdukt\Mailbox\Driver\Mandrill;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should parse the payload', function (): void {
    $mail = createRequest(
        Mandrill::class,
        [['raw_msg' => fixtureText('mandrill')]],
    )->toMail();

    expect($mail)->toBeInstanceOf(Mail::class);

    assertMatchesSnapshot($mail);
});
