<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\RetailAccount;

use Assert\Assertion;
use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Domain\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\Domain\DomainInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\TransformationRuleSet\TransformationRuleSetInterface;
use Ivoz\Provider\Domain\Model\Ddi\DdiInterface;
use Ivoz\Provider\Domain\Model\ProxyUser\ProxyUserInterface;
use Ivoz\Provider\Domain\Model\Brand\Brand;
use Ivoz\Provider\Domain\Model\Domain\Domain;
use Ivoz\Provider\Domain\Model\Company\Company;
use Ivoz\Provider\Domain\Model\TransformationRuleSet\TransformationRuleSet;
use Ivoz\Provider\Domain\Model\Ddi\Ddi;
use Ivoz\Provider\Domain\Model\ProxyUser\ProxyUser;

/**
* RetailAccountAbstract
* @codeCoverageIgnore
*/
abstract class RetailAccountAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var ?string
     * comment: enum:udp|tcp|tls
     */
    protected $transport = null;

    /**
     * @var ?string
     */
    protected $ip = null;

    /**
     * @var ?int
     */
    protected $port = null;

    /**
     * @var ?string
     */
    protected $password = null;

    /**
     * @var ?string
     */
    protected $fromDomain = null;

    /**
     * @var string
     * comment: enum:yes|no
     */
    protected $directConnectivity = 'yes';

    /**
     * @var string
     * comment: enum:yes|no
     */
    protected $ddiIn = 'yes';

    /**
     * @var string
     * comment: enum:yes|no
     */
    protected $t38Passthrough = 'no';

    /**
     * @var bool
     */
    protected $rtpEncryption = false;

    /**
     * @var bool
     */
    protected $multiContact = true;

    /**
     * @var ?string
     * column: ruri_domain
     */
    protected $ruriDomain = null;

    /**
     * @var bool
     */
    protected $trustSDP = false;

    /**
     * @var BrandInterface
     * inversedBy residentialDevices
     */
    protected $brand;

    /**
     * @var ?DomainInterface
     * inversedBy residentialDevices
     */
    protected $domain = null;

    /**
     * @var CompanyInterface
     */
    protected $company;

    /**
     * @var ?TransformationRuleSetInterface
     */
    protected $transformationRuleSet = null;

    /**
     * @var ?DdiInterface
     */
    protected $outgoingDdi = null;

    /**
     * @var ?ProxyUserInterface
     */
    protected $proxyUser = null;

    /**
     * Constructor
     */
    protected function __construct(
        string $name,
        string $description,
        string $directConnectivity,
        string $ddiIn,
        string $t38Passthrough,
        bool $rtpEncryption,
        bool $multiContact,
        bool $trustSDP
    ) {
        $this->setName($name);
        $this->setDescription($description);
        $this->setDirectConnectivity($directConnectivity);
        $this->setDdiIn($ddiIn);
        $this->setT38Passthrough($t38Passthrough);
        $this->setRtpEncryption($rtpEncryption);
        $this->setMultiContact($multiContact);
        $this->setTrustSDP($trustSDP);
    }

    abstract public function getId(): null|string|int;

    public function __toString(): string
    {
        return sprintf(
            "%s#%s",
            "RetailAccount",
            (string) $this->getId()
        );
    }

    /**
     * @throws \Exception
     */
    protected function sanitizeValues(): void
    {
    }

    /**
     * @param int | null $id
     */
    public static function createDto($id = null): RetailAccountDto
    {
        return new RetailAccountDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param null|RetailAccountInterface $entity
     */
    public static function entityToDto(?EntityInterface $entity, int $depth = 0): ?RetailAccountDto
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, RetailAccountInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param RetailAccountDto $dto
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, RetailAccountDto::class);
        $name = $dto->getName();
        Assertion::notNull($name, 'getName value is null, but non null value was expected.');
        $description = $dto->getDescription();
        Assertion::notNull($description, 'getDescription value is null, but non null value was expected.');
        $directConnectivity = $dto->getDirectConnectivity();
        Assertion::notNull($directConnectivity, 'getDirectConnectivity value is null, but non null value was expected.');
        $ddiIn = $dto->getDdiIn();
        Assertion::notNull($ddiIn, 'getDdiIn value is null, but non null value was expected.');
        $t38Passthrough = $dto->getT38Passthrough();
        Assertion::notNull($t38Passthrough, 'getT38Passthrough value is null, but non null value was expected.');
        $rtpEncryption = $dto->getRtpEncryption();
        Assertion::notNull($rtpEncryption, 'getRtpEncryption value is null, but non null value was expected.');
        $multiContact = $dto->getMultiContact();
        Assertion::notNull($multiContact, 'getMultiContact value is null, but non null value was expected.');
        $trustSDP = $dto->getTrustSDP();
        Assertion::notNull($trustSDP, 'getTrustSDP value is null, but non null value was expected.');
        $brand = $dto->getBrand();
        Assertion::notNull($brand, 'getBrand value is null, but non null value was expected.');
        $company = $dto->getCompany();
        Assertion::notNull($company, 'getCompany value is null, but non null value was expected.');

        $self = new static(
            $name,
            $description,
            $directConnectivity,
            $ddiIn,
            $t38Passthrough,
            $rtpEncryption,
            $multiContact,
            $trustSDP
        );

        $self
            ->setTransport($dto->getTransport())
            ->setIp($dto->getIp())
            ->setPort($dto->getPort())
            ->setPassword($dto->getPassword())
            ->setFromDomain($dto->getFromDomain())
            ->setRuriDomain($dto->getRuriDomain())
            ->setBrand($fkTransformer->transform($brand))
            ->setDomain($fkTransformer->transform($dto->getDomain()))
            ->setCompany($fkTransformer->transform($company))
            ->setTransformationRuleSet($fkTransformer->transform($dto->getTransformationRuleSet()))
            ->setOutgoingDdi($fkTransformer->transform($dto->getOutgoingDdi()))
            ->setProxyUser($fkTransformer->transform($dto->getProxyUser()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param RetailAccountDto $dto
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ): static {
        Assertion::isInstanceOf($dto, RetailAccountDto::class);

        $name = $dto->getName();
        Assertion::notNull($name, 'getName value is null, but non null value was expected.');
        $description = $dto->getDescription();
        Assertion::notNull($description, 'getDescription value is null, but non null value was expected.');
        $directConnectivity = $dto->getDirectConnectivity();
        Assertion::notNull($directConnectivity, 'getDirectConnectivity value is null, but non null value was expected.');
        $ddiIn = $dto->getDdiIn();
        Assertion::notNull($ddiIn, 'getDdiIn value is null, but non null value was expected.');
        $t38Passthrough = $dto->getT38Passthrough();
        Assertion::notNull($t38Passthrough, 'getT38Passthrough value is null, but non null value was expected.');
        $rtpEncryption = $dto->getRtpEncryption();
        Assertion::notNull($rtpEncryption, 'getRtpEncryption value is null, but non null value was expected.');
        $multiContact = $dto->getMultiContact();
        Assertion::notNull($multiContact, 'getMultiContact value is null, but non null value was expected.');
        $trustSDP = $dto->getTrustSDP();
        Assertion::notNull($trustSDP, 'getTrustSDP value is null, but non null value was expected.');
        $brand = $dto->getBrand();
        Assertion::notNull($brand, 'getBrand value is null, but non null value was expected.');
        $company = $dto->getCompany();
        Assertion::notNull($company, 'getCompany value is null, but non null value was expected.');

        $this
            ->setName($name)
            ->setDescription($description)
            ->setTransport($dto->getTransport())
            ->setIp($dto->getIp())
            ->setPort($dto->getPort())
            ->setPassword($dto->getPassword())
            ->setFromDomain($dto->getFromDomain())
            ->setDirectConnectivity($directConnectivity)
            ->setDdiIn($ddiIn)
            ->setT38Passthrough($t38Passthrough)
            ->setRtpEncryption($rtpEncryption)
            ->setMultiContact($multiContact)
            ->setRuriDomain($dto->getRuriDomain())
            ->setTrustSDP($trustSDP)
            ->setBrand($fkTransformer->transform($brand))
            ->setDomain($fkTransformer->transform($dto->getDomain()))
            ->setCompany($fkTransformer->transform($company))
            ->setTransformationRuleSet($fkTransformer->transform($dto->getTransformationRuleSet()))
            ->setOutgoingDdi($fkTransformer->transform($dto->getOutgoingDdi()))
            ->setProxyUser($fkTransformer->transform($dto->getProxyUser()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     */
    public function toDto(int $depth = 0): RetailAccountDto
    {
        return self::createDto()
            ->setName(self::getName())
            ->setDescription(self::getDescription())
            ->setTransport(self::getTransport())
            ->setIp(self::getIp())
            ->setPort(self::getPort())
            ->setPassword(self::getPassword())
            ->setFromDomain(self::getFromDomain())
            ->setDirectConnectivity(self::getDirectConnectivity())
            ->setDdiIn(self::getDdiIn())
            ->setT38Passthrough(self::getT38Passthrough())
            ->setRtpEncryption(self::getRtpEncryption())
            ->setMultiContact(self::getMultiContact())
            ->setRuriDomain(self::getRuriDomain())
            ->setTrustSDP(self::getTrustSDP())
            ->setBrand(Brand::entityToDto(self::getBrand(), $depth))
            ->setDomain(Domain::entityToDto(self::getDomain(), $depth))
            ->setCompany(Company::entityToDto(self::getCompany(), $depth))
            ->setTransformationRuleSet(TransformationRuleSet::entityToDto(self::getTransformationRuleSet(), $depth))
            ->setOutgoingDdi(Ddi::entityToDto(self::getOutgoingDdi(), $depth))
            ->setProxyUser(ProxyUser::entityToDto(self::getProxyUser(), $depth));
    }

    /**
     * @return array<string, mixed>
     */
    protected function __toArray(): array
    {
        return [
            'name' => self::getName(),
            'description' => self::getDescription(),
            'transport' => self::getTransport(),
            'ip' => self::getIp(),
            'port' => self::getPort(),
            'password' => self::getPassword(),
            'fromDomain' => self::getFromDomain(),
            'directConnectivity' => self::getDirectConnectivity(),
            'ddiIn' => self::getDdiIn(),
            't38Passthrough' => self::getT38Passthrough(),
            'rtpEncryption' => self::getRtpEncryption(),
            'multiContact' => self::getMultiContact(),
            'ruri_domain' => self::getRuriDomain(),
            'trustSDP' => self::getTrustSDP(),
            'brandId' => self::getBrand()->getId(),
            'domainId' => self::getDomain()?->getId(),
            'companyId' => self::getCompany()->getId(),
            'transformationRuleSetId' => self::getTransformationRuleSet()?->getId(),
            'outgoingDdiId' => self::getOutgoingDdi()?->getId(),
            'proxyUserId' => self::getProxyUser()?->getId()
        ];
    }

    protected function setName(string $name): static
    {
        Assertion::maxLength($name, 65, 'name value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    protected function setDescription(string $description): static
    {
        Assertion::maxLength($description, 500, 'description value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    protected function setTransport(?string $transport = null): static
    {
        if (!is_null($transport)) {
            Assertion::maxLength($transport, 25, 'transport value "%s" is too long, it should have no more than %d characters, but has %d characters.');
            Assertion::choice(
                $transport,
                [
                    RetailAccountInterface::TRANSPORT_UDP,
                    RetailAccountInterface::TRANSPORT_TCP,
                    RetailAccountInterface::TRANSPORT_TLS,
                ],
                'transportvalue "%s" is not an element of the valid values: %s'
            );
        }

        $this->transport = $transport;

        return $this;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    protected function setIp(?string $ip = null): static
    {
        if (!is_null($ip)) {
            Assertion::maxLength($ip, 50, 'ip value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->ip = $ip;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    protected function setPort(?int $port = null): static
    {
        if (!is_null($port)) {
            Assertion::greaterOrEqualThan($port, 0, 'port provided "%s" is not greater or equal than "%s".');
        }

        $this->port = $port;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    protected function setPassword(?string $password = null): static
    {
        if (!is_null($password)) {
            Assertion::maxLength($password, 64, 'password value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    protected function setFromDomain(?string $fromDomain = null): static
    {
        if (!is_null($fromDomain)) {
            Assertion::maxLength($fromDomain, 190, 'fromDomain value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->fromDomain = $fromDomain;

        return $this;
    }

    public function getFromDomain(): ?string
    {
        return $this->fromDomain;
    }

    protected function setDirectConnectivity(string $directConnectivity): static
    {
        Assertion::choice(
            $directConnectivity,
            [
                RetailAccountInterface::DIRECTCONNECTIVITY_YES,
                RetailAccountInterface::DIRECTCONNECTIVITY_NO,
            ],
            'directConnectivityvalue "%s" is not an element of the valid values: %s'
        );

        $this->directConnectivity = $directConnectivity;

        return $this;
    }

    public function getDirectConnectivity(): string
    {
        return $this->directConnectivity;
    }

    protected function setDdiIn(string $ddiIn): static
    {
        Assertion::choice(
            $ddiIn,
            [
                RetailAccountInterface::DDIIN_YES,
                RetailAccountInterface::DDIIN_NO,
            ],
            'ddiInvalue "%s" is not an element of the valid values: %s'
        );

        $this->ddiIn = $ddiIn;

        return $this;
    }

    public function getDdiIn(): string
    {
        return $this->ddiIn;
    }

    protected function setT38Passthrough(string $t38Passthrough): static
    {
        Assertion::choice(
            $t38Passthrough,
            [
                RetailAccountInterface::T38PASSTHROUGH_YES,
                RetailAccountInterface::T38PASSTHROUGH_NO,
            ],
            't38Passthroughvalue "%s" is not an element of the valid values: %s'
        );

        $this->t38Passthrough = $t38Passthrough;

        return $this;
    }

    public function getT38Passthrough(): string
    {
        return $this->t38Passthrough;
    }

    protected function setRtpEncryption(bool $rtpEncryption): static
    {
        $this->rtpEncryption = $rtpEncryption;

        return $this;
    }

    public function getRtpEncryption(): bool
    {
        return $this->rtpEncryption;
    }

    protected function setMultiContact(bool $multiContact): static
    {
        $this->multiContact = $multiContact;

        return $this;
    }

    public function getMultiContact(): bool
    {
        return $this->multiContact;
    }

    protected function setRuriDomain(?string $ruriDomain = null): static
    {
        if (!is_null($ruriDomain)) {
            Assertion::maxLength($ruriDomain, 190, 'ruriDomain value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->ruriDomain = $ruriDomain;

        return $this;
    }

    public function getRuriDomain(): ?string
    {
        return $this->ruriDomain;
    }

    protected function setTrustSDP(bool $trustSDP): static
    {
        $this->trustSDP = $trustSDP;

        return $this;
    }

    public function getTrustSDP(): bool
    {
        return $this->trustSDP;
    }

    public function setBrand(BrandInterface $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }

    public function setDomain(?DomainInterface $domain = null): static
    {
        $this->domain = $domain;

        return $this;
    }

    public function getDomain(): ?DomainInterface
    {
        return $this->domain;
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

    protected function setTransformationRuleSet(?TransformationRuleSetInterface $transformationRuleSet = null): static
    {
        $this->transformationRuleSet = $transformationRuleSet;

        return $this;
    }

    public function getTransformationRuleSet(): ?TransformationRuleSetInterface
    {
        return $this->transformationRuleSet;
    }

    protected function setOutgoingDdi(?DdiInterface $outgoingDdi = null): static
    {
        $this->outgoingDdi = $outgoingDdi;

        return $this;
    }

    public function getOutgoingDdi(): ?DdiInterface
    {
        return $this->outgoingDdi;
    }

    protected function setProxyUser(?ProxyUserInterface $proxyUser = null): static
    {
        $this->proxyUser = $proxyUser;

        return $this;
    }

    public function getProxyUser(): ?ProxyUserInterface
    {
        return $this->proxyUser;
    }
}
