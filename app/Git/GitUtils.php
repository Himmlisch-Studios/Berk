<?php

namespace App\Git;

final readonly class GitUtils
{
    /**
     * Outputs a correct .env key
     * Ex. `Himmlisch-Studios` -> `HIMMLISCH_STUDIOS`
     */
    public static function formatEnvKey(string $str): string
    {
        return str($str)->lower()->replace('-', '_')->snake()->upper()->toString();
    }
}
