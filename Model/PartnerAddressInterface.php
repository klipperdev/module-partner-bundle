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

use Klipper\Component\DoctrineChoice\Model\ChoiceInterface;
use Klipper\Component\Geocoder\Model\Traits\AddressInterface;
use Klipper\Component\Model\Traits\EmailableInterface;
use Klipper\Component\Model\Traits\IdInterface;
use Klipper\Component\Model\Traits\OrganizationalRequiredInterface;
use Klipper\Component\Model\Traits\TimestampableInterface;
use Klipper\Component\Model\Traits\UserTrackableInterface;
use Klipper\Contracts\Model\LabelableInterface;
use Klipper\Module\PartnerBundle\Model\Traits\PartnerableInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface PartnerAddressInterface extends
    AddressInterface,
    EmailableInterface,
    IdInterface,
    LabelableInterface,
    OrganizationalRequiredInterface,
    PartnerableInterface,
    TimestampableInterface,
    UserTrackableInterface
{
    /**
     * @return static
     */
    public function setType(?ChoiceInterface $type);

    public function getType(): ?ChoiceInterface;

    /**
     * @return static
     */
    public function setReference(?string $reference);

    public function getReference(): ?string;
}
