<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Persistence\ManagerRegistry;
use Ivoz\Core\Domain\Service\EntityPersisterInterface;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Model\Helper\CriteriaHelper;
use Ivoz\Core\Infrastructure\Persistence\Doctrine\Repository\DoctrineRepository;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\Company\Company;
use Ivoz\Provider\Domain\Model\Company\CompanyDto;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\Company\CompanyRepository;

/**
 * CompanyDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @extends DoctrineRepository<CompanyInterface, CompanyDto>
 */
class CompanyDoctrineRepository extends DoctrineRepository implements CompanyRepository
{
    public function __construct(
        ManagerRegistry $registry,
        EntityPersisterInterface $entityPersisterInterface,
    ) {
        parent::__construct(
            $registry,
            Company::class,
            $entityPersisterInterface
        );
    }

    /**
     * @inheritdoc
     */
    public function findIdsByBrandId($id)
    {
        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('self.id')
            ->where(
                $expression->eq('self.brand', $id)
            );

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        return array_map(
            function ($row): int {
                return (int) $row['id'];
            },
            $result
        );
    }

    /**
     * @inheritdoc
     */
    public function findDomainIdsByBrandId(int $id): array
    {
        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('IDENTITY(self.domain) as domain')
            ->where(
                $expression->eq('self.brand', $id)
            );

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        return array_map(
            function ($row): int {
                return (int) $row['domain'];
            },
            $result
        );
    }

    /**
     * Used by brand API access controls
     * @inheritdoc
     * @see \Ivoz\Provider\Domain\Model\Company\CompanyRepository::getSupervisedCompanyIdsByAdmin
     */
    public function getSupervisedCompanyIdsByAdmin(AdministratorInterface $admin): array
    {
        if (!$admin->isBrandAdmin()) {
            throw new \DomainException('User must be brand admin');
        }

        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('self.id')
            ->where(
                $expression->eq('self.brand', $admin->getBrand()->getId())
            );

        $result = $qb->getQuery()->getScalarResult();

        return array_map(
            'intval',
            array_column(
                $result,
                'id'
            )
        );
    }

    /**
     * @inheritdoc
     * @see \Ivoz\Provider\Domain\Model\Company\CompanyRepository::getPrepaidCompanies
     */
    public function getPrepaidCompanies()
    {
        $qb = $this->createQueryBuilder('c');

        $query = $qb
            ->select('c')
            ->where(
                $qb->expr()->in('c.billingMethod', ['prepaid', 'pseudoprepaid'])
            )
            ->getQuery();

        return $query->getResult();
    }

    /**
     * @param int $brandId | null
     * @return string[]
     */
    public function getNames($brandId = null)
    {
        $qb = $this->createQueryBuilder('self');

        $qb->select('self.id, self.name');

        if ($brandId) {
            $qb->where(
                $qb->expr()->eq('self.brand', $brandId)
            );
        }

        $result = $qb
            ->select('self.id, self.name')
            ->getQuery()
            ->getScalarResult();

        $response = [];
        foreach ($result as $row) {
            $response[$row['id']] = $row['name'];
        }

        return $response;
    }

    /**
     * @return int[]
     */
    public function getVpbxIdsByBrand(int $brandId): array
    {
        return $this->getIdsByBrandAndType(
            $brandId,
            CompanyInterface::TYPE_VPBX
        );
    }

    /**
     * @return int[]
     */
    public function getResidentialIdsByBrand(int $brandId): array
    {
        return $this->getIdsByBrandAndType(
            $brandId,
            CompanyInterface::TYPE_RESIDENTIAL
        );
    }

    /**
     * @return int[]
     */
    public function getRetailIdsByBrand(int $brandId): array
    {
        return $this->getIdsByBrandAndType(
            $brandId,
            CompanyInterface::TYPE_RETAIL
        );
    }

    private function getIdsByBrandAndType(int $brandId, string $type): array
    {
        $qb = $this->createQueryBuilder('self');
        $criteria = CriteriaHelper::fromArray([
            ['brand', 'eq', $brandId],
            ['type', 'eq', $type]
        ]);

        $qb
            ->select('self.id')
            ->addCriteria($criteria);

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        return
            array_map(
                'intval',
                array_column(
                    $result,
                    'id'
                )
            );
    }

    public function findOneByDomain(string $domainUsers): ?CompanyInterface
    {
        $response = $this->findOneBy([
            'domainUsers' => $domainUsers
        ]);

        return $response;
    }

    public function findByCorporationId(int $corporationId): ?array
    {
        $response = $this->findBy([
            'corporation' => $corporationId
        ]);

        return $response;
    }

    public function getBillingEnabledCompanyIdsByBrand(int $brandId): array
    {
        $qb = $this->createQueryBuilder('self');
        $criteria = CriteriaHelper::fromArray([
            ['brand', 'eq', $brandId],
            ['billingMethod', 'neq', CompanyInterface::BILLINGMETHOD_NONE]
        ]);

        $qb
            ->select('self.id')
            ->addCriteria($criteria);

        $result = $qb
            ->getQuery()
            ->getScalarResult();

        return
            array_map(
                'intval',
                array_column(
                    $result,
                    'id'
                )
            );
    }

    /**
     * Used by brand API access controls
     * @inheritdoc
     * @see \Ivoz\Provider\Domain\Model\Company\CompanyRepository::getCompanyIdsByAdminCorporation
     */
    public function getCompanyIdsByAdminCorporation(AdministratorInterface $admin): array
    {
        if (!$admin->isVpbxAdmin()) {
            throw new \DomainException('User must be client admin');
        }

        $company = $admin->getCompany();

        if (is_null($company)) {
            // Company cannot be null
            return [];
        }

        $corporation = $company->getCorporation();

        if (is_null($corporation)) {
            // Corporation cannot be null
            return [];
        }

        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('self.id')
            ->where(
                $expression->eq(
                    'self.corporation',
                    $corporation->getId()
                )
            );

        $result = $qb->getQuery()->getScalarResult();

        return array_column($result, 'id');
    }

    /**
     * @param array<string, mixed> $criteria
     */
    public function count(array $criteria): int
    {
        return parent::count($criteria);
    }

    public function countByBrand(int $brandId): int
    {
        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('COUNT(self.id) as count')
            ->where(
                $expression->eq(
                    'self.brand',
                    $brandId
                )
            );

        $result = $qb
            ->getQuery()
            ->getSingleResult();

        return $result['count'];
    }

    /**
     * @return CompanyInterface[]
     */
    public function getLatestByBrandId(int $brandId, int $intemNum = 5): array
    {
        $qb = $this->createQueryBuilder('self');

        return $qb
            ->select('self')
            ->where(
                $qb->expr()->eq(
                    'self.brand',
                    $brandId
                )
            )
            ->orderBy('self.id', 'DESC')
            ->setMaxResults($intemNum)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return CompanyInterface[]
     */
    public function findByApplicationServerId(int $applicationServerId): array
    {
        return $this->findBy(
            [
                'applicationServer' => $applicationServerId
            ]
        );
    }
}
