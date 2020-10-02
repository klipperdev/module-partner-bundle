<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Module\PartnerBundle\Model;

use Klipper\Component\Model\Traits\IdInterface;
use Klipper\Component\Model\Traits\OrganizationalRequiredInterface;
use Klipper\Component\Model\Traits\OwnerableInterface;
use Klipper\Component\Model\Traits\TimestampableInterface;
use Klipper\Component\Model\Traits\UserTrackableInterface;
use Klipper\Module\PartnerBundle\Model\Traits\AccountableRequiredInterface;

/**
 * Contact interface.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface ContactInterface extends
    AccountableRequiredInterface,
    IdInterface,
    OrganizationalRequiredInterface,
    OwnerableInterface,
    PersonInterface,
    TimestampableInterface,
    UserTrackableInterface
{
    /**
     * @return static
     */
    public function setPersonalAccount(?AccountInterface $personalAccount);

    public function getPersonalAccount(): ?AccountInterface;
}
