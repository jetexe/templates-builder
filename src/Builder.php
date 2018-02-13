<?php

namespace Tarampampam\TemplatesBuilder;

use LogicException;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tarampampam\TemplatesBuilder\Commands\BuildCommand;
use Tarampampam\TemplatesBuilder\Commands\TemplatesListCommand;
use Tarampampam\TemplatesBuilder\Templates\TemplatesSet;

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
    const APP_VERSION = '1.0.0';

    /**
     * @var TemplatesSet
     */
    protected $templates;

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
     * Builder constructor.
     *
     * @param null|string $name
     * @param null|string $version
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
            static::getBasePath() . '/templates',
            $user_defined_templates_path,
        ]);

        parent::doRun($input, $output);
    }

    /**
     * Get the templates set instance.
     *
     * @return TemplatesSet
     *
     * @throws LogicException
     */
    public function templates()
    {
        if (! ($this->templates instanceof TemplatesSet)) {
            throw new LogicException('Templates set is not initialized');
        }

        return $this->templates;
    }

    /**
     * Returns an array of commands classes.
     *
     * @return string[]
     */
    protected function getCommandsClasses()
    {
        return [
            TemplatesListCommand::class,
            BuildCommand::class,
        ];
    }

    /**
     * Bootstrap the application.
     *
     * @return void
     */
    public function bootstrap()
    {
        foreach ($this->getCommandsClasses() as $commands_class) {
            $this->add(new $commands_class);
        }
    }
}
