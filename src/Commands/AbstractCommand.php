<?php

namespace Tarampampam\TemplatesBuilder\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Filesystem\Filesystem;
use Tarampampam\TemplatesBuilder\Builder;

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
     * Returns command name.
     *
     * @return string
     */
    abstract protected function getCommandName();

    /**
     * Returns command description.
     *
     * @return string
     */
    abstract protected function getCommandDescription();

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName($this->getCommandName())
            ->setDescription($this->getCommandDescription());
    }

    /**
     * {@inheritdoc}
     *
     * @return Builder
     */
    public function getApplication()
    {
        return parent::getApplication();
    }
}
