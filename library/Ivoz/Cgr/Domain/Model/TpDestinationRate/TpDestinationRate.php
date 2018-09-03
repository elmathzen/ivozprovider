<?php

namespace Ivoz\Cgr\Domain\Model\TpDestinationRate;

/**
 * TpDestinationRate
 */
class TpDestinationRate extends TpDestinationRateAbstract implements TpDestinationRateInterface
{
    use TpDestinationRateTrait;

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Validate RateIncrement has valid unit
     *
     * @param string $rateIncrement
     * @return $this|TpRateAbstract|TpRateInterface
     */
    public function setRateIncrement($rateIncrement)
    {
        if (is_numeric($rateIncrement)) {
            $rateIncrement .= "s";
        }

        return parent::setRateIncrement($rateIncrement);
    }

    /**
     * Validate GroupIntervalStart has valid unit
     *
     * @param string $groupIntervalStart
     * @return $this|TpRateAbstract|TpRateInterface
     */
    public function setGroupIntervalStart($groupIntervalStart)
    {
        if (is_numeric($groupIntervalStart)) {
            $groupIntervalStart .= "s";
        }

        return parent::setGroupIntervalStart($groupIntervalStart);
    }
}
