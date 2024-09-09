<?php

// * Original code from Sylvain Mauduit <sylvain@mauduit.fr>

namespace App\Git\Validators;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GithubValidator
{
    public function validate(Request $request, string $secret): void
    {
        $signature = $this->getSignatureFromHeader($request);

        $payload = $request->getContent();

        throw_unless(
            $this->validateSignature($signature, $payload, $secret),
            ValidationException::withMessages(["Invalid github request signature"])
        );
    }

    private function getSignatureFromHeader(Request $request): ?string
    {
        return $request->header('X-Hub-Signature-256');
    }

    private function validateSignature(?string $signature, string $payload, string $secret): bool
    {
        if (null === $signature) {
            return false;
        }

        $explodeResult = explode('=', $signature, 2);

        if (2 !== count($explodeResult)) {
            return false;
        }

        list($algorithm, $hash) = $explodeResult;

        if (empty($algorithm) || empty($hash)) {
            return false;
        }

        if (!in_array($algorithm, hash_algos())) {
            return false;
        }

        $payloadHash = hash_hmac($algorithm, $payload, $secret);

        return $hash === $payloadHash;
    }
}
