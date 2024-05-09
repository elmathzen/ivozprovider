<?php

namespace Ivoz\Provider\Domain\Model\RetailAccount;

use Assert\Assertion;
use Doctrine\Common\Collections\Criteria;

/**
 * RetailAccount
 */
class RetailAccount extends RetailAccountAbstract implements RetailAccountInterface
{
    use RetailAccountTrait;

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet()
    {
        return parent::getChangeSet();
    }

    /**
     * Get id
     * @codeCoverageIgnore
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    protected function sanitizeValues()
    {
        $this->setDomain(
            $this
                ->getCompany()
                ->getBrand()
                ->getDomain()
        );

        if ($this->isDirectConnectivity()) {
            if (!$this->getTransport()) {
                throw new \DomainException('Invalid empty transport');
            }

            $hasIpPort = $this->getIp() && $this->getPort();
            if (!$this->getRuriDomain() && !$hasIpPort) {
                throw new \DomainException('R-URI or IP + port must be provided');
            }
        } else {
            if (!$this->getPassword()) {
                throw new \DomainException('Password cannot be empty for retail accounts with no direct connectivity');
            }

            $this->setRuriDomain(null);
            $this->setIp(null);
            $this->setPort(null);
        }

        if ($this->getIp() && !$this->getPort()) {
            throw new \DomainException('Invalid empty port');
        }

        if ($this->getPort() && !$this->getIp()) {
            throw new \DomainException('Invalid empty IP');
        }
    }

    /**
     * @return bool
     */
    public function isDirectConnectivity() : bool
    {
        return $this->getDirectConnectivity() === self::DIRECTCONNECTIVITY_YES;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        Assertion::regex($name, '/^[a-zA-Z0-9_*]+$/');
        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function setIp($ip = null)
    {
        if (!empty($ip)) {
            Assertion::ip($ip);
        } else {
            $ip = null;
        }

        return parent::setIp($ip);
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password = null)
    {
        $password = trim($password);

        if (empty($password)) {
            return parent::setPassword(null);
        }

        Assertion::regex(
            $password,
            '/^(?=.*[A-Z].*[A-Z].*[A-Z])(?=.*[+*_-])(?=.*[0-9].*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{10,}$/'
        );

        return parent::setPassword($password);
    }

    public function setPort($port = null)
    {
        if (!empty($port)) {
            Assertion::lessThan($port, pow(2, 16), 'port provided "%s" is not lower than "%s".');
        } else {
            $port = null;
        }

        return parent::setPort($port);
    }

    /**
     * @return \Ivoz\Ast\Domain\Model\PsEndpoint\PsEndpointInterface|mixed
     */
    public function getAstPsEndpoint()
    {
        $astPsEnpoints = $this->getPsEndpoints(
            Criteria::create()->setMaxResults(1)
        );

        return current($astPsEnpoints);
    }

    /*
     * {@inheritDoc}
     */
    public function setRuriDomain($ruriDomain = null)
    {
        if (empty($ruriDomain)) {
            $ruriDomain = null;
        } else {
            Assertion::regex($ruriDomain, '/^[^\s]*$/');
        }

        return parent::setRuriDomain($ruriDomain);
    }

    /**
     * @return string
     */
    public function getSorcery()
    {
        return sprintf(
            "b%dc%drt%d_%s",
            $this->getCompany()->getBrand()->getId(),
            $this->getCompany()->getId(),
            $this->getId(),
            $this->getName()
        );
    }

    /**
     * Get Ddi associated with this retail Account
     *
     * @param string $ddieE164
     * @return \Ivoz\Provider\Domain\Model\Ddi\DdiInterface | null
     */
    public function getDdi($ddieE164)
    {
        $criteria = new Criteria();

        if ($ddieE164) {
            $criteria->where(
                Criteria::expr()->eq(
                    'ddie164',
                    $ddieE164
                )
            );
        }

        $ddis = $this->getDdis($criteria);


        return array_shift($ddis);
    }
}
