<?php

namespace Tarampampam\TemplatesBuilder\Tests\Templates;

use Tarampampam\TemplatesBuilder\Templates\Template;
use Tarampampam\TemplatesBuilder\Tests\AbstractTestCase;

/**
 * Class TemplateTest.
 */
class TemplateTest extends AbstractTestCase
{
    /**
     * @var Template
     */
    protected $instance;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->instance = $this->instanceFactory($this->getStubTemplatePath());
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
     * Constructor and some another methods tests.
     *
     * @return void
     */
    public function testConstructor()
    {
        $this->assertEquals('stub-template', $this->instance->getName());
        $this->assertEquals($this->getStubTemplatePath(), $this->instance->getTemplatePath());

        // Test template path trimming
        $this->assertEquals(
            $this->getStubTemplatePath(),
            $this->instanceFactory($this->getStubTemplatePath() . '///')->getTemplatePath()
        );

        $this->assertEquals('foobar', $this->instanceFactory($this->getStubTemplatePath(), 'foobar'));
    }

    /**
     * Test constructor exception with invalid template directory path.
     *
     * @return void
     */
    public function testConstructorFailedWithInvalidTemplatePath()
    {
        $this->expectExceptionMessageRegExp('~path is not valid~i');

        $this->instanceFactory('/foo/bar/path' . random_int(0, 999));
    }

    /**
     * Test constructor exception with path to template without metafile.
     *
     * @return void
     */
    public function testConstructorExceptionWithInvalidTemplateMetafile()
    {
        $this->expectExceptionMessageRegExp('~Metadata file.*not exists or unreadable~i');

        $this->instanceFactory($this->getInvalidStubTemplatePath());
    }

    /**
     * Test object to string convertation.
     *
     * @return void
     */
    public function testToStringConvertation()
    {
        $this->assertEquals('stub-template', $this->instance->__toString());
        $this->assertEquals('foobar', (string) $this->instanceFactory($this->getStubTemplatePath(), 'foobar'));
    }

    /**
     * Test 'getMetadata' method.
     *
     * @return void
     */
    public function testGetMetadata()
    {
        $expects = [
            'description' => $description = 'Example template',
            'sources-dir' => 'sources',
            'replaces'    => $replaces = [
                $first = [
                    'signature'   => '{%custom_value_1%}',
                    'description' => 'Custom value 1 description',
                    'default'     => 'Default value 1',
                ],
                $second = [
                    'signature'   => '{%custom_value_2%}',
                    'description' => 'Custom value 2 description',
                    'default'     => 'Default value 2',
                ],
            ],
        ];

        $this->assertEquals($expects, $this->instance->getMetadata());

        $this->assertEquals($description, $this->instance->getMetadata('description'));
        $this->assertEquals($description, $this->instance->getDescription());

        $this->assertEquals('sources', $this->instance->getMetadata('sources-dir'));

        $this->assertEquals($replaces, $this->instance->getReplaces());

        $this->assertEquals($first, $this->instance->getMetadata('replaces')[0]);
        $this->assertEquals($second, $this->instance->getMetadata('replaces')[1]);
    }

    /**
     * Test methods-getters for paths.
     *
     * @return void
     */
    public function testPathsGetters()
    {
        $this->assertEquals($this->getStubTemplatePath(), $this->instance->getTemplatePath());
        $this->assertEquals($this->getStubTemplatePath() . '/sources', $this->instance->getTemplateSourcesPath());
    }

    /**
     * Template instance factory.
     *
     * @param array ...$arguments
     *
     * @return Template
     */
    protected function instanceFactory(...$arguments): Template
    {
        return new Template(...$arguments);
    }

    /**
     * Get stub template directory path.
     *
     * @return string
     */
    protected function getStubTemplatePath()
    {
        return __DIR__ . '/../stubs/templates/stub-template';
    }

    /**
     * Get invalid stub template directory path.
     *
     * @return string
     */
    protected function getInvalidStubTemplatePath()
    {
        return __DIR__ . '/../stubs/templates/invalid-stub-template';
    }
}
