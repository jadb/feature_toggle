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

abstract class AbstractStorage implements StorageInterface
{

    /**
     * Serializes feature for storage.
     *
     * @param \FeatureToggle\Feature\FeatureInterface $feature Feature instance.
     * @return string
     */
    protected function feature(FeatureInterface $feature)
    {
        return serialize($feature);
    }
}
