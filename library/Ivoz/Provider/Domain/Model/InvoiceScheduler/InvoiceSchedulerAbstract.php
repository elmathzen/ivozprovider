<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\InvoiceScheduler;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Domain\Model\Helper\DateTimeHelper;
use Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplateInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequenceInterface;
use Ivoz\Provider\Domain\Model\InvoiceTemplate\InvoiceTemplate;
use Ivoz\Provider\Domain\Model\Brand\Brand;
use Ivoz\Provider\Domain\Model\Company\Company;
use Ivoz\Provider\Domain\Model\InvoiceNumberSequence\InvoiceNumberSequence;

/**
* InvoiceSchedulerAbstract
* @codeCoverageIgnore
*/
abstract class InvoiceSchedulerAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * comment: enum:week|month|year
     * @var string
     */
    protected $unit = 'month';

    /**
     * @var int
     */
    protected $frequency;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var \DateTime | null
     */
    protected $lastExecution;

    /**
     * @var string | null
     */
    protected $lastExecutionError;

    /**
     * @var \DateTime | null
     */
    protected $nextExecution;

    /**
     * @var float | null
     */
    protected $taxRate;

    /**
     * @var InvoiceTemplateInterface | null
     */
    protected $invoiceTemplate;

    /**
     * @var BrandInterface
     */
    protected $brand;

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * @var InvoiceNumberSequenceInterface | null
     */
    protected $numberSequence;

    /**
     * Constructor
     */
    protected function __construct(
        $name,
        $unit,
        $frequency,
        $email
    ) {
        $this->setName($name);
        $this->setUnit($unit);
        $this->setFrequency($frequency);
        $this->setEmail($email);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "InvoiceScheduler",
            $this->getId()
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function sanitizeValues()
    {
    }

    /**
     * @param mixed $id
     * @return InvoiceSchedulerDto
     */
    public static function createDto($id = null)
    {
        return new InvoiceSchedulerDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param InvoiceSchedulerInterface|null $entity
     * @param int $depth
     * @return InvoiceSchedulerDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, InvoiceSchedulerInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var InvoiceSchedulerDto $dto */
        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param InvoiceSchedulerDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, InvoiceSchedulerDto::class);

        $self = new static(
            $dto->getName(),
            $dto->getUnit(),
            $dto->getFrequency(),
            $dto->getEmail()
        );

        $self
            ->setLastExecution($dto->getLastExecution())
            ->setLastExecutionError($dto->getLastExecutionError())
            ->setNextExecution($dto->getNextExecution())
            ->setTaxRate($dto->getTaxRate())
            ->setInvoiceTemplate($fkTransformer->transform($dto->getInvoiceTemplate()))
            ->setBrand($fkTransformer->transform($dto->getBrand()))
            ->setCompany($fkTransformer->transform($dto->getCompany()))
            ->setNumberSequence($fkTransformer->transform($dto->getNumberSequence()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param InvoiceSchedulerDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, InvoiceSchedulerDto::class);

        $this
            ->setName($dto->getName())
            ->setUnit($dto->getUnit())
            ->setFrequency($dto->getFrequency())
            ->setEmail($dto->getEmail())
            ->setLastExecution($dto->getLastExecution())
            ->setLastExecutionError($dto->getLastExecutionError())
            ->setNextExecution($dto->getNextExecution())
            ->setTaxRate($dto->getTaxRate())
            ->setInvoiceTemplate($fkTransformer->transform($dto->getInvoiceTemplate()))
            ->setBrand($fkTransformer->transform($dto->getBrand()))
            ->setCompany($fkTransformer->transform($dto->getCompany()))
            ->setNumberSequence($fkTransformer->transform($dto->getNumberSequence()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return InvoiceSchedulerDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setName(self::getName())
            ->setUnit(self::getUnit())
            ->setFrequency(self::getFrequency())
            ->setEmail(self::getEmail())
            ->setLastExecution(self::getLastExecution())
            ->setLastExecutionError(self::getLastExecutionError())
            ->setNextExecution(self::getNextExecution())
            ->setTaxRate(self::getTaxRate())
            ->setInvoiceTemplate(InvoiceTemplate::entityToDto(self::getInvoiceTemplate(), $depth))
            ->setBrand(Brand::entityToDto(self::getBrand(), $depth))
            ->setCompany(Company::entityToDto(self::getCompany(), $depth))
            ->setNumberSequence(InvoiceNumberSequence::entityToDto(self::getNumberSequence(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'name' => self::getName(),
            'unit' => self::getUnit(),
            'frequency' => self::getFrequency(),
            'email' => self::getEmail(),
            'lastExecution' => self::getLastExecution(),
            'lastExecutionError' => self::getLastExecutionError(),
            'nextExecution' => self::getNextExecution(),
            'taxRate' => self::getTaxRate(),
            'invoiceTemplateId' => self::getInvoiceTemplate() ? self::getInvoiceTemplate()->getId() : null,
            'brandId' => self::getBrand()->getId(),
            'companyId' => self::getCompany()->getId(),
            'numberSequenceId' => self::getNumberSequence() ? self::getNumberSequence()->getId() : null
        ];
    }

    protected function setName(string $name): static
    {
        Assertion::maxLength($name, 40, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function setUnit(string $unit): static
    {
        Assertion::maxLength($unit, 30, 'unit value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        Assertion::choice(
            $unit,
            [
                InvoiceSchedulerInterface::UNIT_WEEK,
                InvoiceSchedulerInterface::UNIT_MONTH,
                InvoiceSchedulerInterface::UNIT_YEAR,
            ],
            'unitvalue "%s" is not an element of the valid values: %s'
        );

        $this->unit = $unit;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    protected function setFrequency(int $frequency): static
    {
        Assertion::greaterOrEqualThan($frequency, 0, 'frequency provided "%s" is not greater or equal than "%s".');

        $this->frequency = $frequency;

        return $this;
    }

    public function getFrequency(): int
    {
        return $this->frequency;
    }

    protected function setEmail(string $email): static
    {
        Assertion::maxLength($email, 140, 'email value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->email = $email;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected function setLastExecution($lastExecution = null): static
    {
        if (!is_null($lastExecution)) {
            Assertion::notNull(
                $lastExecution,
                'lastExecution value "%s" is null, but non null value was expected.'
            );
            $lastExecution = DateTimeHelper::createOrFix(
                $lastExecution,
                null
            );

            if ($this->lastExecution == $lastExecution) {
                return $this;
            }
        }

        $this->lastExecution = $lastExecution;

        return $this;
    }

    public function getLastExecution(): ?\DateTime
    {
        return !is_null($this->lastExecution) ? clone $this->lastExecution : null;
    }

    protected function setLastExecutionError(?string $lastExecutionError = null): static
    {
        if (!is_null($lastExecutionError)) {
            Assertion::maxLength($lastExecutionError, 300, 'lastExecutionError value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->lastExecutionError = $lastExecutionError;

        return $this;
    }

    public function getLastExecutionError(): ?string
    {
        return $this->lastExecutionError;
    }

    protected function setNextExecution($nextExecution = null): static
    {
        if (!is_null($nextExecution)) {
            Assertion::notNull(
                $nextExecution,
                'nextExecution value "%s" is null, but non null value was expected.'
            );
            $nextExecution = DateTimeHelper::createOrFix(
                $nextExecution,
                null
            );

            if ($this->nextExecution == $nextExecution) {
                return $this;
            }
        }

        $this->nextExecution = $nextExecution;

        return $this;
    }

    public function getNextExecution(): ?\DateTime
    {
        return !is_null($this->nextExecution) ? clone $this->nextExecution : null;
    }

    protected function setTaxRate(?float $taxRate = null): static
    {
        if (!is_null($taxRate)) {
            $taxRate = (float) $taxRate;
        }

        $this->taxRate = $taxRate;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    protected function setInvoiceTemplate(?InvoiceTemplateInterface $invoiceTemplate = null): static
    {
        $this->invoiceTemplate = $invoiceTemplate;

        return $this;
    }

    public function getInvoiceTemplate(): ?InvoiceTemplateInterface
    {
        return $this->invoiceTemplate;
    }

    protected function setBrand(BrandInterface $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }

    protected function setCompany(CompanyInterface $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompany(): CompanyInterface
    {
        return $this->company;
    }

    protected function setNumberSequence(?InvoiceNumberSequenceInterface $numberSequence = null): static
    {
        $this->numberSequence = $numberSequence;

        return $this;
    }

    public function getNumberSequence(): ?InvoiceNumberSequenceInterface
    {
        return $this->numberSequence;
    }
}
