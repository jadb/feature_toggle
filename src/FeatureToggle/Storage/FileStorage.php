<?php

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Storage;

use FeatureToggle\Feature\FeatureInterface;

/**
 * File storage.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Storage
 * @author Jad Bitar <jadbitar@mac.com>
 */
class FileStorage extends AbstractStorage
{
    /**
     * Absolute path where to store created files.
     *
     * @var string
     */
    protected $path;

    /**
     * Constructor.
     *
     * @param string $path Absolute path where to store created files.
     */
    public function __construct($path)
    {
        $this->path = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * {@inheritdoc}
     */
    public function add($alias, FeatureInterface $feature)
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
        file_put_contents($this->file($alias), $this->feature($feature));
        return $this;
    }

    /**
     * Generates absolute path to file for a given alias.
     *
     * @param string $alias Feature's assigned named.
     * @return string
     */
    protected function file($alias)
    {
        return $this->path . basename($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        return unserialize(file_get_contents($this->file($alias)));
    }

    /**
     * {@inheritdoc}
     */
    public function index()
    {
        $features = [];

        foreach (new \DirectoryIterator($this->path) as $file) {
            $filename = $file->getFilename();
            if (trim($filename, '.')) {
                $features[$filename] = unserialize(file_get_contents($this->file($filename)));
            }
        }

        return $features;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($alias)
    {
        unlink($this->file($alias));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        foreach (new \DirectoryIterator($this->path) as $file) {
            $filename = $file->getFilename();
            if (trim($filename, '.')) {
                $this->remove($filename);
            }
        }

        rmdir($this->path);
        return $this;
    }
}
