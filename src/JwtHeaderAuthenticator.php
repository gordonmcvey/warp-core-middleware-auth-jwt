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

namespace gordonmcvey\WarpCore\middleware\auth\jwt;

use Firebase\JWT\Key;
use gordonmcvey\httpsupport\enum\statuscodes\ClientErrorCodes;
use gordonmcvey\httpsupport\enum\statuscodes\ServerErrorCodes;
use gordonmcvey\httpsupport\interface\request\RequestInterface;
use gordonmcvey\httpsupport\interface\response\ResponseInterface;
use gordonmcvey\httpsupport\response\Response;
use gordonmcvey\WarpCore\middleware\auth\jwt\facade\JwtInstance;
use gordonmcvey\WarpCore\sdk\interface\controller\RequestHandlerInterface;
use gordonmcvey\WarpCore\sdk\interface\middleware\MiddlewareInterface;
use LogicException;
use TypeError;
use UnexpectedValueException;

class JwtHeaderAuthenticator implements MiddlewareInterface
{
    public const string AUTH_HEADER = 'Authorization';

    public function __construct(private JwtInstance $jwtInstance, private Key $key)
    {
    }

    public function handle(RequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $token = $request->header(self::AUTH_HEADER);
            $decoded = $this->jwtInstance->decode($token, $this->key);
            // @todo Determine the identity of the token bearer
        } catch (LogicException|TypeError $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            return new Response(
                responseCode: ServerErrorCodes::INTERNAL_SERVER_ERROR,
                body: json_encode([
                    "error"   => "Unknown authorisation error",
                    "class"   => $e::class,
                    "message" => $e->getMessage(),
                ]),
                contentType: "application/json"
            );
        } catch (UnexpectedValueException $e) {
            // errors having to do with JWT signature and claims
            return new Response(
                responseCode: ClientErrorCodes::UNAUTHORIZED,
                body: json_encode([
                    "error"   => "Token signature verification failed",
                    "class"   => $e::class,
                    "message" => $e->getMessage(),
                ]),
                contentType: "application/json"
            );
        }

        return $handler->dispatch($request);
    }
}
