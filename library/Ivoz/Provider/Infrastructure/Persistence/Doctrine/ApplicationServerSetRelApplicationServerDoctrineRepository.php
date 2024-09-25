<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Ivoz\Core\Domain\Service\EntityPersisterInterface;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;
use Ivoz\Provider\Domain\Model\ApplicationServerSetRelApplicationServer\ApplicationServerSetRelApplicationServer;
use Ivoz\Provider\Domain\Model\ApplicationServerSetRelApplicationServer\ApplicationServerSetRelApplicationServerRepository;
use Ivoz\Provider\Domain\Model\ApplicationServerSetRelApplicationServer\ApplicationServerSetRelApplicationServerInterface;
use Ivoz\Provider\Domain\Model\ApplicationServerSetRelApplicationServer\ApplicationServerSetRelApplicationServerDto;

/**
 * ApplicationServerSetRelApplicationServerDoctrineRepository
 *
 * This class was generated by ivoz:make:repositories command.
 * Add your own custom repository methods below.
 *
 * @extends DoctrineRepository<ApplicationServerSetRelApplicationServerInterface, ApplicationServerSetRelApplicationServerDto>
 */
class ApplicationServerSetRelApplicationServerDoctrineRepository extends DoctrineRepository implements ApplicationServerSetRelApplicationServerRepository
{
    public function __construct(
        ManagerRegistry $registry,
        EntityPersisterInterface $entityPersisterInterface,
    ) {
        parent::__construct(
            $registry,
            ApplicationServerSetRelApplicationServer::class,
            $entityPersisterInterface
        );
    }
}
