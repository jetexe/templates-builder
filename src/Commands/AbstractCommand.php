<?php

namespace Tarampampam\TemplatesBuilder\Commands;

use Symfony\Component\Console\Command\Command;
use Tarampampam\TemplatesBuilder\Builder;

/**
 * Class AbstractCommand.
 */
abstract class AbstractCommand extends Command
{
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
