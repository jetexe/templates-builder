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
     * Templates directories paths.
     *
     * @var string
     */
    protected $templates_paths;

    /**
     * @var Template[]|array
     */
    protected $templates = [];

    /**
     * Templates constructor.
     *
     * @param string[] $templates_paths
     *
     * @throws Exception
     */
    public function __construct($templates_paths)
    {
        $this->templates_paths = array_filter((array) $templates_paths);

        foreach ($this->templates_paths as $template_path) {
            if (is_dir($template_path) && is_readable($template_path)) {
                foreach (glob($template_path . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR) as $directory_path) {
                    $template = new Template($directory_path);

                    // Make simple template validation
                    if (is_dir($template->getTemplateSourcesPath())) {
                        array_push($this->templates, $template);
                    }
                }
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
