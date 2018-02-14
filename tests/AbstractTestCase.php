<?php

namespace Tarampampam\TemplatesBuilder\Tests;

use PHPUnit\Framework\TestCase;
use Tarampampam\TemplatesBuilder\Tests\Mocks\BuilderMock;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Application instance factory.
     *
     * @param array ...$arguments
     *
     * @return BuilderMock
     */
    protected function applicationFactory(...$arguments): BuilderMock
    {
        $instance = new BuilderMock(...$arguments);
        $instance->bootstrap();

        return $instance;
    }
}
