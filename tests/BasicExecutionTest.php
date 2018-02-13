<?php

namespace Tarampampam\TemplatesBuilder\Tests;

use Tarampampam\TemplatesBuilder\Builder;

/**
 * Class BasicExecutionTest.
 */
class BasicExecutionTest extends AbstractTestCase
{
    /**
     * @var Builder
     */
    protected $application;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->application = new Builder;
        $this->application->bootstrap();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->application);

        parent::tearDown();
    }

    /**
     * Test application constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertEquals('Templates builder', $this->application->getName());
        $this->assertEquals('1.0.0', $this->application->getVersion());

        foreach (['templates', 'build'] as $commands_names) {
            $this->assertArrayHasKey($commands_names, $this->application->all());
        }
    }
}
