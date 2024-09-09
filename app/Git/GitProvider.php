<?php

namespace App\Git;

use App\Git\Providers\GithubProvider;

enum GitProvider: int
{
    case Github = 1;

    public function construct(): GitProviderContract
    {
        /** @var class-string<GitProviderContract> */
        $className = match ($this) {
            self::Github => GithubProvider::class,
        };

        return app($className);
    }
}
