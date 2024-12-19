<?php

namespace Ivoz\Kam\Domain\Model\Dispatcher;

use Ivoz\Core\Domain\DataTransferObjectInterface;
use Ivoz\Core\Domain\Model\DtoNormalizer;
use Ivoz\Provider\Domain\Model\ApplicationServerSetRelApplicationServer\ApplicationServerSetRelApplicationServerDto;

/**
* DispatcherDtoAbstract
* @codeCoverageIgnore
*/
abstract class DispatcherDtoAbstract implements DataTransferObjectInterface
{
    use DtoNormalizer;

    /**
     * @var int|null
     */
    private $setid = 0;

    /**
     * @var string|null
     */
    private $destination = '';

    /**
     * @var int|null
     */
    private $flags = 0;

    /**
     * @var int|null
     */
    private $priority = 0;

    /**
     * @var string|null
     */
    private $attrs = '';

    /**
     * @var string|null
     */
    private $description = '';

    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var ApplicationServerSetRelApplicationServerDto | null
     */
    private $applicationServerSetRelApplicationServer = null;

    public function __construct(?int $id = null)
    {
        $this->setId($id);
    }

    /**
    * @inheritdoc
    */
    public static function getPropertyMap(string $context = '', string $role = null): array
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'setid' => 'setid',
            'destination' => 'destination',
            'flags' => 'flags',
            'priority' => 'priority',
            'attrs' => 'attrs',
            'description' => 'description',
            'id' => 'id',
            'applicationServerSetRelApplicationServerId' => 'applicationServerSetRelApplicationServer'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = [
            'setid' => $this->getSetid(),
            'destination' => $this->getDestination(),
            'flags' => $this->getFlags(),
            'priority' => $this->getPriority(),
            'attrs' => $this->getAttrs(),
            'description' => $this->getDescription(),
            'id' => $this->getId(),
            'applicationServerSetRelApplicationServer' => $this->getApplicationServerSetRelApplicationServer()
        ];

        if (!$hideSensitiveData) {
            return $response;
        }

        foreach ($this->sensitiveFields as $sensitiveField) {
            if (!array_key_exists($sensitiveField, $response)) {
                throw new \Exception($sensitiveField . ' field was not found');
            }
            $response[$sensitiveField] = '*****';
        }

        return $response;
    }

    public function setSetid(int $setid): static
    {
        $this->setid = $setid;

        return $this;
    }

    public function getSetid(): ?int
    {
        return $this->setid;
    }

    public function setDestination(string $destination): static
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setFlags(int $flags): static
    {
        $this->flags = $flags;

        return $this;
    }

    public function getFlags(): ?int
    {
        return $this->flags;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setAttrs(string $attrs): static
    {
        $this->attrs = $attrs;

        return $this;
    }

    public function getAttrs(): ?string
    {
        return $this->attrs;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param int|null $id
     */
    public function setId($id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setApplicationServerSetRelApplicationServer(?ApplicationServerSetRelApplicationServerDto $applicationServerSetRelApplicationServer): static
    {
        $this->applicationServerSetRelApplicationServer = $applicationServerSetRelApplicationServer;

        return $this;
    }

    public function getApplicationServerSetRelApplicationServer(): ?ApplicationServerSetRelApplicationServerDto
    {
        return $this->applicationServerSetRelApplicationServer;
    }

    public function setApplicationServerSetRelApplicationServerId(?int $id): static
    {
        $value = !is_null($id)
            ? new ApplicationServerSetRelApplicationServerDto($id)
            : null;

        return $this->setApplicationServerSetRelApplicationServer($value);
    }

    public function getApplicationServerSetRelApplicationServerId(): ?int
    {
        if ($dto = $this->getApplicationServerSetRelApplicationServer()) {
            return $dto->getId();
        }

        return null;
    }
}
