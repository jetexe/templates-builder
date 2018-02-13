<?php

namespace Tarampampam\TemplatesBuilder;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Tarampampam\TemplatesBuilder\Commands\BuildCommand;
use Tarampampam\TemplatesBuilder\Commands\TemplatesListCommand;
use Tarampampam\TemplatesBuilder\Templates\TemplatesSet;

/**
 * Class Builder.
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

        $this->templates = new TemplatesSet(static::getBasePath() . '/templates');
    }

    /**
     * Get the templates set instance.
     *
     * @return TemplatesSet
     */
    public function templates()
    {
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
            /** @var Command $command */
            $this->add($command = new $commands_class);
        }
    }
}
