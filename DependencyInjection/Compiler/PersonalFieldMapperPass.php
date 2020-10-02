<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Module\PartnerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class PersonalFieldMapperPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('klipper_module_partner.orm.listener.merge_personal_account')) {
            return;
        }

        $def = $container->getDefinition('klipper_module_partner.orm.listener.merge_personal_account');
        $mappers = $this->findTags($container, 'klipper_module_partner.personal_field_mapper', $def->getArgument(1));

        $def->replaceArgument(1, $mappers);
    }

    /**
     * Find and returns the services with the tag.
     *
     * @param ContainerBuilder $container The container service
     * @param string           $tag       The tag name
     * @param Reference[]      $list      The list of services
     *
     * @return Reference[]
     */
    protected function findTags(ContainerBuilder $container, string $tag, array $list): array
    {
        foreach ($this->findAndSortTaggedServices($tag, $container) as $service) {
            $list[] = $service;
        }

        return $list;
    }
}
