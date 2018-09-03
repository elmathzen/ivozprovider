<?php

namespace Ivoz\Kam\Domain\Model\UsersLocationAttr;

use Ivoz\Core\Domain\Model\LoggableEntityInterface;

interface UsersLocationAttrInterface extends LoggableEntityInterface
{
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getChangeSet();

    /**
     * @deprecated
     * Set ruid
     *
     * @param string $ruid
     *
     * @return self
     */
    public function setRuid($ruid);

    /**
     * Get ruid
     *
     * @return string
     */
    public function getRuid();

    /**
     * @deprecated
     * Set username
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username);

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername();

    /**
     * @deprecated
     * Set domain
     *
     * @param string $domain
     *
     * @return self
     */
    public function setDomain($domain = null);

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain();

    /**
     * @deprecated
     * Set aname
     *
     * @param string $aname
     *
     * @return self
     */
    public function setAname($aname);

    /**
     * Get aname
     *
     * @return string
     */
    public function getAname();

    /**
     * @deprecated
     * Set atype
     *
     * @param integer $atype
     *
     * @return self
     */
    public function setAtype($atype);

    /**
     * Get atype
     *
     * @return integer
     */
    public function getAtype();

    /**
     * @deprecated
     * Set avalue
     *
     * @param string $avalue
     *
     * @return self
     */
    public function setAvalue($avalue);

    /**
     * Get avalue
     *
     * @return string
     */
    public function getAvalue();

    /**
     * @deprecated
     * Set lastModified
     *
     * @param \DateTime $lastModified
     *
     * @return self
     */
    public function setLastModified($lastModified);

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified();
}
