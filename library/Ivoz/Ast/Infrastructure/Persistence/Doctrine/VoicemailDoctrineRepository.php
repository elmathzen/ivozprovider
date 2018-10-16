<?php

namespace Ivoz\Ast\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Ast\Domain\Model\Voicemail\VoicemailRepository;
use Ivoz\Ast\Domain\Model\Voicemail\Voicemail;
use Ivoz\Ast\Domain\Model\Voicemail\VoicemailInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * VoicemailDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VoicemailDoctrineRepository extends ServiceEntityRepository implements VoicemailRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Voicemail::class);
    }

    /**
     * @param $id
     * @return VoicemailInterface
     */
    public function findOneByUserId($id)
    {
        /** @var VoicemailInterface $response */
        $response = $this->findOneBy([
            'user' => $id
        ]);

        return $response;
    }
}
