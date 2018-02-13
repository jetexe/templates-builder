<?php

namespace Tarampampam\TemplatesBuilder\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends TestCase
{
    /**
     * Проверяет, что элемент является массивом.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsArray($value): void
    {
        $this->assertTrue(is_array($value), 'Must be an array');
    }

    /**
     * Проверяет, что элемент является не пустой строкой.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsNotEmptyString($value): void
    {
        $this->assertIsString($value);
        $this->assertNotEmpty($value);
    }

    /**
     * Проверяет, что элемент является строкой.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsString($value): void
    {
        $this->assertTrue(is_string($value), 'Must be string');
    }
}
