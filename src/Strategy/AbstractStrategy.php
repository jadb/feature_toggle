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
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Strategy
 * @author Jad Bitar <jadbitar@mac.com>
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
    public function getName(): string
    {
        if (empty($this->name)) {
            $this->setName();
        }

        return $this->name;
    }

    /**
     * Sets the strategy's name.
     *
     * @param string $name Strategy's name.
     * @return void
     */
    public function setName(string $name = null)
    {
        if (empty($name)) {
            $classname = explode('\\', get_class($this));
            $name = substr(array_pop($classname), 0, - strlen('Strategy'));
        }

        $this->name = $name;
    }
}
