<?php

namespace MailPoetGenerated;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerInterface;
use MailPoetVendor\Symfony\Component\DependencyInjection\Container;
use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\LogicException;
use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\RuntimeException;
use MailPoetVendor\Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class PremiumCachedContainer extends Container
{
    private $parameters = [];
    private $targetDirs = [];

    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services = [];
        $this->normalizedIds = [
            'mailpoet\\config\\accesscontrol' => 'MailPoet\\Config\\AccessControl',
            'mailpoet\\config\\renderer' => 'MailPoet\\Config\\Renderer',
            'mailpoet\\features\\featurescontroller' => 'MailPoet\\Features\\FeaturesController',
            'mailpoet\\listing\\pagelimit' => 'MailPoet\\Listing\\PageLimit',
            'mailpoet\\premium\\api\\json\\v1\\stats' => 'MailPoet\\Premium\\API\\JSON\\v1\\Stats',
            'mailpoet\\premium\\config\\hooks' => 'MailPoet\\Premium\\Config\\Hooks',
            'mailpoet\\premium\\config\\initializer' => 'MailPoet\\Premium\\Config\\Initializer',
            'mailpoet\\premium\\config\\renderer' => 'MailPoet\\Premium\\Config\\Renderer',
            'mailpoet\\premium\\newsletter\\stats\\purchasedproducts' => 'MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts',
            'mailpoet\\woocommerce\\helper' => 'MailPoet\\WooCommerce\\Helper',
            'mailpoet\\wp\\functions' => 'MailPoet\\WP\\Functions',
        ];
        $this->syntheticIds = [
            'free_container' => true,
        ];
        $this->methodMap = [
            'MailPoet\\Config\\AccessControl' => 'getAccessControlService',
            'MailPoet\\Config\\Renderer' => 'getRendererService',
            'MailPoet\\Features\\FeaturesController' => 'getFeaturesControllerService',
            'MailPoet\\Listing\\PageLimit' => 'getPageLimitService',
            'MailPoet\\Premium\\API\\JSON\\v1\\Stats' => 'getStatsService',
            'MailPoet\\Premium\\Config\\Hooks' => 'getHooksService',
            'MailPoet\\Premium\\Config\\Initializer' => 'getInitializerService',
            'MailPoet\\Premium\\Config\\Renderer' => 'getRenderer2Service',
            'MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts' => 'getPurchasedProductsService',
            'MailPoet\\WP\\Functions' => 'getFunctionsService',
            'MailPoet\\WooCommerce\\Helper' => 'getHelperService',
        ];
        $this->privates = [
            'MailPoet\\Premium\\Config\\Hooks' => true,
            'MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts' => true,
        ];

        $this->aliases = [];
    }

    public function getRemovedIds()
    {
        return [
            'MailPoetVendor\\Psr\\Container\\ContainerInterface' => true,
            'MailPoetVendor\\Symfony\\Component\\DependencyInjection\\ContainerInterface' => true,
            'MailPoet\\Premium\\Config\\Hooks' => true,
            'MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts' => true,
        ];
    }

    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled()
    {
        return true;
    }

    public function isFrozen()
    {
        @trigger_error(sprintf('The %s() method is deprecated since Symfony 3.3 and will be removed in 4.0. Use the isCompiled() method instead.', __METHOD__), E_USER_DEPRECATED);

        return true;
    }

    /**
     * Gets the public 'MailPoet\Config\AccessControl' shared service.
     *
     * @return \MailPoet\Config\AccessControl
     */
    protected function getAccessControlService()
    {
        return $this->services['MailPoet\\Config\\AccessControl'] = ${($_ = isset($this->services['free_container']) ? $this->services['free_container'] : $this->get('free_container', 1)) && false ?: '_'}->get('MailPoet\\Config\\AccessControl');
    }

    /**
     * Gets the public 'MailPoet\Config\Renderer' shared service.
     *
     * @return \MailPoet\Config\Renderer
     */
    protected function getRendererService()
    {
        return $this->services['MailPoet\\Config\\Renderer'] = ${($_ = isset($this->services['free_container']) ? $this->services['free_container'] : $this->get('free_container', 1)) && false ?: '_'}->get('MailPoet\\Config\\Renderer');
    }

    /**
     * Gets the public 'MailPoet\Features\FeaturesController' shared service.
     *
     * @return \MailPoet\Features\FeaturesController
     */
    protected function getFeaturesControllerService()
    {
        return $this->services['MailPoet\\Features\\FeaturesController'] = ${($_ = isset($this->services['free_container']) ? $this->services['free_container'] : $this->get('free_container', 1)) && false ?: '_'}->get('MailPoet\\Features\\FeaturesController');
    }

    /**
     * Gets the public 'MailPoet\Listing\PageLimit' shared service.
     *
     * @return \MailPoet\Listing\PageLimit
     */
    protected function getPageLimitService()
    {
        return $this->services['MailPoet\\Listing\\PageLimit'] = ${($_ = isset($this->services['free_container']) ? $this->services['free_container'] : $this->get('free_container', 1)) && false ?: '_'}->get('MailPoet\\Listing\\PageLimit');
    }

    /**
     * Gets the public 'MailPoet\Premium\API\JSON\v1\Stats' shared autowired service.
     *
     * @return \MailPoet\Premium\API\JSON\v1\Stats
     */
    protected function getStatsService()
    {
        return $this->services['MailPoet\\Premium\\API\\JSON\\v1\\Stats'] = new \MailPoet\Premium\API\JSON\v1\Stats(${($_ = isset($this->services['MailPoet\\WooCommerce\\Helper']) ? $this->services['MailPoet\\WooCommerce\\Helper'] : $this->getHelperService()) && false ?: '_'}, ${($_ = isset($this->services['MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts']) ? $this->services['MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts'] : $this->getPurchasedProductsService()) && false ?: '_'});
    }

    /**
     * Gets the public 'MailPoet\Premium\Config\Initializer' shared autowired service.
     *
     * @return \MailPoet\Premium\Config\Initializer
     */
    protected function getInitializerService()
    {
        return $this->services['MailPoet\\Premium\\Config\\Initializer'] = new \MailPoet\Premium\Config\Initializer(${($_ = isset($this->services['MailPoet\\WP\\Functions']) ? $this->services['MailPoet\\WP\\Functions'] : $this->getFunctionsService()) && false ?: '_'}, ${($_ = isset($this->services['MailPoet\\Premium\\Config\\Hooks']) ? $this->services['MailPoet\\Premium\\Config\\Hooks'] : $this->getHooksService()) && false ?: '_'});
    }

    /**
     * Gets the public 'MailPoet\Premium\Config\Renderer' shared service.
     *
     * @return \MailPoet\Premium\Config\Renderer
     */
    protected function getRenderer2Service()
    {
        return $this->services['MailPoet\\Premium\\Config\\Renderer'] = \MailPoet\Premium\DI\ContainerConfigurator::createRenderer();
    }

    /**
     * Gets the public 'MailPoet\WP\Functions' shared service.
     *
     * @return \MailPoet\WP\Functions
     */
    protected function getFunctionsService()
    {
        return $this->services['MailPoet\\WP\\Functions'] = ${($_ = isset($this->services['free_container']) ? $this->services['free_container'] : $this->get('free_container', 1)) && false ?: '_'}->get('MailPoet\\WP\\Functions');
    }

    /**
     * Gets the public 'MailPoet\WooCommerce\Helper' shared service.
     *
     * @return \MailPoet\WooCommerce\Helper
     */
    protected function getHelperService()
    {
        return $this->services['MailPoet\\WooCommerce\\Helper'] = ${($_ = isset($this->services['free_container']) ? $this->services['free_container'] : $this->get('free_container', 1)) && false ?: '_'}->get('MailPoet\\WooCommerce\\Helper');
    }

    /**
     * Gets the private 'MailPoet\Premium\Config\Hooks' shared autowired service.
     *
     * @return \MailPoet\Premium\Config\Hooks
     */
    protected function getHooksService()
    {
        return $this->services['MailPoet\\Premium\\Config\\Hooks'] = new \MailPoet\Premium\Config\Hooks(${($_ = isset($this->services['MailPoet\\WP\\Functions']) ? $this->services['MailPoet\\WP\\Functions'] : $this->getFunctionsService()) && false ?: '_'});
    }

    /**
     * Gets the private 'MailPoet\Premium\Newsletter\Stats\PurchasedProducts' shared autowired service.
     *
     * @return \MailPoet\Premium\Newsletter\Stats\PurchasedProducts
     */
    protected function getPurchasedProductsService()
    {
        return $this->services['MailPoet\\Premium\\Newsletter\\Stats\\PurchasedProducts'] = new \MailPoet\Premium\Newsletter\Stats\PurchasedProducts(${($_ = isset($this->services['MailPoet\\WooCommerce\\Helper']) ? $this->services['MailPoet\\WooCommerce\\Helper'] : $this->getHelperService()) && false ?: '_'}, ${($_ = isset($this->services['MailPoet\\WP\\Functions']) ? $this->services['MailPoet\\WP\\Functions'] : $this->getFunctionsService()) && false ?: '_'});
    }

    public function getParameter($name)
    {
        $name = (string) $name;
        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            $name = $this->normalizeParameterName($name);

            if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
                throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
            }
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name)
    {
        $name = (string) $name;
        $name = $this->normalizeParameterName($name);

        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = [];
    private $dynamicParameters = [];

    /**
     * Computes a dynamic parameter.
     *
     * @param string $name The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
    }

    private $normalizedParameterNames = [];

    private function normalizeParameterName($name)
    {
        if (isset($this->normalizedParameterNames[$normalizedName = strtolower($name)]) || isset($this->parameters[$normalizedName]) || array_key_exists($normalizedName, $this->parameters)) {
            $normalizedName = isset($this->normalizedParameterNames[$normalizedName]) ? $this->normalizedParameterNames[$normalizedName] : $normalizedName;
            if ((string) $name !== $normalizedName) {
                @trigger_error(sprintf('Parameter names will be made case sensitive in Symfony 4.0. Using "%s" instead of "%s" is deprecated since Symfony 3.4.', $name, $normalizedName), E_USER_DEPRECATED);
            }
        } else {
            $normalizedName = $this->normalizedParameterNames[$normalizedName] = (string) $name;
        }

        return $normalizedName;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return [
            'container.autowiring.strict_mode' => true,
        ];
    }
}
