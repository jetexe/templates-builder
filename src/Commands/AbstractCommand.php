<?php

namespace Tarampampam\TemplatesBuilder\Commands;

use Tarampampam\TemplatesBuilder\Builder;
use Symfony\Component\Console\Application;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;

/**
 * Class AbstractCommand.
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var SymfonyQuestionHelper
     */
    protected $question_helper;

    /**
     * {@inheritdoc}
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->filesystem      = new Filesystem;
        $this->question_helper = new SymfonyQuestionHelper;
    }

    /**
     * {@inheritdoc}
     *
     * @return Builder|Application
     */
    public function getApplication()
    {
        return parent::getApplication();
    }

    /**
     * Returns command name.
     *
     * @return string
     */
    abstract protected function getCommandName(): string;

    /**
     * Returns command description.
     *
     * @return string
     */
    abstract protected function getCommandDescription(): string;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription());
    }
}
