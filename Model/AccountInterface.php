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
use Klipper\Component\Model\Traits\IdInterface;
use Klipper\Component\Model\Traits\OrganizationalRequiredInterface;
use Klipper\Component\Model\Traits\OwnerableInterface;
use Klipper\Component\Model\Traits\TimestampableInterface;
use Klipper\Component\Model\Traits\UserTrackableInterface;

/**
 * Account interface.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface AccountInterface extends
    AddressInterface,
    CompanyInterface,
    IdInterface,
    OrganizationalRequiredInterface,
    OwnerableInterface,
    PersonInterface,
    TimestampableInterface,
    UserTrackableInterface
{
    public function isPersonalAccount(): ?bool;

    /**
     * @return static
     */
    public function setPersonalAccount(bool $personalAccount);

    public function getAccountNumber(): ?string;

    /**
     * @return static
     */
    public function setPersonalContact(?ContactInterface $personalContact);

    public function getPersonalContact(): ?ContactInterface;

    /**
     * @return static
     */
    public function setAccountNumber(?string $accountNumber);

    public function getDeliveryMethod(): ?ChoiceInterface;

    /**
     * @return static
     */
    public function setDeliveryMethod(?ChoiceInterface $deliveryMethod);

    public function getPaymentTerms(): ?ChoiceInterface;

    /**
     * @return static
     */
    public function setPaymentTerms(?ChoiceInterface $paymentTerms);

    public function getPurchasePaymentTerms(): ?ChoiceInterface;

    /**
     * @return static
     */
    public function setPurchasePaymentTerms(?ChoiceInterface $purchasePaymentTerms);
}
