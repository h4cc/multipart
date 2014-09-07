<?php

/*
 * This file is part of the h4cc/multipart package.
 *
 * (c) Julius Beckmann <github@h4cc.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace h4cc\Multipart\Tests;

use h4cc\Multipart\ParserSelector;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new ParserSelector();
    }

    /**
     * @dataProvider getParserDispatchData
     */
    public function testDispatchByContentType($contentType, $boundary, $parserClass)
    {
        $parser = $this->parser->getParserForContentType($contentType);

        $this->assertInstanceOf($parserClass, $parser);
        $this->assertEquals($boundary, $parser->getBoundary());
    }

    public function getParserDispatchData()
    {
        return [
            [
                'multipart/form-data; boundary=------------------------a3d8fcba372c456a',
                '------------------------a3d8fcba372c456a',
                '\h4cc\Multipart\Parser\MultipartParser'
            ],
            [
                'multipart/mixed; boundary=foobar',
                'foobar',
                '\h4cc\Multipart\Parser\MultipartParser'
            ],
        ];
    }

}
 