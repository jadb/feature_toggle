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
 * Storage interface.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Storage
 * @author Jad Bitar <jadbitar@mac.com>
 */
interface StorageInterface
{
    /**
     * Lists all toggles in storage.
     *
     * @return \FeatureToggle\Feature\FeatureInterface[]
     */
    public function index();

    /**
     * Returns requested toggle from storage.
     *
     * @param string $alias Toggle's name.
     * @return \FeatureToggle\Feature\FeatureInterface[]
     */
    public function get($alias);

    /**
     * Stores a new toggle.
     *
     * @param string $alias Toggle's name.
     * @param \FeatureToggle\Feature\FeatureInterface $feature
     * @return \FeatureToggle\Storage\StorageInterface
     */
    public function add($alias, FeatureInterface $feature);

    /**
     * Deletes toggle from storage.
     *
     * @param string $alias Toggle's name.
     * @return \FeatureToggle\Storage\StorageInterface
     */
    public function remove($alias);

    /**
     * Deletes all defined toggles from storage.
     *
     * @return \FeatureToggle\Storage\StorageInterface
     */
    public function flush();
}
