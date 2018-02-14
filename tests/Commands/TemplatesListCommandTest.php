<?php

namespace Tarampampam\TemplatesBuilder\Tests\Commands;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Tarampampam\TemplatesBuilder\Templates\Template;

/**
 * Class TemplatesListCommandTest.
 */
class TemplatesListCommandTest extends AbstractCommandTestCase
{
    public function testCommandExecution()
    {
        $this->app->setAutoExit(false);
        $this->app->run($input = new StringInput($this->getCommandName()), $output = new StreamOutput($fp = tmpfile()));

        $output = $this->streamIntoString($fp);

        $names = array_map(function (Template $template) {
            return $template->getName();
        }, $this->app->templates()->all());

        $this->assertNotEmpty($names);

        foreach ($names as $name) {
            $this->assertContains($name, $output);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandName()
    {
        return 'templates';
    }
}
