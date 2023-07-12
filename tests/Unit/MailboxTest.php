<?php

declare(strict_types=1);

namespace Tests\Unit;

use BombenProdukt\Mailbox\Mailbox;

it('can add a filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->filter('connection', 'field', 'pattern', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['field' => ['pattern' => 'classOrAction']]]);

it('can add a filter and get all filters by field')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->filter('connection', 'field', 'pattern', 'classOrAction');

        return $mailbox->allFiltersByField('connection', 'field');
    })
    ->toBe(['pattern' => 'classOrAction']);

it('can add a "from" filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->from('connection', 'pattern', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['from' => ['pattern' => 'classOrAction']]]);

it('can add a "to" filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->to('connection', 'pattern', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['to' => ['pattern' => 'classOrAction']]]);

it('can add a "cc" filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->cc('connection', 'pattern', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['cc' => ['pattern' => 'classOrAction']]]);

it('can add a "bcc" filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->bcc('connection', 'pattern', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['bcc' => ['pattern' => 'classOrAction']]]);

it('can add a "subject" filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->subject('connection', 'pattern', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['subject' => ['pattern' => 'classOrAction']]]);

it('can add a fallback filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->fallback('connection', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['fallback' => ['*' => 'classOrAction']]]);

it('can add a catch-all filter')
    ->expect(function () {
        $mailbox = new Mailbox();
        $mailbox->catchAll('connection', 'classOrAction');

        return $mailbox->allFilters();
    })
    ->toBe(['connection' => ['catchAll' => ['*' => 'classOrAction']]]);
