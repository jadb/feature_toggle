<?php
namespace FeatureToggle\Storage;

use FeatureToggle\Exception\DuplicateFeatureException;
use FeatureToggle\Exception\FeatureNotFoundException;
use FeatureToggle\Feature\FeatureInterface;

class HashStorage implements StorageInterface
{
    private $features = [];

    public function index()
    {
        return $this->features;
    }

    public function get($alias)
    {
        if (!array_key_exists($alias, $this->features)) {
            throw new FeatureNotFoundException();
        }

        return $this->features[$alias];
    }

    public function add($alias, FeatureInterface $feature)
    {
        if (array_key_exists($alias, $this->features)) {
            throw new DuplicateFeatureException();
        }

        $this->features[$alias] = $feature;
        return $this;
    }

    public function remove($alias)
    {
        if (!array_key_exists($alias, $this->features)) {
            throw new FeatureNotFoundException();
        }

        unset($this->features[$alias]);
        return $this;
    }

    public function flush()
    {
        $this->features = [];
        return $this;
    }
}
