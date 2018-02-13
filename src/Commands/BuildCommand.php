<?php

namespace Tarampampam\TemplatesBuilder\Commands;

use Exception;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Tarampampam\TemplatesBuilder\Templates\Template;

/**
 * Class BuildCommand.
 *
 * Build template, based on supported template.
 */
class BuildCommand extends AbstractCommand
{
    /**
     * Array with default replaces exclude patterns.
     */
    const DEFAULT_REPLACES_EXCLUDES = ['/.git/'];

    /**
     * {@inheritdoc}
     */
    protected function getCommandName()
    {
        return 'build';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandDescription()
    {
        return 'Build template, based on supported template';
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->addArgument('path', InputArgument::REQUIRED, 'Path to the target directory')
            ->addArgument('template', InputArgument::OPTIONAL, sprintf('Template name'));
    }

    /**
     * Get all available templates names.
     *
     * @param Template[]|null $templates
     *
     * @return string[]array
     */
    protected function getAllTemplatesNames($templates = null)
    {
        $templates = is_array($templates)
            ? $templates
            : $this->getApplication()->templates()->all();

        return array_map(function (Template $template) {
            return $template->getName();
        }, $templates);
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $passed_path          = $input->getArgument('path');
        $passed_template_name = $input->getArgument('template');
        $templates            = $this->getApplication()->templates()->all();
        $templates_names      = $this->getAllTemplatesNames($templates);

        if (empty($templates)) {
            throw new Exception('No one template were found');
        }

        // Ask user for template name
        if (empty($passed_template_name)) {
            $question             = new ChoiceQuestion('Please, select template name', $templates_names, 0);
            $passed_template_name = $this->question_helper->ask($input, $output, $question);
        }

        if (! in_array($passed_template_name, $templates_names)) {
            throw new Exception(sprintf(
                'Passed template name "%s" was not found. You can use one of: %s',
                $passed_template_name,
                implode(', ', $templates_names)
            ));
        } else {
            $output->writeln(
                sprintf('<comment>Template name: %s</comment>', $passed_template_name),
                OutputInterface::VERBOSITY_VERBOSE
            );
        }

        foreach ($templates as $template) {
            if ($template->getName() === $passed_template_name) {
                return $this->makeTemplateCopy($template, $passed_path, $input, $output)
                       && $this->makeTemplateReplaces($template, $passed_path, $input, $output);
            }
        }

        return 1;
    }

    /**
     * Makes template building in target directory.
     *
     * @param Template        $template
     * @param string          $target_path
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function makeTemplateCopy(Template $template,
                                        $target_path,
                                        InputInterface $input,
                                        OutputInterface $output)
    {
        $template_sources = $template->getTemplateSourcesPath();

        // Check template sources directory
        if (! is_dir($template_sources) || ! is_readable($template_sources)) {
            throw new Exception(sprintf('Template directory "%s" does not exists on unreadable', $template_sources));
        }

        // Make target directory (if needed)
        if (! is_dir($target_path)) {
            $this->filesystem->mkdir($target_path);

            $output->writeln(sprintf(
                '<comment>Target directory "%s" created</comment>',
                $target_path
            ));
        } else {
            $question = new ConfirmationQuestion(
                sprintf('Target directory "%s" already exists. Use it anyway?', $target_path), true
            );

            if (! $this->question_helper->ask($input, $output, $question)) {
                $output->writeln('<error>Operation cancelled</error>');

                return false;
            }
        }

        // Make template files copy
        $output->writeln(sprintf(
            "\n<info>Copy template sources</info>\n  <comment>From</comment>: %s\n  <comment>To</comment>:   %s",
            $template_sources,
            $target_path
        ));
        $this->filesystem->mirror($template_sources, $target_path, null, ['override' => true]);

        return true;
    }

    /**
     * Make template replaces with patterns, declared in metadata file.
     *
     * @param Template        $template
     * @param string          $target_path
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function makeTemplateReplaces(Template $template,
                                            $target_path,
                                            InputInterface $input,
                                            OutputInterface $output)
    {
        // Make template replaces
        if (! empty($template_replaces = $template->getReplaces())) {
            $output->writeln("\nThis template supports and requires next patterns replaces:");

            // Array with replaces rules
            $replaces = [
                'what' => [],
                'with' => [],
            ];

            // Ask user for replace patterns values
            foreach ($template_replaces as $replace) {
                if (! isset($replace['signature'])) {
                    throw new Exception('Missing "signature" key in replaces section');
                }

                $signature = $replace['signature'];

                $replace_description = isset($replace['description']) && ! empty($description = $replace['description'])
                    ? lcfirst($description)
                    : $signature;

                $default_value = isset($replace['default']) && ! empty($default = $replace['default'])
                    ? $default
                    : null;

                $question = new Question(sprintf('Please enter %s', $replace_description), $default_value);
                $answer   = $this->question_helper->ask($input, $output, $question);

                if (! empty($answer)) {
                    array_push($replaces['what'], $signature);
                    array_push($replaces['with'], $answer);
                }
            }

            // Get template files list (recursively)
            foreach ($this->getFilesNamesRecursively($target_path, static::DEFAULT_REPLACES_EXCLUDES) as $file_path) {
                $output->writeln(
                    sprintf('Process file: <comment>%s</comment>', $file_path),
                    OutputInterface::VERBOSITY_VERBOSE
                );

                try {
                    $this->filesystem->dumpFile(
                        $file_path,
                        str_replace(
                            $replaces['what'],
                            $replaces['with'],
                            file_get_contents($file_path)
                        )
                    );
                } catch (Exception $e) {
                    $output->writeln(
                        sprintf('<error>Error with file "%s": %s</error>', $file_path, $e->getMessage())
                    );
                }
            }
        }

        return true;
    }

    /**
     * Get files in passed directory recursive.
     *
     * @param string $target_directory_path
     * @param null   $excludes
     *
     * @return string[]|array
     */
    protected function getFilesNamesRecursively($target_directory_path, $excludes = null)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(rtrim($target_directory_path, '/\\'))
        );

        $files = [];

        foreach ($iterator as $file) {
            /** @var SplFileInfo $file */
            if (! $file->isDir()) {
                foreach ((array) $excludes as $exclude) {
                    if (mb_strpos($file->getPathname(), $exclude) !== false) {
                        continue 2;
                    }
                }

                array_push($files, $file->getPathname());
            }
        }

        return $files;
    }
}
