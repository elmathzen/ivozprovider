<?php

namespace Ivoz\Provider\Domain\Model\Feature;

use Ivoz\Core\Domain\Model\EntityInterface;

interface FeatureInterface extends EntityInterface
{
    /**
     * Set iden
     *
     * @param string $iden
     *
     * @return self
     */
    public function setIden($iden);

    /**
     * Get iden
     *
     * @return string
     */
    public function getIden();

    /**
     * Set name
     *
     * @param \Ivoz\Provider\Domain\Model\Feature\Name $name
     *
     * @return self
     */
    public function setName(\Ivoz\Provider\Domain\Model\Feature\Name $name);

    /**
     * Get name
     *
     * @return \Ivoz\Provider\Domain\Model\Feature\Name
     */
    public function getName();

}

