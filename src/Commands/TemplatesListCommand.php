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
    protected function getCommandName(): string
    {
        return 'templates';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandDescription(): string
    {
        return 'List all available templates';
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \LogicException
     *
     * @return int|void|null
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
                    '  <info>%s</info> - <comment>%s</comment>',
                    $template->getName(),
                    empty($description = $template->getDescription())
                        ? 'Template description not found'
                        : $description
                ));

                $output->writeln(sprintf(
                    '    Location: <comment>%s</comment>',
                    $template->getTemplatePath()
                ), OutputInterface::VERBOSITY_VERBOSE);
            }
        } else {
            $output->writeln('<error>No one template were found</error>');
        }
    }
}
