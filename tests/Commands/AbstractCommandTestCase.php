<?php

namespace Tarampampam\TemplatesBuilder\Tests\Commands;

use Tarampampam\TemplatesBuilder\Builder;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Tarampampam\TemplatesBuilder\Tests\AbstractTestCase;

/**
 * Class AbstractCommandTestCase.
 */
abstract class AbstractCommandTestCase extends AbstractTestCase
{
    /**
     * @var Builder
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->app = $this->applicationFactory();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->app);

        parent::tearDown();
    }

    /**
     * Test command execution with '--help' option.
     *
     * @return void
     */
    public function testSimpleCommandExecution()
    {
        $output = $this->executeCommandAndGetOutput(sprintf('%s --help', $command = $this->getCommandName()));

        $this->assertContains($output, $output);
        $this->assertContains('Help:', $output);
    }

    /**
     * Return tested command name (signature).
     *
     * @return string
     */
    abstract protected function getCommandName();

    /**
     * @param resource $stream
     *
     * @return string
     */
    protected function streamIntoString($stream): string
    {
        fseek($stream, 0);
        $output = '';
        while (! feof($stream)) {
            $output = fread($stream, 4096);
        }
        fclose($stream);

        return $output;
    }

    /**
     * Execute some command and get output as a string.
     *
     * @param string $command_signature
     *
     * @return string
     */
    protected function executeCommandAndGetOutput($command_signature): string
    {
        $app = $this->applicationFactory();
        $app->setAutoExit(false);

        $app->run($input = new StringInput($command_signature), $output = new StreamOutput($fp = tmpfile()));

        return $this->streamIntoString($fp);
    }
}
