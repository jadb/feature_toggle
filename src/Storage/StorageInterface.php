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
 * Storage interface.
 */
interface StorageInterface
{
    /**
     * Lists all toggles in storage.
     *
     * @return \FeatureToggle\Feature\FeatureInterface[]
     */
    public function index(): array;

    /**
     * Returns requested toggle from storage.
     *
     * @param string $alias Toggle's name.
     * @return \FeatureToggle\Feature\FeatureInterface
     */
    public function get(string $alias): FeatureInterface;

    /**
     * Stores a new toggle.
     *
     * @param string $alias Toggle's name.
     * @param \FeatureToggle\Feature\FeatureInterface $feature
     * @return \FeatureToggle\Storage\StorageInterface
     */
    public function add(string $alias, FeatureInterface $feature): StorageInterface;

    /**
     * Deletes toggle from storage.
     *
     * @param string $alias Toggle's name.
     * @return \FeatureToggle\Storage\StorageInterface
     */
    public function remove(string $alias): StorageInterface;

    /**
     * Deletes all defined toggles from storage.
     *
     * @return \FeatureToggle\Storage\StorageInterface
     */
    public function flush(): StorageInterface;
}
