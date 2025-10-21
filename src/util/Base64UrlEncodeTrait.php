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

namespace gordonmcvey\WarpCore\middleware\auth\jwt\util;

/**
 * URL-safe Base64 encoder
 *
 * The standard base 64 encoding algorithm can introduce characters that aren't URL-safe, so this trait adds a wrapper
 * to substitute those characters with safe ones (or remove them in the case of the '=' symbol)
 */
trait Base64UrlEncodeTrait
{
    private function base64UrlEncode(string $raw): string
    {
        return str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($raw));
    }
}
