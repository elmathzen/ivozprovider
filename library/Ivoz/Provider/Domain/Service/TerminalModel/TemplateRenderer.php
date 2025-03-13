<?php

namespace Ivoz\Provider\Domain\Service\TerminalModel;

use Zend\ServiceManager\ServiceLocatorInterface;

class TemplateRenderer
{
    private $serviceLocator;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function render(string $templateBody, array $params = []): string
    {
        $className = 'TemplateRenderer' . md5($templateBody);

        $classDefinition = "class {$className} {
                private \$params = [];

                public function __construct(\$params)
                {
                    \$this->params = \$params;
                }

                public function __get(\$name)
                {
                    return \$this->params[\$name] ?? null;
                }

                public function getServiceLocator()
                {
                    return \$this->serviceLocator;
                }

                public function run()
                {
                    error_reporting(error_reporting() & ~E_NOTICE);
                    ?>[__TEMPLATE_BODY__]<?php
                }
            }
        ";

        $classDefinition = str_replace(
            '[__TEMPLATE_BODY__]',
            str_replace('$', '\\$', $templateBody),
            $classDefinition
        );

        eval($classDefinition);

        $instance = new $className($params);
        $instance->serviceLocator = $this->serviceLocator;

        ob_start();
        $instance->run();
        $output = ob_get_clean();

        return $output;
    }
}
