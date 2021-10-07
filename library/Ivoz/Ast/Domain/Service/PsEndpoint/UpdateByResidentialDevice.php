<?php

namespace Ivoz\Ast\Domain\Service\PsEndpoint;

use Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpoint;
use Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpointDto;
use Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpointRepository;
use Ivoz\Core\Application\Service\EntityTools;
use Ivoz\Provider\Domain\Model\ResidentialDevice\ResidentialDeviceInterface;
use Ivoz\Provider\Domain\Service\ResidentialDevice\ResidentialDeviceLifecycleEventHandlerInterface;

class UpdateByResidentialDevice implements ResidentialDeviceLifecycleEventHandlerInterface
{
    public function __construct(
        private EntityTools $entityTools,
        private PsEndpointRepository $psEndpointRepository
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            self::EVENT_POST_PERSIST => 10
        ];
    }

    /**
     * @param ResidentialDeviceInterface $entity
     *
     * @return void
     */
    public function execute(ResidentialDeviceInterface $entity)
    {
        $endpoint = $this->psEndpointRepository->findOneByResidentialDeviceId(
            $entity->getId()
        );

        // If not found create a new one
        if (is_null($endpoint)) {
            $endpointDto = PsEndpoint::createDto();
            $endpointDto
                ->setContext('residential')
                ->setSendDiversion('yes')
                ->setSendPai('yes');
        } else {
            // @todo use entityTools here
            /** @var PsEndpointDto $endpointDto */
            $endpointDto  = $endpoint->toDto();
        }

        // Use company domain if residential device from-domain not set
        $fromDomain = $entity->getFromDomain()
            ? $entity->getFromDomain()
            : $entity->getDomain()->getDomain();

        // Update/Insert endpoint data
        $endpointDto
            ->setResidentialDeviceId($entity->getId())
            ->setSorceryId($entity->getSorcery())
            ->setFromDomain($fromDomain)
            ->setAors($entity->getSorcery())
            ->setDisallow($entity->getDisallow())
            ->setAllow($entity->getAllow())
            ->setDirectmediaMethod($entity->getDirectmediaMethod())
            ->setTrustIdInbound('yes')
            ->setOutboundProxy('sip:users.ivozprovider.local^3Blr')
            ->setT38Udptl($entity->getT38Passthrough())
            ->setMailboxes($entity->getVoiceMail())
            ->setDirectMediaMethod('invite');

        // Disable direct media for T.38 capable devices
        if ($entity->getT38Passthrough() === ResidentialDeviceInterface::T38PASSTHROUGH_YES) {
            $endpointDto->setDirectMedia('no');
        } else {
            $endpointDto->setDirectMedia('yes');
        }

        $this->entityTools->persistDto($endpointDto, $endpoint);
    }
}
