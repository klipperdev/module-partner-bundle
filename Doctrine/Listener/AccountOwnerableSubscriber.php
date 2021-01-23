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
use Klipper\Component\Security\Model\UserInterface;
use Klipper\Module\PartnerBundle\Model\Traits\AccountOwnerableInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class AccountOwnerableSubscriber implements EventSubscriber
{
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

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

        if ($object instanceof AccountOwnerableInterface) {
            $edit = false;

            if (null === $object->getOwner()) {
                if (null !== $object->getAccount() && null !== $accountOwner = $object->getAccount()->getOwner()) {
                    $object->setOwner($accountOwner);
                    $edit = true;
                } else {
                    $token = $this->tokenStorage->getToken();
                    $user = null !== $token ? $token->getUser() : null;

                    if ($user instanceof UserInterface) {
                        $object->setOwner($user);
                        $edit = true;
                    }
                }
            }

            if ($create && $edit) {
                $meta = $em->getClassMetadata(ClassUtils::getClass($object));
                $uow->recomputeSingleEntityChangeSet($meta, $object);
            }
        }
    }
}
