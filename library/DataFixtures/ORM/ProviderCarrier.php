<?php

namespace DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Ivoz\Provider\Domain\Model\Carrier\Carrier;

class ProviderCarrier extends Fixture implements DependentFixtureInterface
{
    use \DataFixtures\FixtureHelperTrait;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fixture = $this;
        $this->disableLifecycleEvents($manager);
        $manager->getClassMetadata(Carrier::class)->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $item1 = $this->createEntityInstance(Carrier::class);
        (function () use ($fixture) {
            $this->setDescription("CarrierDescription");
            $this->setName("CarrierName");

            $this->setBrand($fixture->getReference('_reference_ProviderBrand1'));
            $this->setTransformationRuleSet($fixture->getReference('_reference_ProviderTransformationRuleSet70'));
            $this->setProxyTrunk($fixture->getReference('_reference_ProviderProxyTrunk1'));
            $this->setMediaRelaySet($fixture->getReference('_reference_ProviderMediaRelaySet0'));

            $this->sanitizeValues();
            $this->setCalculateCost(true);
            $this->initChangelog();
        })->call($item1);

        $this->addReference('_reference_ProviderCarrier1', $item1);
        $manager->persist($item1);

        $item2 = $this->createEntityInstance(Carrier::class);
        (function () use ($fixture) {
            $this->setDescription("Another carrier description");
            $this->setName("AnotherCarrierName");
            $this->setBrand($fixture->getReference('_reference_ProviderBrand1'));
            $this->setTransformationRuleSet($fixture->getReference('_reference_ProviderTransformationRuleSet70'));
            $this->setProxyTrunk($fixture->getReference('_reference_ProviderProxyTrunk2'));
            $this->setMediaRelaySet($fixture->getReference('_reference_ProviderMediaRelaySet0'));
        })->call($item2);

        $this->addReference('_reference_ProviderCarrier2', $item2);
        $this->sanitizeEntityValues($item2);
        $manager->persist($item2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProviderBrand::class,
            ProviderTransformationRuleSet::class,
            ProviderProxyTrunk::class,
        );
    }
}
