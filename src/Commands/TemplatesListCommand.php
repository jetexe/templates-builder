<?php

namespace Tarampampam\TemplatesBuilder\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TemplatesListCommand.
 *
 * Show available command list command.
 */
class TemplatesListCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function getCommandName()
    {
        return 'templates';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandDescription()
    {
        return 'List all available templates';
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $templates = $this->getApplication()
            ->templates()
            ->all();

        if (! empty($templates)) {
            $output->writeln('<info>Available templates:</info>');

            foreach ($templates as $template) {
                $output->writeln(sprintf(
                    '  %s - <comment>%s</comment>',
                    $template->getName(),
                    $template->getDescription()
                ));
            }
        } else {
            $output->writeln('<error>No one template were found</error>');
        }
    }
}
