<?php

namespace Tarampampam\TemplatesBuilder\Tests\Mocks;

use Tarampampam\TemplatesBuilder\Builder;

/**
 * Class BuilderMock.
 */
class BuilderMock extends Builder
{
    /**
     * Get base application path.
     *
     * @return bool|string
     */
    public static function getBasePath()
    {
        return realpath(__DIR__ . '/../stubs/sets/valid-set');
    }

    /**
     * Get own templates directories path.
     *
     * @return string
     */
    public static function getOwnTemplatesPath()
    {
        return static::getBasePath();
    }
}
