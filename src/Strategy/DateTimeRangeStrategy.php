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

use FeatureToggle\Feature\FeatureInterface;

/**
 * DateTimeRange strategy.
 *
 * @package FeatureToggle
 * @subpackage FeatureToggle.Strategy
 * @author Jad Bitar <jadbitar@mac.com>
 */
class DateTimeRangeStrategy extends AbstractStrategy
{

    const COMPARATORS = [
        'minRange' => '>',
        'maxRange' => '<'
    ];

    /**
     * Include start and end date time or not.
     *
     * @var boolean
     */
    protected $inclusive;

    /**
     * Maximum date time.
     *
     * @var string
     */
    protected $maxRange;

    /**
     * Minimum date time.
     *
     * @var string
     */
    protected $minRange;

    /**
     * Constructor.
     *
     * @param string $minRange Minimum date time.
     * @param string $maxRange Maximum date time.
     * @param boolean $inclusive Include minimum and maximum dates in range.
     */
    public function __construct(string $minRange, string $maxRange, bool $inclusive = false)
    {
        $this->inclusive = $inclusive;
        $this->maxRange = $maxRange;
        $this->minRange = $minRange;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(FeatureInterface $Feature, array $args = []): bool
    {
        $strategies = [];

        foreach (static::COMPARATORS as $var => $comparator) {
            if ($this->inclusive) {
                $comparator .= '=';
            }
            $strategies[$var] = $this->asDateTimeStrategy($this->$var, $comparator);
        }

        $result = true;
        foreach ($strategies as $var => $Strategy) {
            if (!call_user_func($Strategy, $Feature)) {
                $result = false;
            }
        }

        return $result;
    }

    public function asDateTimeStrategy(string $datetime, string $comparator): DateTimeStrategy
    {
        return new DateTimeStrategy($datetime, $comparator);
    }
}
