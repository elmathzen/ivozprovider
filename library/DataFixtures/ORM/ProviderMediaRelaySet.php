<?php

namespace DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Ivoz\Provider\Domain\Model\MediaRelaySet\MediaRelaySet;

class ProviderMediaRelaySet extends Fixture
{
    use \DataFixtures\FixtureHelperTrait;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fixture = $this;
        $this->disableLifecycleEvents($manager);
        $manager->getClassMetadata(MediaRelaySet::class)->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        $manager->getConnection()->exec(
            "INSERT INTO MediaRelaySets (id, name, description) VALUES (0, 'Default','Default media relay set')"
        );

        $item0 = $manager->find(MediaRelaySet::class, 0);
        $this->addReference('_reference_ProviderMediaRelaySet0', $item0);

        $item1 = $this->createEntityInstance(MediaRelaySet::class);
        (function () use ($fixture) {
            $this->setName("Test");
            $this->setDescription("Test media relay set");
        })->call($item1);

        $this->addReference('_reference_ProviderMediaRelaySet1', $item1);
        $this->sanitizeEntityValues($item1);
        $manager->persist($item1);

        $item2 = $this->createEntityInstance(MediaRelaySet::class);
        (function () use ($fixture) {
            $this->setName("Test 2");
            $this->setDescription("Not related with Brand 1");
        })->call($item2);

        $this->addReference('_reference_ProviderMediaRelaySet2', $item2);
        $this->sanitizeEntityValues($item2);
        $manager->persist($item2);

        $manager->flush();
    }
}
