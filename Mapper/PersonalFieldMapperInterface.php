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

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface PersonalFieldMapperInterface
{
    /**
     * @return bool Check if contact must be recomputed
     */
    public function injectPersonalAccountFieldsToContact(EntityManagerInterface $em, AccountInterface $account, ContactInterface $contact): bool;

    /**
     * @return bool Check if account must be recomputed
     */
    public function injectPersonalContactFieldsToAccount(EntityManagerInterface $em, ContactInterface $contact, AccountInterface $account): bool;
}
