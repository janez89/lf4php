<?php
/*
 * Copyright (c) 2012 Szurovecz János
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace lf4php;

use PHPUnit_Framework_TestCase;

/**
 * @author Szurovecz János <szjani@szjani.hu>
 */
class LoggerFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testFindKnownBindingsMissing()
    {
        $factory = LoggerFactory::getILoggerFactory();
        self::assertInstanceOf('\lf4php\nop\NOPLoggerFactory', $factory);
    }

    public function testFindKnownBindings()
    {
        LoggerFactory::$KNOWN_BINDINGS[] = 'lf4php\nop\NOPLoggerFactory';
        $logger = LoggerFactory::getLogger('test');
        self::assertInstanceOf('lf4php\nop\NOPLogger', $logger);
    }

    public function testSetILoggerFactory()
    {
        $factory = $this->getMock('\lf4php\ILoggerFactory');
        LoggerFactory::setILoggerFactory($factory);
        self::assertSame($factory, LoggerFactory::getILoggerFactory());
        LoggerFactory::setILoggerFactory(null);
    }
}
