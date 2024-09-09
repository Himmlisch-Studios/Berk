<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserUnixDirectoryRule implements ValidationRule
{
    private array $fullProtectedDirs = [
        'bin/',
        'dev/',
        'etc/',
        'lib/',
        'sbin/',
        'tmp/',
        'run/',
        'boot/',
        'dev/',
        'sys/',
        'timeshift/',
        'var/log/',
        'var/lock/',
        'var/tmp/',
        'var/cache/',
        'var/lib/',
        'usr/bin/',
        'usr/lib/',
        'usr/man/',
    ];

    private array $partiallyProtectedDirs = [
        '[^/]+',
        'usr/share/',
        'usr/local/',
        'home/',
        'home(/[^/]*)?',
        'mnt(/[^/]*)?',
        'opt(/[^/]*)?',
        'root(/[^/]*)?',
        'var(/[^/]*)?',
        'usr(/[^/]*)?',
    ];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!str_starts_with($value, '/')) {
            $fail(':attribute must be a valid UNIX directory');
        }

        $value = trim($value, '/');

        collect($this->fullProtectedDirs)
            ->each(function ($dir) use ($fail, $value) {
                if (str_starts_with($value, trim($dir, '/'))) {
                    $fail(":attribute must not be a directory starting with /$dir");
                };
            });


        collect($this->partiallyProtectedDirs)
            ->each(function ($dir) use ($fail, $value) {
                $regex = '/^' . preg_replace('/[\/|\\\]+/', '\/', $dir) . '$/';
                if (preg_match($regex, $value)) {
                    $fail(":attribute must not be a protected directory");
                };
            });
    }
}
