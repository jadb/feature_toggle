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

use DateTime;
use FeatureToggle\Feature\FeatureInterface;
use FeatureToggle\Strategy\ComparisonOperator\GreaterThan;
use FeatureToggle\Strategy\ComparisonOperator\LowerThan;

/**
 * DateTimeRange strategy.
 */
final class DateTimeRangeStrategy extends AbstractStrategy
{

    const COMPARATORS = [
        'minRange' => GreaterThan::class,
        'maxRange' => LowerThan::class
    ];

    /**
     * Include start and end date time or not.
     *
     * @var boolean
     */
    private $inclusive;

    /**
     * Maximum date time.
     *
     * @var string
     */
    private $maxRange;

    /**
     * Minimum date time.
     *
     * @var string
     */
    private $minRange;

    /**
     * Constructor.
     *
     * @param \DateTime $minRange Minimum date time.
     * @param \DateTime $maxRange Maximum date time.
     * @param bool $inclusive Include minimum and maximum dates in range.
     */
    public function __construct(DateTime $minRange, DateTime $maxRange, bool $inclusive = false)
    {
        $this->minRange = $minRange;
        $this->maxRange = $maxRange;
        $this->inclusive = $inclusive;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(FeatureInterface $Feature, array $args = []): bool
    {
        $strategies = [];

        foreach (static::COMPARATORS as $var => $comparator) {
            if ($this->inclusive) {
                $comparator .= 'Equal';
            }

            $strategies[$var] = new DateTimeStrategy($this->$var, new $comparator);
        }

        $result = true;
        foreach ($strategies as $var => $Strategy) {
            if (!call_user_func($Strategy, $Feature)) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return json_encode([
            'minRange' => $this->minRange->getTimestamp(),
            'maxRange' => $this->maxRange->getTimestamp(),
            'inclusive' => $this->inclusive,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);
        $this->minRange = (new DateTime('now'))->setTimestamp($data['minRange']);
        $this->maxRange = (new DateTime('now'))->setTimestamp($data['maxRange']);
        $this->inclusive = $data['inclusive'];
    }
}
