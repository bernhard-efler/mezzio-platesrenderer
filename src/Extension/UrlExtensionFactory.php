<?php

/**
 * @see       https://github.com/mezzio/mezzio-platesrenderer for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio-platesrenderer/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio-platesrenderer/blob/master/LICENSE.md New BSD License
 */

namespace Mezzio\Plates\Extension;

use Interop\Container\ContainerInterface;
use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use Mezzio\Plates\Exception\MissingHelperException;

/**
 * Factory for creating a UrlExtension instance.
 */
class UrlExtensionFactory
{
    /**
     * @param ContainerInterface $container
     * @return UrlExtension
     * @throws MissingHelperException if UrlHelper service is missing.
     * @throws MissingHelperException if ServerUrlHelper service is missing.
     */
    public function __invoke(ContainerInterface $container)
    {
        if (! $container->has(UrlHelper::class)
            && ! $container->has(\Zend\Expressive\Helper\UrlHelper::class)
        ) {
            throw new MissingHelperException(sprintf(
                '%s requires that the %s service be present; not found',
                UrlExtension::class,
                UrlHelper::class
            ));
        }

        if (! $container->has(ServerUrlHelper::class)
            && ! $container->has(\Zend\Expressive\Helper\ServerUrlHelper::class)
        ) {
            throw new MissingHelperException(sprintf(
                '%s requires that the %s service be present; not found',
                UrlExtension::class,
                ServerUrlHelper::class
            ));
        }

        return new UrlExtension(
            $container->has(UrlHelper::class) ? $container->get(UrlHelper::class) : $container->get(\Zend\Expressive\Helper\UrlHelper::class),
            $container->has(ServerUrlHelper::class) ? $container->get(ServerUrlHelper::class) : $container->get(\Zend\Expressive\Helper\ServerUrlHelper::class)
        );
    }
}