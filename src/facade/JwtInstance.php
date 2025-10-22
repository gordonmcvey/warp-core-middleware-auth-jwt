<?php

/**
 * Copyright © 2025 Gordon McVey
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace gordonmcvey\WarpCore\middleware\auth\jwt\facade;

use DomainException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use InvalidArgumentException;
use SensitiveParameter;
use stdClass;
use UnexpectedValueException;

/**
 * @todo Determine if we need all the public methods, remove any unneeded ones
 */
class JwtInstance
{
    /**
     * @throws InvalidArgumentException
     * @throws DomainException
     * @throws UnexpectedValueException
     * @throws SignatureInvalidException
     * @throws BeforeValidException
     * @throws BeforeValidException
     * @throws ExpiredException
     */
    public function decode(
        string                $jwt,
        #[SensitiveParameter] $keyOrKeyArray,
        ?stdClass             &$headers = null
    ): stdClass {
        return JWT::decode($jwt, $keyOrKeyArray, $headers);
    }

    public function encode(
        array                 $payload,
        #[SensitiveParameter] $key,
        string                $alg,
        ?string               $keyId = null,
        ?array                $head = null
    ): string {
        return JWT::encode($payload, $key, $alg, $keyId, $head);
    }

    public function sign(
        string                $msg,
        #[SensitiveParameter] $key,
        string                $alg
    ): string {
        return JWT::sign($msg, $key, $alg);
    }

    /**
     * @throws DomainException Provided string was invalid JSON
     */
    public function jsonDecode(string $input)
    {
        return JWT::jsonDecode($input);
    }

    /**
     * @throws DomainException Provided object could not be encoded to valid JSON
     */
    public function jsonEncode(array $input): string
    {
        return JWT::jsonEncode($input);
    }

    /**
     * @throws InvalidArgumentException invalid base64 characters
     */
    public function urlsafeB64Decode(string $input): string
    {
        return JWT::urlsafeB64Decode($input);
    }

    public function convertBase64UrlToBase64(string $input): string
    {
        return JWT::urlsafeB64Decode($input);
    }

    public function urlsafeB64Encode(string $input): string
    {
        return JWT::urlsafeB64Encode($input);
    }

    public static function constantTimeEquals(string $left, string $right): bool
    {
        return JWT::constantTimeEquals($left, $right);
    }
}
