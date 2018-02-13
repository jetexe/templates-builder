<?php

namespace Tarampampam\TemplatesBuilder\Templates;

use Exception;

class Template
{
    /**
     * Metadata file name.
     */
    const METADATA_FILENAME = 'metadata.json';

    /**
     * Template name.
     *
     * @var string
     */
    protected $name;

    /**
     * Template base path.
     *
     * @var string
     */
    protected $template_path;

    /**
     * Template metadata.
     *
     * @var array
     */
    protected $metadata = [];

    /**
     * Template constructor.
     *
     * @param string $name
     *
     * @throws Exception
     */
    public function __construct($template_path, $name = null)
    {
        if (! is_dir($template_path) || ! is_readable($template_path)) {
            throw new Exception(sprintf('Passed template path is not valid or unreadable: "%s"', $template_path));
        }

        $this->template_path = $template_path;

        $this->name = empty($name)
            ? basename($template_path)
            : $name;

        $this->initMetadata();
    }

    /**
     * Make template metadata initialization.
     *
     * @throws Exception
     */
    protected function initMetadata()
    {
        if (! is_file($meta = $this->template_path . '/' . static::METADATA_FILENAME) || ! is_readable($meta)) {
            throw new Exception(
                sprintf(
                    'Metadata file "%s" not exists or unreadable in directory "%s"',
                    $meta,
                    $this->template_path
                )
            );
        }

        $this->metadata = json_decode(file_get_contents($meta), true);
    }

    /**
     * Get template metadata content as an array (optional you can pass any root section name).
     *
     * @param string|null $section_name
     *
     * @return array|null|mixed
     */
    public function getMetadata($section_name = null)
    {
        if (! empty($section_name)) {
            return isset($this->metadata[$section_name])
                ? $this->metadata[$section_name]
                : null;
        }

        return $this->metadata;
    }

    /**
     * Get template name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get template description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getMetadata('description');
    }
}
