<?php

/*
 * This file is part of the h4cc/multipart package.
 *
 * (c) Julius Beckmann <github@h4cc.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace h4cc\Multipart\Tests\Parser;

use h4cc\Multipart\Parser\MultipartParser;

class MultipartParserTest extends \PHPUnit_Framework_TestCase
{
    /** @var  MultipartParser */
    private $parser;

    public function setUp()
    {
        $this->parser = new MultipartParser();
    }

    public function testParseSingle()
    {
        $content = '--------------------------eb2d2b296b73a011' . "\r\n"
            . 'Content-Disposition: form-data; name="foo"' . "\r\n"
            . 'Content-Type: text/plain' . "\r\n\r\n"
            . 'bar' . "\r\n"
            . 'buz' . "\r\n"
            . '--------------------------eb2d2b296b73a011--' . "\r\n";

        $this->parser->setBoundary('------------------------eb2d2b296b73a011');
        $result = $this->parser->parse($content);

        $this->assertEquals(
            [
                ['headers' => [
                    'content-disposition' => ['form-data; name="foo"'],
                    'content-type' => ['text/plain'],
                ], 'body' => 'bar' . "\r\n" . 'buz'],
            ],
            $result
        );
    }

    public function testParseNoHeader()
    {
        $content = '--------------------------eb2d2b296b73a011' . "\r\n"
            . "\r\n"
            . 'bar' . "\r\n"
            . '--------------------------eb2d2b296b73a011--' . "\r\n";

        $this->parser->setBoundary('------------------------eb2d2b296b73a011');
        $result = $this->parser->parse($content);

        $this->assertEquals(
            [
                ['headers' => ['content-type' => ['text/plain'],], 'body' => 'bar'],
            ],
            $result
        );
    }

    public function testParseMultiple()
    {
        $content = '--------------------------eb2d2b296b73a011' . "\r\n"
            . 'Content-Disposition: form-data; name="foo"' . "\r\n\r\n"
            . 'bar' . "\r\n"
            . '--------------------------eb2d2b296b73a011' . "\r\n"
            . 'Content-Disposition: form-data; name="alice"' . "\r\n\r\n"
            . 'bob' . "\r\n"
            . '--------------------------eb2d2b296b73a011--' . "\r\n";

        $this->parser->setBoundary('------------------------eb2d2b296b73a011');
        $result = $this->parser->parse($content);

        $this->assertEquals(
            [
                ['headers' => [
                    'content-disposition' => ['form-data; name="foo"'],
                    'content-type' => ['text/plain'],
                ], 'body' => 'bar'],
                ['headers' => [
                    'content-disposition' => ['form-data; name="alice"'],
                    'content-type' => ['text/plain'],
                ], 'body' => 'bob'],
            ],
            $result
        );
    }
}
 