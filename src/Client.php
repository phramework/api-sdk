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

use Phramework\JSONAPI\Client\Directive\Directive;
use Phramework\JSONAPI\Client\Exceptions\ResponseException;
use Phramework\JSONAPI\Client\Response\Collection;
use Phramework\JSONAPI\Client\Response\Errors;
use Phramework\JSONAPI\Client\Response\JSONAPIResource;

/**
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @version 2.0.0
 * @since 0.0.0
 * @todo handle errors
 * @todo add post batch
 */
abstract class Client
{
    const METHOD_GET    = 'GET';
    const METHOD_HEAD   = 'HEAD';
    const METHOD_POST   = 'POST';
    const METHOD_PATCH  = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PUT    = 'PUT';

    /**
     * @var AbstractEndpoint
     */
    protected static $endpoint;

    /**
     * @see Model::defineModel Will be invoked if $model is not defined
     * @return AbstractEndpoint
     */
    public static function getEndpoint() : AbstractEndpoint
    {
        if (static::$endpoint === null) {
            static::$endpoint = static::define();
        }

        return static::$endpoint;
    }

    /**
     * MUST be implemented
     * This method is used to define the endpoint
     */
    abstract protected static function define() : AbstractEndpoint;

    /**
     * Alias of ResourceModel's getById, used as shortcut
     * @param Directive[] ...$directives
     * @return Collection
     * @throws ResponseException
     */
    public static function get(Directive ...$directives) : Collection
    {
        return static::getEndpoint()->get(...func_get_args());
    }

    /**
     * Alias of ResourceModel's getById, used as shortcut
     * @param string       $id
     * @param Directive[] ...$directives
     * @return JSONAPIResource
     * @throws ResponseException
     */
    public static function getById(
        string $id,
        Directive ...$directives
    ) {
        return static::getEndpoint()->getById($id, ...$directives);
    }

    public static function post(
        \stdClass $attributes = null,
        RelationshipsData  $relationships = null,
        Directive ...$directives
    ) {
        return static::getEndpoint()->post(...func_get_args());
    }

    /**
     * @param string       $id
     * @param Directive[] ...$directives
     * @throws ResponseException
     */
    public static function patch(
        string $id,
        \stdClass $attributes = null,
        RelationshipsData  $relationships = null,
        Directive ...$directives
    ) {
        return static::getEndpoint()->patch(...func_get_args());
    }

    /**
     * @param string       $id
     * @param Directive[] ...$directives
     * @throws ResponseException
     */
    public static function delete(
        string $id,
        \stdClass $attributes = null,
        RelationshipsData  $relationships = null,
        Directive ...$directives
    ) {
        return static::getEndpoint()->delete(...func_get_args());
    }
}
