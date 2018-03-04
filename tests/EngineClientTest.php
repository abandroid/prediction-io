<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Guide\Tests;

use Endroid\PredictionIo\EngineClient;
use GuzzleHttp\Exception\ConnectException;
use PHPUnit\Framework\TestCase;

class EngineClientTest extends TestCase
{
    public function testConnectException()
    {
        $engineClient = new EngineClient('http://localhost:8000');

        $this->expectException(ConnectException::class);
        $engineClient->getRecommendedItems('user_1', 3);
    }
}
