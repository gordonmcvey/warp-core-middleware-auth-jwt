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

namespace gordonmcvey\WarpCore\middleware\auth\jwt\test\unit\token;

use gordonmcvey\WarpCore\middleware\auth\jwt\token\Header;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testJsonSerialize()
    {
        $header = new Header("Algo goes here", "Type goes here");
        $this->assertEqualsCanonicalizing(
            [
                "alg" => "Algo goes here",
                "typ" => "Type goes here",
            ],
            $header->jsonSerialize()
        );
    }

    public function testToString()
    {
        $header = new Header("Algo goes here", "Type goes here");
        $this->assertEquals("eyJhbGciOiJBbGdvIGdvZXMgaGVyZSIsInR5cCI6IlR5cGUgZ29lcyBoZXJlIn0", $header);
    }

    public function testFromArray()
    {
        $header = Header::fromArray([
            "alg" => "Algo goes here",
            "typ" => "Type goes here",
        ]);

        $this->assertEqualsCanonicalizing(
            [
                "alg" => "Algo goes here",
                "typ" => "Type goes here",
            ],
            $header->jsonSerialize()
        );
    }

    /**
     * @throws \JsonException
     */
    public function testFromJson()
    {
        $header = Header::fromJson(json_encode([
            "alg" => "Algo goes here",
            "typ" => "Type goes here",
        ]));

        $this->assertEqualsCanonicalizing(
            [
                "alg" => "Algo goes here",
                "typ" => "Type goes here",
            ],
            $header->jsonSerialize()
        );
    }
}
