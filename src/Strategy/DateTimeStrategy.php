<?php

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
 * DateTime strategy.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Strategy
 * @author Jad Bitar <jadbitar@mac.com>
 */
class DateTimeStrategy extends AbstractStrategy
{
    /**
     * Date time to use in comparison.
     *
     * @var string
     */
    protected $datetime;

    /**
     * Comparison operator.
     *
     * @var string
     */
    protected $comparator;

    /**
     * Constructor.
     *
     * @param string $datetime Date time to use in comparison.
     * @param string $comparator Comparison operator.
     */
    public function __construct($datetime, $comparator = '>=')
    {
        $this->datetime = $datetime;
        $this->comparator = $comparator;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($Feature, array $args = [])
    {
        $time = $this->getCurrentTime();
        $datetime = strtotime($this->datetime);

        switch ($this->comparator) {
            case '<':
                $result = $time < $datetime;
                break;
            case '<=':
                $result = $time <= $datetime;
                break;
            case '>=':
                $result = $time >= $datetime;
                break;
            case '>':
                $result = $time > $datetime;
                break;
            case '==':
                $result = $time == $datetime;
                break;
            default:
                throw new \InvalidArgumentException('Bad comparison operator.');
        }

        return $result;
    }

    /**
     * Returns the current time. Used for dependency injection.
     *
     * @return string
     */
    public function getCurrentTime()
    {
        return time();
    }
}
