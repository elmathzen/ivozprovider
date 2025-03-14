<?php

namespace DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Ivoz\Provider\Domain\Model\Brand\Brand;
use Ivoz\Provider\Domain\Model\Brand\Logo;
use Ivoz\Provider\Domain\Model\Brand\Invoice;

class ProviderBrand extends Fixture implements DependentFixtureInterface
{
    use \DataFixtures\FixtureHelperTrait;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fixture = $this;
        $this->disableLifecycleEvents($manager);
        $manager->getClassMetadata(Brand::class)->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $item1 = $this->createEntityInstance(Brand::class);
        (function () use ($fixture) {
            $this->setName("DemoBrand");
            $this->setDomainUsers("");
            $this->setRecordingsLimitEmail("");
            $this->setRecordingsLimitMB(0);
            $this->setMaxCalls(0);
            $this->logo = new Logo(null, null, null);
            $this->invoice = new Invoice('', '', '', '', '', '', '');
            $this->setDomain($fixture->getReference('_reference_ProviderDomain6'));
            $this->setLanguage($fixture->getReference('_reference_ProviderLanguage1'));
            $this->setDefaultTimezone($fixture->getReference('_reference_ProviderTimezone145'));
            $this->setCurrency($fixture->getReference('_reference_ProviderCurrency1'));
            $this->relFeatures = new \Doctrine\Common\Collections\ArrayCollection([]);
        })->call($item1);

        $this->addReference('_reference_ProviderBrand1', $item1);
        $this->sanitizeEntityValues($item1);
        $manager->persist($item1);

        $item2 = $this->createEntityInstance(Brand::class);
        (function () use ($fixture) {
            $this->setName("Irontec_e2e");
            $this->setDomainUsers("sip.irontec.com");
            $this->setRecordingsLimitMB(0);
            $this->setMaxCalls(0);
            $this->logo = new Logo(null, null, null);
            $this->invoice = new Invoice('', '', '', '', '', '', '');
            $this->setDomain($fixture->getReference('_reference_ProviderDomain4'));
            $this->setLanguage($fixture->getReference('_reference_ProviderLanguage1'));
            $this->setDefaultTimezone($fixture->getReference('_reference_ProviderTimezone145'));
            $this->setCurrency($fixture->getReference('_reference_ProviderCurrency2'));
            $this->relFeatures = new \Doctrine\Common\Collections\ArrayCollection([]);
        })->call($item2);

        $this->addReference('_reference_ProviderBrand2', $item2);
        $this->sanitizeEntityValues($item2);
        $manager->persist($item2);

        $item3 = $this->createEntityInstance(Brand::class);
        (function () use ($fixture) {
            $this->setName("TestBrand");
            $this->setDomainUsers("sip.irontec.com");
            $this->setRecordingsLimitMB(0);
            $this->setMaxCalls(0);
            $this->logo = new Logo(null, null, null);
            $this->invoice = new Invoice('', '', '', '', '', '', '');
            $this->setDomain($fixture->getReference('_reference_ProviderDomain4'));
            $this->setLanguage($fixture->getReference('_reference_ProviderLanguage1'));
            $this->setDefaultTimezone($fixture->getReference('_reference_ProviderTimezone145'));
            $this->setCurrency($fixture->getReference('_reference_ProviderCurrency2'));
            $this->relFeatures = new \Doctrine\Common\Collections\ArrayCollection([]);
        })->call($item3);

        $this->addReference('_reference_ProviderBrand3', $item3);
        $this->sanitizeEntityValues($item3);
        $manager->persist($item3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProviderDomain::class,
            ProviderLanguage::class,
            ProviderTimezone::class,
            ProviderCurrency::class,
        );
    }
}
