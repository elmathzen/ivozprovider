<?php

namespace Ivoz\Provider\Domain\Model\MediaRelaySet;

/**
 * MediaRelaySet
 */
class MediaRelaySet extends MediaRelaySetAbstract implements MediaRelaySetInterface
{
    use MediaRelaySetTrait;

    public const DEFAULT_MEDIA_RELAY_SET = 0;

    /**
     * @codeCoverageIgnore
     * @return array<string, mixed>
     */
    public function getChangeSet(): array
    {
        return parent::getChangeSet();
    }

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
