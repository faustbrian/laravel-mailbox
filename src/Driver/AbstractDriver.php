<?php

declare(strict_types=1);

namespace BombenProdukt\Mailbox\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

abstract class AbstractDriver extends FormRequest implements DriverInterface
{
    public function authorize(): bool
    {
        $configuration = Config::get('mailbox.connections.'.$this->route('connection'));

        if (isset($configuration['basic_auth'])) {
            return $this->authorizeWithBasicAuth($configuration['basic_auth']);
        }

        return true;
    }

    public function authorizeWithBasicAuth(array $credentials): bool
    {
        $hasValidUsername = $this->getUser() === $credentials['username'];
        $hasValidPassword = $this->getPassword() === $credentials['password'];

        return $hasValidUsername && $hasValidPassword;
    }
}
