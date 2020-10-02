<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Module\PartnerBundle\Mapper;

use Doctrine\ORM\EntityManagerInterface;
use Klipper\Module\PartnerBundle\Model\AccountInterface;
use Klipper\Module\PartnerBundle\Model\ContactInterface;
use Klipper\Module\PartnerBundle\Model\PersonInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class DefaultPersonalFieldMapper implements PersonalFieldMapperInterface
{
    public function injectPersonalAccountFieldsToContact(EntityManagerInterface $em, AccountInterface $account, ContactInterface $contact): bool
    {
        return $this->injectData($account, $contact);
    }

    public function injectPersonalContactFieldsToAccount(EntityManagerInterface $em, ContactInterface $contact, AccountInterface $account): bool
    {
        return $this->injectData($contact, $account);
    }

    private function injectData(PersonInterface $source, PersonInterface $target): bool
    {
        $updated = false;

        if ($source->getSalutation() !== $target->getSalutation()) {
            $target->setSalutation($source->getSalutation());
            $updated = true;
        }

        if ($source->getFirstName() !== $target->getFirstName()) {
            $target->setFirstName($source->getFirstName());
            $updated = true;
        }

        if ($source->getLastName() !== $target->getLastName()) {
            $target->setLastName($source->getLastName());
            $updated = true;
        }

        if ($source->getEmail() !== $target->getEmail()) {
            $target->setEmail($source->getEmail());
            $updated = true;
        }

        if ($source->getPhone() !== $target->getPhone()) {
            $target->setPhone($source->getPhone());
            $updated = true;
        }

        if ($source->getMobilePhone() !== $target->getMobilePhone()) {
            $target->setMobilePhone($source->getMobilePhone());
            $updated = true;
        }

        if ($source->getFax() !== $target->getFax()) {
            $target->setFax($source->getFax());
            $updated = true;
        }

        if ($source->getWebsiteUrl() !== $target->getWebsiteUrl()) {
            $target->setWebsiteUrl($source->getWebsiteUrl());
            $updated = true;
        }

        return $updated;
    }
}
