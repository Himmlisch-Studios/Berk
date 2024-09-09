<?php

namespace App\Git;

use Illuminate\Contracts\Support\Arrayable;

final readonly class GitUrlParts implements Arrayable
{
    public function __construct(
        public string $domain,
        public string $org,
        public string $repo,
        public bool $ssh = false,
    ) {}

    public function toArray()
    {
        return [
            'domain' => $this->domain,
            'org' => $this->org,
            'repo' => $this->repo,
            'ssh' => $this->ssh,
        ];
    }
}
