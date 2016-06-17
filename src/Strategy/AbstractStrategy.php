<?php declare(strict_types=1);

/*
 * This file is part of the FeatureToggle package.
 *
 * (c) Jad Bitar <jadbitar@mac.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FeatureToggle\Strategy;

/**
 * Abstract strategy.
 */
abstract class AbstractStrategy implements StrategyInterface
{
    /**
     * Strategy's name.
     *
     * @var string
     */
    protected $name;

    /**
     * {@inheritdoc}
     */
    final public function getName(): string
    {
        if (empty($this->name)) {
            $this->name = $this->setName()->getName();
        }

        return $this->name;
    }

    /**
     * Sets name of cloned strategy before returning that instance.
     *
     * @param string $name Strategy's name.
     * @return \FeatureToggle\Strategy\StrategyInterface
     */
    private function setName(string $name = null): StrategyInterface
    {
        if (empty($name)) {
            $classname = explode('\\', get_class($this));
            $name = substr(array_pop($classname), 0, - strlen('Strategy'));
        }

        $strategy = clone($this);
        $strategy->name = $name;
        return $strategy;
    }
}
