<?php

namespace Tarampampam\TemplatesBuilder\Tests\Commands;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class BuildCommandTest.
 */
class BuildCommandTest extends AbstractCommandTestCase
{
    public function testCommandExecution()
    {
        $filesystem = new Filesystem;
        $dir_path   = __DIR__ . '/../temp';

        if (is_dir($dir_path)) {
            $filesystem->remove($dir_path);
        }

        $this->app->setAutoExit(false);
        $this->app->run($input = new StringInput(
            sprintf('%s %s %s', $this->getCommandName(), $dir_path, 'empty-template')
        ), $output = new StreamOutput($fp = tmpfile()));

        $output = $this->streamIntoString($fp);
        $this->assertFileExists($readme_file = $dir_path . '/README.md');
        $this->assertContains('Example:', $readme_content = file_get_contents($readme_file));
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandName()
    {
        return 'build';
    }
}
