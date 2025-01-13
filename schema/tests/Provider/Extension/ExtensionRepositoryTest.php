<?php

namespace Tests\Provider\Extension;

use Ivoz\Provider\Domain\Model\Extension\Extension;
use Ivoz\Provider\Domain\Model\Extension\ExtensionInterface;
use Ivoz\Provider\Domain\Model\Extension\ExtensionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\DbIntegrationTestHelperTrait;

class ExtensionRepositoryTest extends KernelTestCase
{
    use DbIntegrationTestHelperTrait;

    /**
     * @test
     */
    public function test_runner()
    {
        $this->its_instantiable();
        $this->it_finds_by_company_id();
        $this->it_finds_by_company_extension();
        $this->it_finds_by_companyId();
    }

    public function its_instantiable()
    {
        /** @var ExtensionRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Extension::class);

        $this->assertInstanceOf(
            ExtensionRepository::class,
            $repository
        );
    }

    public function it_finds_by_company_id()
    {
        /** @var ExtensionRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Extension::class);

        $extensions = $repository->findByCompanyId(1);

        $this->assertIsArray(
            $extensions
        );

        $this->assertInstanceOf(
            Extension::class,
            $extensions[0]
        );
    }

    public function it_finds_by_company_extension()
    {
        /** @var ExtensionRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Extension::class);

        $extensions = $repository
            ->findCompanyExtension(
                1,
                101
            );

        $this->assertInstanceOf(
            ExtensionInterface::class,
            $extensions
        );
    }

    public function it_finds_by_companyId()
    {
        /** @var ExtensionRepository $repository */
        $repository = $this
            ->em
            ->getRepository(Extension::class);

        $includedIds = [1];
        $extensions = $repository->findUnassignedByCompanyId(
            1,
            $includedIds,
            null
        );

        $this->assertIsArray($extensions);

        $this->assertInstanceOf(
            Extension::class,
            $extensions[0]
        );

        $this->assertEquals(
            $extensions[0]->getId(),
            $includedIds[0]
        );
    }
}
