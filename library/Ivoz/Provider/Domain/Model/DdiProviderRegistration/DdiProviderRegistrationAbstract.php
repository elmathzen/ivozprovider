<?php

declare(strict_types=1);

namespace Ivoz\Provider\Domain\Model\DdiProviderRegistration;

use Assert\Assertion;
use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\ChangelogTrait;
use Ivoz\Core\Domain\Model\EntityInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Provider\Domain\Model\DdiProvider\DdiProviderInterface;
use Ivoz\Provider\Domain\Model\DdiProvider\DdiProvider;

/**
* DdiProviderRegistrationAbstract
* @codeCoverageIgnore
*/
abstract class DdiProviderRegistrationAbstract
{
    use ChangelogTrait;

    /**
     * @var string
     */
    protected $username = '';

    /**
     * @var string
     */
    protected $domain = '';

    /**
     * @var string
     */
    protected $realm = '';

    /**
     * @var string
     */
    protected $authUsername = '';

    /**
     * @var string
     */
    protected $authPassword = '';

    /**
     * @var string
     */
    protected $authProxy = '';

    /**
     * @var int
     */
    protected $expires = 0;

    /**
     * @var bool | null
     */
    protected $multiDdi = false;

    /**
     * @var string
     */
    protected $contactUsername = '';

    /**
     * @var DdiProviderInterface
     * inversedBy ddiProviderRegistrations
     */
    protected $ddiProvider;

    /**
     * Constructor
     */
    protected function __construct(
        $username,
        $domain,
        $realm,
        $authUsername,
        $authPassword,
        $authProxy,
        $expires,
        $contactUsername
    ) {
        $this->setUsername($username);
        $this->setDomain($domain);
        $this->setRealm($realm);
        $this->setAuthUsername($authUsername);
        $this->setAuthPassword($authPassword);
        $this->setAuthProxy($authProxy);
        $this->setExpires($expires);
        $this->setContactUsername($contactUsername);
    }

    abstract public function getId();

    public function __toString()
    {
        return sprintf(
            "%s#%s",
            "DdiProviderRegistration",
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
     * @return DdiProviderRegistrationDto
     */
    public static function createDto($id = null)
    {
        return new DdiProviderRegistrationDto($id);
    }

    /**
     * @internal use EntityTools instead
     * @param DdiProviderRegistrationInterface|null $entity
     * @param int $depth
     * @return DdiProviderRegistrationDto|null
     */
    public static function entityToDto(EntityInterface $entity = null, $depth = 0)
    {
        if (!$entity) {
            return null;
        }

        Assertion::isInstanceOf($entity, DdiProviderRegistrationInterface::class);

        if ($depth < 1) {
            return static::createDto($entity->getId());
        }

        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy && !$entity->__isInitialized()) {
            return static::createDto($entity->getId());
        }

        /** @var DdiProviderRegistrationDto $dto */
        $dto = $entity->toDto($depth - 1);

        return $dto;
    }

    /**
     * Factory method
     * @internal use EntityTools instead
     * @param DdiProviderRegistrationDto $dto
     * @return self
     */
    public static function fromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, DdiProviderRegistrationDto::class);

        $self = new static(
            $dto->getUsername(),
            $dto->getDomain(),
            $dto->getRealm(),
            $dto->getAuthUsername(),
            $dto->getAuthPassword(),
            $dto->getAuthProxy(),
            $dto->getExpires(),
            $dto->getContactUsername()
        );

        $self
            ->setMultiDdi($dto->getMultiDdi())
            ->setDdiProvider($fkTransformer->transform($dto->getDdiProvider()));

        $self->initChangelog();

        return $self;
    }

    /**
     * @internal use EntityTools instead
     * @param DdiProviderRegistrationDto $dto
     * @return self
     */
    public function updateFromDto(
        DataTransferObjectInterface $dto,
        ForeignKeyTransformerInterface $fkTransformer
    ) {
        Assertion::isInstanceOf($dto, DdiProviderRegistrationDto::class);

        $this
            ->setUsername($dto->getUsername())
            ->setDomain($dto->getDomain())
            ->setRealm($dto->getRealm())
            ->setAuthUsername($dto->getAuthUsername())
            ->setAuthPassword($dto->getAuthPassword())
            ->setAuthProxy($dto->getAuthProxy())
            ->setExpires($dto->getExpires())
            ->setMultiDdi($dto->getMultiDdi())
            ->setContactUsername($dto->getContactUsername())
            ->setDdiProvider($fkTransformer->transform($dto->getDdiProvider()));

        return $this;
    }

    /**
     * @internal use EntityTools instead
     * @param int $depth
     * @return DdiProviderRegistrationDto
     */
    public function toDto($depth = 0)
    {
        return self::createDto()
            ->setUsername(self::getUsername())
            ->setDomain(self::getDomain())
            ->setRealm(self::getRealm())
            ->setAuthUsername(self::getAuthUsername())
            ->setAuthPassword(self::getAuthPassword())
            ->setAuthProxy(self::getAuthProxy())
            ->setExpires(self::getExpires())
            ->setMultiDdi(self::getMultiDdi())
            ->setContactUsername(self::getContactUsername())
            ->setDdiProvider(DdiProvider::entityToDto(self::getDdiProvider(), $depth));
    }

    /**
     * @return array
     */
    protected function __toArray()
    {
        return [
            'username' => self::getUsername(),
            'domain' => self::getDomain(),
            'realm' => self::getRealm(),
            'authUsername' => self::getAuthUsername(),
            'authPassword' => self::getAuthPassword(),
            'authProxy' => self::getAuthProxy(),
            'expires' => self::getExpires(),
            'multiDdi' => self::getMultiDdi(),
            'contactUsername' => self::getContactUsername(),
            'ddiProviderId' => self::getDdiProvider()->getId()
        ];
    }

    protected function setUsername(string $username): static
    {
        Assertion::maxLength($username, 64, 'username value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->username = $username;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    protected function setDomain(string $domain): static
    {
        Assertion::maxLength($domain, 190, 'domain value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->domain = $domain;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    protected function setRealm(string $realm): static
    {
        Assertion::maxLength($realm, 64, 'realm value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->realm = $realm;

        return $this;
    }

    public function getRealm(): string
    {
        return $this->realm;
    }

    protected function setAuthUsername(string $authUsername): static
    {
        Assertion::maxLength($authUsername, 64, 'authUsername value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->authUsername = $authUsername;

        return $this;
    }

    public function getAuthUsername(): string
    {
        return $this->authUsername;
    }

    protected function setAuthPassword(string $authPassword): static
    {
        Assertion::maxLength($authPassword, 64, 'authPassword value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->authPassword = $authPassword;

        return $this;
    }

    public function getAuthPassword(): string
    {
        return $this->authPassword;
    }

    protected function setAuthProxy(string $authProxy): static
    {
        Assertion::maxLength($authProxy, 64, 'authProxy value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->authProxy = $authProxy;

        return $this;
    }

    public function getAuthProxy(): string
    {
        return $this->authProxy;
    }

    protected function setExpires(int $expires): static
    {
        $this->expires = $expires;

        return $this;
    }

    public function getExpires(): int
    {
        return $this->expires;
    }

    protected function setMultiDdi(?bool $multiDdi = null): static
    {
        if (!is_null($multiDdi)) {
            Assertion::between(intval($multiDdi), 0, 1, 'multiDdi provided "%s" is not a valid boolean value.');
            $multiDdi = (bool) $multiDdi;
        }

        $this->multiDdi = $multiDdi;

        return $this;
    }

    public function getMultiDdi(): ?bool
    {
        return $this->multiDdi;
    }

    protected function setContactUsername(string $contactUsername): static
    {
        Assertion::maxLength($contactUsername, 64, 'contactUsername value "%s" is too long, it should have no more than %d characters, but has %d characters.');

        $this->contactUsername = $contactUsername;

        return $this;
    }

    public function getContactUsername(): string
    {
        return $this->contactUsername;
    }

    public function setDdiProvider(DdiProviderInterface $ddiProvider): static
    {
        $this->ddiProvider = $ddiProvider;

        /** @var  $this */
        return $this;
    }

    public function getDdiProvider(): DdiProviderInterface
    {
        return $this->ddiProvider;
    }
}
