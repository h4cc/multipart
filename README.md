# h4cc/multipart
[![Build Status](https://travis-ci.org/h4cc/multipart.svg?branch=master)](https://travis-ci.org/h4cc/multipart)

A PHP library for parsing (and generating) [RFC1341 Multipart](http://www.w3.org/Protocols/rfc1341/7_2_Multipart.html).

Finally a Multipart parser library for PHP!

## Usage

```php
$content = '--------------------------eb2d2b296b73a011' . "\r\n"
    . 'Content-Disposition: form-data; name="foo"' . "\r\n"
    . 'Content-Type: text/plain' . "\r\n\r\n"
    . 'bar' . "\r\n"
    . 'buz' . "\r\n"
    . '--------------------------eb2d2b296b73a011--' . "\r\n";
$contentType = 'multipart/form-data; boundary=a3d8fcba372c456a';

$parserSelector = new ParserSelector();
$parser = $parserSelector->getParserForContentType($contentType);
$multipart = $parser->parse($content);

var_dump($multipart);
```

## Current Status

I needed a multipart parser, so a wrote one.
If anybody would like to write a Generator, do so :)
