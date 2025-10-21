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

namespace gordonmcvey\WarpCore\middleware\auth\jwt\token;

use gordonmcvey\WarpCore\middleware\auth\jwt\util\Base64UrlEncodeTrait;
use JsonException;
use JsonSerializable;
use Stringable;

final readonly class Header implements JsonSerializable, Stringable
{
    use Base64UrlEncodeTrait;

    public const string KEY_ALGORITHM = 'alg';
    public const string KEY_TYPE = 'typ';
    public const string DEFAULT_TYPE = "JWT";

    public function __construct(public string $algorithm, public string $type = self::DEFAULT_TYPE)
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            self::KEY_ALGORITHM => $this->algorithm,
            self::KEY_TYPE      => $this->type,
        ];
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return $this->base64UrlEncode(json_encode($this->jsonSerialize(), JSON_THROW_ON_ERROR));
    }

    /**
     * @param array<string, string> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self($data[self::KEY_ALGORITHM], $data[self::KEY_TYPE]);
    }

    /**
     * @throws JsonException
     */
    public static function fromJson(string $json): self
    {
        return self::fromArray(json_decode(json: $json, associative: true, flags: JSON_THROW_ON_ERROR));
    }
}
