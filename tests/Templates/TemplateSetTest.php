<?php

namespace Tarampampam\TemplatesBuilder\Tests\Templates;

use Tarampampam\TemplatesBuilder\Templates\Template;
use Tarampampam\TemplatesBuilder\Templates\TemplatesSet;
use Tarampampam\TemplatesBuilder\Tests\AbstractTestCase;

/**
 * Class TemplateSetTest.
 */
class TemplateSetTest extends AbstractTestCase
{
    /**
     * @var TemplatesSet
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->instance = $this->instanceFactory($this->getValidTemplatesSetsPath());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->instance);

        parent::tearDown();
    }

    /**
     * Test 'all()' method.
     *
     * @return void
     */
    public function testAllMethod()
    {
        $this->assertNotEmpty($all = $this->instance->all());

        foreach ($all = $this->instance->all() as $template) {
            $this->assertInstanceOf(Template::class, $template);
        }
    }

    /**
     * TemplatesSet instance factory.
     *
     * @param array ...$arguments
     *
     * @return TemplatesSet
     */
    protected function instanceFactory(...$arguments): TemplatesSet
    {
        return new TemplatesSet(...$arguments);
    }

    /**
     * Get valid templates set directory path.
     *
     * @return string
     */
    protected function getValidTemplatesSetsPath()
    {
        return __DIR__ . '/../stubs/sets/valid-set';
    }

    /**
     * Get invalid templates set directory path.
     *
     * @return string
     */
    protected function getInvalidTemplatesSetsPath()
    {
        return __DIR__ . '/../stubs/sets/invalid-set';
    }
}
