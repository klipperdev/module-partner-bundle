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
use Klipper\Component\DoctrineExtensionsExtra\Util\ListenerUtil;
use Klipper\Component\DoctrineExtra\Util\ClassUtils;
use Klipper\Component\Resource\Object\ObjectFactoryInterface;
use Klipper\Module\PartnerBundle\Mapper\PersonalFieldMapperInterface;
use Klipper\Module\PartnerBundle\Model\AccountInterface;
use Klipper\Module\PartnerBundle\Model\ContactInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class MergePersonalAccountSubscriber implements EventSubscriber
{
    private ObjectFactoryInterface $objectFactory;

    private TranslatorInterface $translator;

    /**
     * @var PersonalFieldMapperInterface[]
     */
    private array $mappers = [];

    public function __construct(ObjectFactoryInterface $objectFactory, TranslatorInterface $translator, array $mappers = [])
    {
        $this->objectFactory = $objectFactory;
        $this->translator = $translator;

        foreach ($mappers as $mapper) {
            $this->addPersonalFieldMapper($mapper);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    public function addPersonalFieldMapper(PersonalFieldMapperInterface $mapper): void
    {
        $this->mappers[] = $mapper;
    }

    public function onFlush(OnFlushEventArgs $event): void
    {
        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $object) {
            $this->persist($em, $object);
        }

        foreach ($uow->getScheduledEntityUpdates() as $object) {
            $this->update($em, $object);
        }
    }

    private function persist(EntityManagerInterface $em, object $object): void
    {
        if ($object instanceof AccountInterface) {
            if ($object->isPersonalAccount()) {
                if (null === $personalContact = $object->getPersonalContact()) {
                    /** @var ContactInterface $personalContact */
                    $personalContact = $this->objectFactory->create(ContactInterface::class);
                    $em->persist($personalContact);
                    $object->setPersonalContact($personalContact);
                }

                $this->updatePersonalContact($em, $object, $personalContact);
            } elseif (null !== $object->getPersonalContact()) {
                ListenerUtil::thrownError($this->translator->trans('klipper_partner.orm_listener.account.enterprise_account_cannot_attached_personal_contact', [], 'validators'), $object);
            }
        } elseif ($object instanceof ContactInterface) {
            if (null !== $object->getPersonalAccount() && !$object->getPersonalAccount()->isPersonalAccount()) {
                ListenerUtil::thrownError($this->translator->trans('klipper_partner.orm_listener.contact.personal_contact_cannot_attached_enterprise_account', [], 'validators'), $object);
            }
        }
    }

    private function update(EntityManagerInterface $em, object $object): void
    {
        $uow = $em->getUnitOfWork();
        $changeSet = $uow->getEntityChangeSet($object);

        if ($object instanceof AccountInterface) {
            if (isset($changeSet['personalAccount'])) {
                if ($changeSet['personalAccount'][0] && !$changeSet['personalAccount'][1]) {
                    ListenerUtil::thrownError($this->translator->trans('klipper_partner.orm_listener.account.personal_account_conversion_invalid', [], 'validators'), $object);
                }

                if (!$changeSet['personalAccount'][0] && $changeSet['personalAccount'][1]) {
                    ListenerUtil::thrownError($this->translator->trans('klipper_partner.orm_listener.account.enterprise_account_conversion_invalid', [], 'validators'), $object);
                }
            }

            if ($object->isPersonalAccount()) {
                if (isset($changeSet['personalContact']) && null !== $changeSet['personalContact'][0] && null === $changeSet['personalContact'][1]) {
                    ListenerUtil::thrownError($this->translator->trans('klipper_partner.orm_listener.contact.personal_account_detached_invalid', [], 'validators'), $object);
                }

                if (null !== $personalContact = $object->getPersonalContact()) {
                    $this->updatePersonalContact($em, $object, $personalContact);
                }
            }
        } elseif ($object instanceof ContactInterface) {
            if (isset($changeSet['personalAccount']) && null === $changeSet['personalAccount'][0] && null !== $changeSet['personalAccount'][1]) {
                ListenerUtil::thrownError($this->translator->trans('klipper_partner.orm_listener.contact.personal_account_conversion_invalid', [], 'validators'), $object);
            }

            if (null !== $personalAccount = $object->getPersonalAccount()) {
                $this->updatePersonalAccount($em, $object, $personalAccount);
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

            if ($uow->getEntityChangeSet($contact)) {
                $uow->recomputeSingleEntityChangeSet($meta, $contact);
            } else {
                $uow->computeChangeSet($meta, $contact);
            }
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

            if ($uow->getEntityChangeSet($contact)) {
                $uow->recomputeSingleEntityChangeSet($meta, $account);
            } else {
                $uow->computeChangeSet($meta, $account);
            }
        }
    }
}
