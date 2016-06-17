<?php declare(strict_types=1);

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
 */
class FileStorage implements StorageInterface
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
    public function add(string $alias, FeatureInterface $feature): StorageInterface
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
        file_put_contents($this->file($alias), serialize($feature));
        return $this;
    }

    /**
     * Generates absolute path to file for a given alias.
     *
     * @param string $alias Feature's assigned named.
     * @return string
     */
    protected function file(string $alias): string
    {
        return $this->path . basename($alias);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $alias): FeatureInterface
    {
        return unserialize(file_get_contents($this->file($alias)));
    }

    /**
     * {@inheritdoc}
     */
    public function index(): array
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
    public function remove(string $alias): StorageInterface
    {
        unlink($this->file($alias));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(): StorageInterface
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
