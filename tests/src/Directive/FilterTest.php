<?php

namespace Phramework\JSONAPI\Client\Directive;

use PHPUnit\Framework\TestCase;
use Phramework\JSONAPI\Client\Directive\Filter\FilterJSONAttribute;
use Phramework\JSONAPI\Client\Directive\Filter\FilterAttribute;
use Phramework\Operator\Operator;

/**
 * @since 2.2.2
 * @author Xenofon Spafaridis <nohponex@gmail.com>
 * @coversDefaultClass \Phramework\JSONAPI\Client\Directive\Filter
 */
class FilterTest extends TestCase
{
    public function provider() : array
    {
        return [
            [
                new Filter(
                    'user',
                    ['1', '2']
                ),
                'filter[user]=1,2'
            ],
            [
                new Filter(
                    'article',
                    ['1', '2'],
                    (object) [
                        'author' => ['1']
                    ]
                ),
                'filter[article]=1,2&filter[author]=1'
            ],
            [
                new Filter(
                    '',
                    [],
                    (object) [
                        'author' => ['1', '2']
                    ],
                    [
                        new FilterAttribute(
                            'created',
                            Operator::GREATER_EQUAL,
                            100
                        ),
                        new FilterAttribute(
                            'created',
                            Operator::LESS,
                            100000
                        )
                    ]
                ),
                sprintf(
                    'filter[author]=1,2&filter[created][]=%s100&filter[created][]=%s100000',
                    urlencode('>='),
                    urlencode('<')
                )
            ],
            [
                new Filter(
                    '',
                    [],
                    (object) [
                        'author' => ['1', '2']
                    ],
                    [
                        new FilterJSONAttribute(
                            'meta',
                            'created',
                            Operator::GREATER_EQUAL,
                            100
                        )
                    ]
                ),
                sprintf(
                    'filter[author]=1,2&filter[meta.created][]=%s100',
                    urlencode('>=')
                )
            ]
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testGetUrl(Filter $filter, string $expected)
    {
        $this->assertSame(
            $filter->getURL(),
            $expected
        );
    }
}
