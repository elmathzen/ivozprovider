<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\ResidentialDevice;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpointInterface;
use Ivoz\Ast\Domain\Model\PsIdentify\PsIdentifyInterface;
use Ivoz\Provider\Domain\Model\Ddi\DdiInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Ivoz\Provider\Domain\Model\CallForwardSetting\CallForwardSettingInterface;

/**
* @codeCoverageIgnore
*/
trait ResidentialDeviceTrait
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var PsEndpointInterface
     * mappedBy residentialDevice
     */
    protected $psEndpoint;

    /**
     * @var PsIdentifyInterface
     * mappedBy residentialDevice
     */
    protected $psIdentify;

    /**
     * @var ArrayCollection
     * DdiInterface mappedBy residentialDevice
     */
    protected $ddis;

    /**
     * @var ArrayCollection
     * CallForwardSettingInterface mappedBy residentialDevice
     */
    protected $callForwardSettings;

    /**
     * Constructor
     */
    protected function __construct()
    {
        parent::__construct(...func_get_args());
        $this->ddis = new ArrayCollection();
        $this->callForwardSettings = new ArrayCollection();
    }

    abstract protected function sanitizeValues();

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param ResidentialDeviceDto $dto
     * @param ForeignKeyTransformerInterface  $fkTransformer
     * @return static
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        /** @var static $self */
        $self = parent::fromDto($dto, $fkTransformer);
        if (!is_null($dto->getPsEndpoint())) {
            $self->setPsEndpoint(
                $fkTransformer->transform(
                    $dto->getPsEndpoint()
                )
            );
        }

        if (!is_null($dto->getPsIdentify())) {
            $self->setPsIdentify(
                $fkTransformer->transform(
                    $dto->getPsIdentify()
                )
            );
        }

        if (!is_null($dto->getDdis())) {
            $self->replaceDdis(
                $fkTransformer->transformCollection(
                    $dto->getDdis()
                )
            );
        }

        if (!is_null($dto->getCallForwardSettings())) {
            $self->replaceCallForwardSettings(
                $fkTransformer->transformCollection(
                    $dto->getCallForwardSettings()
                )
            );
        }

        $self->sanitizeValues();
        if ($dto->getId()) {
            $self->id = $dto->getId();
            $self->initChangelog();
        }

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param ResidentialDeviceDto $dto
     * @param ForeignKeyTransformerInterface  $fkTransformer
     * @return static
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        parent::updateFromDto($dto, $fkTransformer);
        if (!is_null($dto->getPsEndpoint())) {
            $this->setPsEndpoint(
                $fkTransformer->transform(
                    $dto->getPsEndpoint()
                )
            );
        }

        if (!is_null($dto->getPsIdentify())) {
            $this->setPsIdentify(
                $fkTransformer->transform(
                    $dto->getPsIdentify()
                )
            );
        }

        if (!is_null($dto->getDdis())) {
            $this->replaceDdis(
                $fkTransformer->transformCollection(
                    $dto->getDdis()
                )
            );
        }

        if (!is_null($dto->getCallForwardSettings())) {
            $this->replaceCallForwardSettings(
                $fkTransformer->transformCollection(
                    $dto->getCallForwardSettings()
                )
            );
        }
        $this->sanitizeValues();

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return ResidentialDeviceDto
     */
    public function toDto($depth = 0)
    {
        $dto = parent::toDto($depth);
        return $dto
            ->setId($this->getId());
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return parent::__toArray() + [
            'id' => self::getId()
        ];
    }

    public function setPsEndpoint(PsEndpointInterface $psEndpoint): static
    {
        $this->psEndpoint = $psEndpoint;

        /** @var  $this */
        return $this;
    }

    public function getPsEndpoint(): ?PsEndpointInterface
    {
        return $this->psEndpoint;
    }

    public function setPsIdentify(PsIdentifyInterface $psIdentify): static
    {
        $this->psIdentify = $psIdentify;

        /** @var  $this */
        return $this;
    }

    public function getPsIdentify(): ?PsIdentifyInterface
    {
        return $this->psIdentify;
    }

    public function addDdi(DdiInterface $ddi): ResidentialDeviceInterface
    {
        $this->ddis->add($ddi);

        return $this;
    }

    public function removeDdi(DdiInterface $ddi): ResidentialDeviceInterface
    {
        $this->ddis->removeElement($ddi);

        return $this;
    }

    public function replaceDdis(ArrayCollection $ddis): ResidentialDeviceInterface
    {
        $updatedEntities = [];
        $fallBackId = -1;
        foreach ($ddis as $entity) {
            $index = $entity->getId() ? $entity->getId() : $fallBackId--;
            $updatedEntities[$index] = $entity;
            $entity->setResidentialDevice($this);
        }
        $updatedEntityKeys = array_keys($updatedEntities);

        foreach ($this->ddis as $key => $entity) {
            $identity = $entity->getId();
            if (in_array($identity, $updatedEntityKeys)) {
                $this->ddis->set($key, $updatedEntities[$identity]);
            } else {
                $this->ddis->remove($key);
            }
            unset($updatedEntities[$identity]);
        }

        foreach ($updatedEntities as $entity) {
            $this->addDdi($entity);
        }

        return $this;
    }

    public function getDdis(Criteria $criteria = null): array
    {
        if (!is_null($criteria)) {
            return $this->ddis->matching($criteria)->toArray();
        }

        return $this->ddis->toArray();
    }

    public function addCallForwardSetting(CallForwardSettingInterface $callForwardSetting): ResidentialDeviceInterface
    {
        $this->callForwardSettings->add($callForwardSetting);

        return $this;
    }

    public function removeCallForwardSetting(CallForwardSettingInterface $callForwardSetting): ResidentialDeviceInterface
    {
        $this->callForwardSettings->removeElement($callForwardSetting);

        return $this;
    }

    public function replaceCallForwardSettings(ArrayCollection $callForwardSettings): ResidentialDeviceInterface
    {
        $updatedEntities = [];
        $fallBackId = -1;
        foreach ($callForwardSettings as $entity) {
            $index = $entity->getId() ? $entity->getId() : $fallBackId--;
            $updatedEntities[$index] = $entity;
            $entity->setResidentialDevice($this);
        }
        $updatedEntityKeys = array_keys($updatedEntities);

        foreach ($this->callForwardSettings as $key => $entity) {
            $identity = $entity->getId();
            if (in_array($identity, $updatedEntityKeys)) {
                $this->callForwardSettings->set($key, $updatedEntities[$identity]);
            } else {
                $this->callForwardSettings->remove($key);
            }
            unset($updatedEntities[$identity]);
        }

        foreach ($updatedEntities as $entity) {
            $this->addCallForwardSetting($entity);
        }

        return $this;
    }

    public function getCallForwardSettings(Criteria $criteria = null): array
    {
        if (!is_null($criteria)) {
            return $this->callForwardSettings->matching($criteria)->toArray();
        }

        return $this->callForwardSettings->toArray();
    }
}
