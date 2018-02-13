<?php

namespace Tarampampam\TemplatesBuilder\Templates;

use Exception;

/**
 * Class TemplatesSet.
 *
 * Templates helper.
 */
class TemplatesSet
{
    /**
     * Base templates directory path.
     *
     * @var string
     */
    protected $base_path;

    /**
     * @var Template[]|array
     */
    protected $templates = [];

    /**
     * Templates constructor.
     *
     * @param string $base_path
     *
     * @throws Exception
     */
    public function __construct($base_path)
    {
        if (! is_dir($base_path) || ! is_readable($base_path)) {
            throw new Exception(sprintf('Passed base path is not valid or unreadable: %s', $base_path));
        }

        $this->base_path = $base_path;

        foreach (glob($this->base_path . '/*', GLOB_ONLYDIR) as $directory_path) {
            $template = new Template($directory_path);

            if (! empty($template->getMetadata('description'))) {
                array_push($this->templates, $template);
            }
        }
    }

    /**
     * Get founded templates stack.
     *
     * @return Template[]|array
     */
    public function all()
    {
        return $this->templates;
    }
}
