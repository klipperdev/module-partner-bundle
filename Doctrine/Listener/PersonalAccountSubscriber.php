<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Module\PartnerBundle\Doctrine\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Klipper\Component\DoctrineExtra\Util\ClassUtils;
use Klipper\Module\PartnerBundle\Model\AccountInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class PersonalAccountSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $object) {
            $this->persist($em, $object, true);
        }

        foreach ($uow->getScheduledEntityUpdates() as $object) {
            $this->persist($em, $object);
        }
    }

    private function persist(EntityManagerInterface $em, object $object, bool $create = false): void
    {
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($object);

        if ($object instanceof AccountInterface && $object->isPersonalAccount()) {
            if ($create || isset($changeSet['firstName']) || isset($changeSet['lastName'])) {
                $object->setName($object->getFullName());

                if ($create) {
                    $meta = $em->getClassMetadata(ClassUtils::getClass($object));
                    $uow->recomputeSingleEntityChangeSet($meta, $object);
                }
            }
        }
    }
}
