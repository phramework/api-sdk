<?php
declare(strict_types=1);
/*
 * Copyright 2016-2017 Xenofon Spafaridis
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Phramework\JSONAPI\Client;

use PHPUnit\Framework\TestCase;
use Phramework\JSONAPI\APP\BaseEndpoint;
use Phramework\JSONAPI\Client\Exceptions\ResponseException;
use Phramework\JSONAPI\Client\Exceptions\TimeoutException;

/**
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @todo use phramework/jsonapi to server an actual API
 */
class GetTest extends TestCase
{
    use BaseEndpoint;

    protected $resourceType;

    /**
     * @var Endpoint
     */
    protected $endpoint;

    public function setUp(): void
    {
        $this->resourceType = 'article';

        $this->endpoint = (new Endpoint($this->resourceType))
            ->setUrl('http://localhost:8005/' . $this->resourceType);
    }

    public function testGet(): void
    {
        $this->get();
    }

    public function testGetNotFoundServer(): void
    {
        $endpoint = (new Endpoint('not-found'))
            ->setUrl('http://404-not-found-server.com/resource');

        $this->expectException(\Exception::class);

        $collection = $endpoint->get();

        $this->markTestIncomplete();
    }

    public function testGetNotFoundResource(): void
    {
        $id = (string) 2**31; //Very large resource id, probably is going to missing

        $this->expectException(\Exception::class);

        $resource = $this->endpoint->getById($id);

        $this->markTestIncomplete();
    }

    public function testGetNotFoundResourceDetails(): void
    {
        $id = (string) 2**31; //Very large resource id, probably is going to missing

        try {
            $resource = $this->endpoint->getById($id);
        } catch (ResponseException $e) {
            $this->assertSame(
                'Resource not found',
                $e->getErrors()[0]->title
            );

            $this->assertSame(
                '404',
                $e->getErrors()[0]->status
            );
        }
    }
}
