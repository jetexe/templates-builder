<?php

namespace Tarampampam\TemplatesBuilder;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\LogicException;
use Tarampampam\TemplatesBuilder\Commands\BuildCommand;
use Tarampampam\TemplatesBuilder\Templates\TemplatesSet;
use Tarampampam\TemplatesBuilder\Commands\TemplatesListCommand;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * Class Builder.
 *
 * Application instance.
 */
class Builder extends Application
{
    /**
     * Application name.
     */
    const APP_NAME = 'Templates builder';

    /**
     * Application version.
     */
    const APP_VERSION = '1.0.3';

    /**
     * @var TemplatesSet
     */
    protected $templates;

    /**
     * Builder constructor.
     *
     * @param string|null $name
     * @param string|null $version
     *
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public function __construct($name = null, $version = null)
    {
        parent::__construct(
            empty($name)
                ? static::APP_NAME
                : $name,
            empty($version)
                ? static::APP_VERSION
                : $version
        );

        $this->getDefinition()->addOption(
            new InputOption(
                '--templates-dir',
                '-t',
                InputOption::VALUE_OPTIONAL,
                'Load additional templates from this directory'
            )
        );
    }

    /**
     * Get base application path.
     *
     * @return bool|string
     */
    public static function getBasePath()
    {
        return realpath(__DIR__ . '/../.');
    }

    /**
     * Get own templates directories path.
     *
     * @return string
     */
    public static function getOwnTemplatesPath()
    {
        return static::getBasePath() . '/templates';
    }

    /**
     * {@inheritdoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $user_defined_templates_path = null;

        if ($input->hasParameterOption($templates_dir_option_name = '--templates-dir', true)) {
            $user_defined_templates_path = $input->getParameterOption($templates_dir_option_name);
        }

        // Make templates set initialization
        $this->templates = new TemplatesSet([
            static::getOwnTemplatesPath(),
            $user_defined_templates_path,
        ]);

        parent::doRun($input, $output);
    }

    /**
     * Get the templates set instance.
     *
     * @throws LogicException
     *
     * @return TemplatesSet
     */
    public function templates(): TemplatesSet
    {
        if (! ($this->templates instanceof TemplatesSet)) {
            throw new LogicException('Templates set is not initialized');
        }

        return $this->templates;
    }

    /**
     * Bootstrap the application.
     *
     * @throws LogicException
     *
     * @return void
     */
    public function bootstrap()
    {
        foreach ($this->getCommandsClasses() as $commands_class) {
            $this->add(new $commands_class);
        }
    }

    /**
     * Returns an array of commands classes.
     *
     * @return string[]
     */
    protected function getCommandsClasses(): array
    {
        return [
            TemplatesListCommand::class,
            BuildCommand::class,
        ];
    }
}
