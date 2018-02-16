<?php

namespace {%root_namespace%}\{%package_namespace%}\Tests;

use PHPUnit\Framework\AssertionFailedError;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends BaseTestCase
{
    use CreatesApplicationTrait;

    /**
     * Проверяет, что элемент является массивом.
     *
     * @param $value
     *
     * @throws AssertionFailedError
     */
    public function assertIsArray($value)
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
    public function assertIsNotEmptyString($value)
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
    public function assertIsString($value)
    {
        $this->assertTrue(is_string($value), 'Must be string');
    }
}
