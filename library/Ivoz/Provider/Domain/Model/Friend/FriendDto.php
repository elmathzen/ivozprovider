<?php

namespace Ivoz\Provider\Domain\Model\Friend;

use Ivoz\Api\Core\Annotation\AttributeDefinition;
use Ivoz\Kam\Domain\Model\UsersLocation\RegistrationStatus;

class FriendDto extends FriendDtoAbstract
{
    public const CONTEXT_STATUS = 'status';

    /**
     * @var RegistrationStatus[]
     * @AttributeDefinition(
     *     type="array",
     *     class="Ivoz\Kam\Domain\Model\UsersLocation\RegistrationStatus",
     *     description="Registration status"
     * )
     */
    private $status = [];

    /**
     * @var string
     * @AttributeDefinition(
     *     type="string",
     *     description="Registration domain"
     * )
     */
    private $domainName;

    public function addStatus(RegistrationStatus $status): static
    {
        $this->status[] = $status;

        return $this;
    }

    public function setDomainName(string $name): void
    {
        $this->domainName = $name;
    }


    public function toArray(bool $hideSensitiveData = false): array
    {
        $response = parent::toArray($hideSensitiveData);
        $response['domainName'] = $this->domainName;
        $response['status'] = array_map(
            function (RegistrationStatus $registrationStatus): array {
                return $registrationStatus->toArray();
            },
            $this->status
        );

        return $response;
    }

    /**
     * @inheritdoc
     * @codeCoverageIgnore
     */
    public static function getPropertyMap(string $context = '', string $role = null): array
    {
        if ($context === self::CONTEXT_STATUS) {
            $baseAttributes = [
                'id' => 'id',
                'name' => 'name',
                'domainName' => 'domainName',
                'status' => [[
                    'contact',
                    'received',
                    'publicReceived',
                    'expires',
                    'userAgent'
                ]]
            ];

            if ($role === 'ROLE_BRAND_ADMIN') {
                $baseAttributes['companyId'] = 'company';
            }

            return $baseAttributes;
        }

        if ($context === self::CONTEXT_COLLECTION) {
            return [
                'id' => 'id',
                'companyId' => 'company',
                'name' => 'name',
                'domainId' => 'domain',
                'description' => 'description',
                'priority' => 'priority',
                'directConnectivity' => 'directConnectivity',
                'interCompanyId' => 'interCompany'
            ];
        }

        $response = parent::getPropertyMap(...func_get_args());

        if ($role === 'ROLE_BRAND_ADMIN') {
            return self::filterFieldsForBrandAdmin($response);
        }

        if ($role === 'ROLE_COMPANY_ADMIN') {
            return self::filterFieldsForCompanyAdmin($response);
        }

        return $response;
    }

    public function denormalize(array $data, string $context, string $role = ''): void
    {
        $contextProperties = self::getPropertyMap($context, $role);
        if ($role === 'ROLE_COMPANY_ADMIN') {
            unset($contextProperties['directConnectivity']);
        }

        $this->setByContext(
            $contextProperties,
            $data
        );
    }

    private static function filterFieldsForBrandAdmin(array $response): array
    {
        $allowedFields = [
            'name',
            'description',
            'transport',
            'ip',
            'port',
            'password',
            'priority',
            'directConnectivity',
            'id',
            'companyId',
            'interCompanyId',
            'ruriDomain',
        ];

        return array_filter(
            $response,
            function ($key) use ($allowedFields): bool {
                return in_array($key, $allowedFields, true);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    private static function filterFieldsForCompanyAdmin(array $response): array
    {
        $allowedFields = [
            'name',
            'description',
            'transport',
            'ip',
            'port',
            'password',
            'priority',
            'allow',
            'fromUser',
            'fromDomain',
            'directConnectivity',
            'ddiIn',
            't38Passthrough',
            'alwaysApplyTransformations',
            'rtpEncryption',
            'multiContact',
            'id',
            'transformationRuleSetId',
            'callAclId',
            'outgoingDdiId',
            'languageId',
            'interCompanyId',
            'ruriDomain'
        ];

        return array_filter(
            $response,
            function ($key) use ($allowedFields): bool {
                return in_array($key, $allowedFields, true);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
