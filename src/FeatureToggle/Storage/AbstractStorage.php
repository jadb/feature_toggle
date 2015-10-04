<?php
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
