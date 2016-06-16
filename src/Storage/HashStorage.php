<?php
declare(strict_types = 1);

namespace FeatureToggle\Storage;

use FeatureToggle\Feature\FeatureInterface;
use InvalidArgumentException;

/**
 * Hash Storage (default).
 */
class HashStorage implements StorageInterface
{

    private $features = [];

    public function index(): array
    {
        return $this->features;
    }

    public function get(string $alias): FeatureInterface
    {
        if (!array_key_exists($alias, $this->features)) {
            throw new InvalidArgumentException('Unknown feature identifier.');
        }

        return $this->features[$alias];
    }

    public function add(string $alias, FeatureInterface $feature): StorageInterface
    {
        if (array_key_exists($alias, $this->features)) {
            throw new InvalidArgumentException('Duplicate feature identifier.');
        }

        $this->features[$alias] = $feature;
        return $this;
    }

    public function remove(string $alias): StorageInterface
    {
        if (!array_key_exists($alias, $this->features)) {
            throw new InvalidArgumentException('Unknown feature identifier.');
        }

        unset($this->features[$alias]);
        return $this;
    }

    public function flush(): StorageInterface
    {
        $this->features = [];
        return $this;
    }
}
