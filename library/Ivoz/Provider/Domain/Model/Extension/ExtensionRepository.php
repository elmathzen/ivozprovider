<?php

namespace Ivoz\Provider\Domain\Model\Extension;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ObjectRepository;

interface ExtensionRepository extends ObjectRepository, Selectable
{
    /**
     * @param int $id
     * @return ExtensionInterface[]
     */
    public function findByCompanyId($id);

    /**
     * @return ExtensionInterface | null
     */
    public function findCompanyExtension(int $companyId, string $extensionNumber);

    /**
     * @param int[] | null $includeIds
     * @return ExtensionInterface[]
     */
    public function findUnassignedByCompanyId(int $companyId, ?array $includeIds, ?int $userId): array;

    /**
     * @param array<string, mixed> $criteria
     */
    public function count(array $criteria): int;
}
