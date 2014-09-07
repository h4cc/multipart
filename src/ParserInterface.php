<?php

/*
 * This file is part of the h4cc/multipart package.
 *
 * (c) Julius Beckmann <github@h4cc.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace h4cc\Multipart;

interface ParserInterface
{
    /** Newline as told by RFC 1341 */
    const EOL = "\r\n";

    /**
     * @param $boundary string Delimiter between multipart bodies.
     * @return void
     */
    public function setBoundary($boundary);

    /**
     * Parses the multipart content to a array structure.
     *
     * @param $content
     * @return array
     */
    public function parse($content);
} 