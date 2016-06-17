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
use FeatureToggle\Exception\UnsupportedComparisonOperatorException;
use FeatureToggle\Feature\FeatureInterface;
use FeatureToggle\Strategy\ComparisonOperator\ComparisonOperatorInterface;
use FeatureToggle\Strategy\ComparisonOperator\GreaterThanEqual;

/**
 * DateTime strategy.
 */
final class DateTimeStrategy extends AbstractStrategy
{

    /**
     * Date time to use in comparison.
     *
     * @var string
     */
    private $reference;

    /**
     * Comparison operator.
     *
     * @var string
     */
    private $comparator;

    /**
     * Constructor.
     *
     * @param \DateTime $reference Date time to use in comparison.
     * @param \FeatureToggle\Strategy\ComparisonOperator\ComparisonOperatorInterface $comparator
     *   Comparison operator.
     * @throws \FeatureToggle\Exception\UnsupportedComparisonOperatorException When operator is
     *   not supported.
     */
    public function __construct(DateTime $reference, ComparisonOperatorInterface $comparator = null)
    {
        $this->reference = $reference;
        $this->comparator = $comparator ?: new GreaterThanEqual();
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(FeatureInterface $Feature, array $args = []): bool
    {
        $time = new DateTime();

        switch ($this->comparator->getValue()) {
            case '<':
                $result = $time < $this->reference;
                break;
            case '<=':
                $result = $time <= $this->reference;
                break;
            case '>=':
                $result = $time >= $this->reference;
                break;
            case '>':
                $result = $time > $this->reference;
                break;
            case '==':
                $result = $time == $this->reference;
                break;
            default:
                throw new UnsupportedComparisonOperatorException();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return json_encode([
            'reference' => $this->reference->getTimestamp(),
            'comparator' => serialize($this->comparator),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);
        $this->reference = (new \DateTime())->setTimestamp($data['reference']);
        $this->comparator = unserialize($data['comparator']);
    }
}
