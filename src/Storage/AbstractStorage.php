<?php
declare(strict_types = 1);

namespace FeatureToggle\Storage;

use FeatureToggle\Feature\FeatureInterface;

abstract class AbstractStorage implements StorageInterface
{

    protected function feature(FeatureInterface $feature)
    {
        return serialize($feature);
    }
}
