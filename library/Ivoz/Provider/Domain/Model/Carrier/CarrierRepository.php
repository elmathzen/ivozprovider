<?php

namespace Ivoz\Provider\Domain\Model\Carrier;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Persistence\ObjectRepository;
use Ivoz\Provider\Domain\Model\Administrator\AdministratorInterface;
use Ivoz\Provider\Domain\Model\Brand\BrandInterface;
use Ivoz\Provider\Domain\Model\ProxyTrunk\ProxyTrunkInterface;

interface CarrierRepository extends ObjectRepository, Selectable
{
    /**
     * @return array
     */
    public function getCarrierIdsWithCalculatecostGroupByBrand();

    /**
     * @return array<array-key, int>
     */
    public function getCarrierIdsByBrandAdmin(AdministratorInterface $admin): array;
    /**
     * @param BrandInterface $brand
     * @param ProxyTrunkInterface $proxyTrunks
     * @return array|CarrierInterface[]
     */
    public function findByBrandAndProxyTrunks(BrandInterface $brand, ProxyTrunkInterface $proxyTrunks);

    /**
     * @param ProxyTrunkInterface $proxyTrunks
     * @return mixed
     */
    public function findByProxyTrunks(ProxyTrunkInterface $proxyTrunks);

    /**
     * @param int $brandId | null
     * @return string[]
     */
    public function getNames($brandId = null);


    public function countByBrand(int $brandId): int;

    /**
     * @return CarrierInterface[]
     */
    public function findByMediaRelaySetIdAndBrandId(int $mediaRelaySetId, int $brandId): array;
}
