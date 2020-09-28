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
use Klipper\Component\Model\Traits\NameableInterface;
use Klipper\Component\Model\Traits\OrganizationalRequiredInterface;
use Klipper\Component\Model\Traits\OwnerableInterface;
use Klipper\Component\Model\Traits\TimestampableInterface;
use Klipper\Component\Model\Traits\UserTrackableInterface;
use Klipper\Contracts\Model\IdInterface;

/**
 * Account interface.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface AccountInterface extends
    AddressInterface,
    IdInterface,
    NameableInterface,
    OrganizationalRequiredInterface,
    OwnerableInterface,
    TimestampableInterface,
    UserTrackableInterface
{
    public function getWebsiteUrl(): ?string;

    public function setWebsiteUrl(?string $websiteUrl): self;

    public function getEmail(): ?string;

    public function setEmail(?string $email): self;

    public function getPhone(): ?string;

    public function setPhone(?string $phone): self;

    public function getFax(): ?string;

    public function setFax(?string $fax): self;

    public function getAccountNumber(): ?string;

    public function setAccountNumber(?string $accountNumber): self;

    public function getAnnualRevenue(): ?float;

    public function setAnnualRevenue(?float $annualRevenue): self;

    public function getMasterAccount(): ?AccountInterface;

    public function setMasterAccount(?AccountInterface $masterAccount): self;

    public function getBusinessType(): ?ChoiceInterface;

    public function setBusinessType(?ChoiceInterface $businessType): self;
}
