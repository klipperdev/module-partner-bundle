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
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Klipper\Component\DoctrineExtensionsExtra\Util\ListenerUtil;
use Klipper\Component\DoctrineExtra\Util\ClassUtils;
use Klipper\Component\Resource\Object\ObjectFactoryInterface;
use Klipper\Module\PartnerBundle\Mapper\PersonalFieldMapperInterface;
use Klipper\Module\PartnerBundle\Model\AccountInterface;
use Klipper\Module\PartnerBundle\Model\ContactInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class MergePersonalAccountSubscriber implements EventSubscriber
{
    private ObjectFactoryInterface $objectFactory;

    /**
     * @var PersonalFieldMapperInterface[]
     */
    private array $mappers = [];

    public function __construct(ObjectFactoryInterface $objectFactory, array $mappers = [])
    {
        $this->objectFactory = $objectFactory;

        foreach ($mappers as $mapper) {
            $this->addPersonalFieldMapper($mapper);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function addPersonalFieldMapper(PersonalFieldMapperInterface $mapper): void
    {
        $this->mappers[] = $mapper;
    }

    public function prePersist(LifecycleEventArgs $event): void
    {
        $object = $event->getObject();

        if ($object instanceof AccountInterface) {
            if ($object->isPersonalAccount()) {
                if (null === $personalContact = $object->getPersonalContact()) {
                    /** @var ContactInterface $personalContact */
                    $personalContact = $this->objectFactory->create(ContactInterface::class);
                    $object->setPersonalContact($personalContact);
                }

                $this->updatePersonalContact($event->getEntityManager(), $object, $personalContact);
            } elseif (null !== $object->getPersonalContact()) {
                ListenerUtil::thrownError('klipper_partner.orm_listener.account.enterprise_account_cannot_attached_personal_contact', $object);
            }
        } elseif ($object instanceof ContactInterface) {
            if (null !== $object->getPersonalAccount() && !$object->getPersonalAccount()->isPersonalAccount()) {
                ListenerUtil::thrownError('klipper_partner.orm_listener.contact.personal_contact_cannot_attached_enterprise_account', $object);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $event): void
    {
        $object = $event->getObject();
        $om = $event->getEntityManager();
        $uow = $om->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($object);

        if ($object instanceof AccountInterface) {
            if (isset($changeSet['personalAccount'])) {
                if ($changeSet['personalAccount'][0] && !$changeSet['personalAccount'][1]) {
                    ListenerUtil::thrownError('klipper_partner.orm_listener.account.personal_account_conversion_invalid', $object);
                }

                if (!$changeSet['personalAccount'][0] && $changeSet['personalAccount'][1]) {
                    ListenerUtil::thrownError('klipper_partner.orm_listener.account.enterprise_account_conversion_invalid', $object);
                }
            }

            if ($object->isPersonalAccount()) {
                if (isset($changeSet['personalContact']) && null !== $changeSet['personalContact'][0] && null === $changeSet['personalContact'][1]) {
                    ListenerUtil::thrownError('klipper_partner.orm_listener.contact.personal_account_detached_invalid', $object);
                }

                if (null !== $personalContact = $object->getPersonalContact()) {
                    $this->updatePersonalContact($om, $object, $personalContact);
                }
            }
        } elseif ($object instanceof ContactInterface) {
            if (isset($changeSet['personalAccount']) && null === $changeSet['personalAccount'][0] && null !== $changeSet['personalAccount'][1]) {
                ListenerUtil::thrownError('klipper_partner.orm_listener.contact.personal_account_conversion_invalid', $object);
            }

            if (null !== $personalAccount = $object->getPersonalAccount()) {
                $this->updatePersonalAccount($om, $object, $personalAccount);
            }
        }
    }

    private function updatePersonalContact(EntityManagerInterface $em, AccountInterface $account, ContactInterface $contact): void
    {
        $uow = $em->getUnitOfWork();
        $personalUpdated = false;

        foreach ($this->mappers as $mapper) {
            $res = $mapper->injectPersonalAccountFieldsToContact($em, $account, $contact);
            $personalUpdated = $personalUpdated || $res;
        }

        if ($personalUpdated) {
            $meta = $em->getClassMetadata(ClassUtils::getClass($contact));
            $uow->recomputeSingleEntityChangeSet($meta, $contact);
        }
    }

    private function updatePersonalAccount(EntityManagerInterface $em, ContactInterface $contact, AccountInterface $account): void
    {
        $uow = $em->getUnitOfWork();
        $personalUpdated = false;

        foreach ($this->mappers as $mapper) {
            $res = $mapper->injectPersonalContactFieldsToAccount($em, $contact, $account);
            $personalUpdated = $personalUpdated || $res;
        }

        if ($personalUpdated) {
            $meta = $em->getClassMetadata(ClassUtils::getClass($account));
            $uow->recomputeSingleEntityChangeSet($meta, $account);
        }
    }
}
