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

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Klipper\Component\DoctrineChoice\Model\ChoiceInterface;
use Klipper\Component\Geocoder\Model\Traits\AddressTrait;
use Klipper\Component\Model\Traits\NameableTrait;
use Klipper\Component\Model\Traits\OrganizationalRequiredTrait;
use Klipper\Component\Model\Traits\OwnerableTrait;
use Klipper\Component\Model\Traits\TimestampableTrait;
use Klipper\Component\Model\Traits\UserTrackableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Account model.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
abstract class AbstractAccount implements AccountInterface
{
    use AddressTrait;
    use NameableTrait;
    use OrganizationalRequiredTrait;
    use OwnerableTrait;
    use TimestampableTrait;
    use UserTrackableTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="255")
     *
     * @Serializer\Expose
     */
    protected ?string $street = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="255")
     *
     * @Serializer\Expose
     */
    protected ?string $streetComplement = null;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="50")
     *
     * @Serializer\Expose
     */
    protected ?string $postalCode = null;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="128")
     *
     * @Serializer\Expose
     */
    protected ?string $city = null;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="128")
     *
     * @Serializer\Expose
     */
    protected ?string $state = null;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     *
     * @Assert\Country
     * @Assert\Length(max=3)
     *
     * @Serializer\Expose
     */
    protected ?string $country = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="255")
     *
     * @Serializer\Expose
     */
    protected ?string $websiteUrl = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="255")
     *
     * @Serializer\Expose
     */
    protected ?string $email = null;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="80")
     *
     * @Serializer\Expose
     */
    protected ?string $phone = null;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min="0", max="80")
     *
     * @Serializer\Expose
     */
    protected ?string $fax = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     *
     * @Serializer\Expose
     */
    protected ?string $siret = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     *
     * @Serializer\Expose
     */
    protected ?string $numberVat = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     *
     * @Serializer\Expose
     */
    protected ?string $accountNumber = null;

    /**
     * @ORM\Column(type="float", nullable=true)
     *
     * @Assert\Type(type="float")
     *
     * @Serializer\Expose
     */
    protected ?float $annualRevenue = null;

    /**
     * @ORM\ManyToOne(targetEntity="Klipper\Module\PartnerBundle\Model\AccountInterface")
     *
     * @Serializer\Expose
     */
    protected ?AccountInterface $masterAccount = null;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Assert\Type(type="boolean")
     *
     * @Serializer\Expose
     */
    protected bool $customer = false;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Assert\Type(type="boolean")
     *
     * @Serializer\Expose
     */
    protected bool $supplier = false;

    /**
     * @ORM\ManyToOne(targetEntity="Klipper\Component\DoctrineChoice\Model\ChoiceInterface")
     *
     * @Serializer\Expose
     */
    protected ?ChoiceInterface $businessType = null;

    /**
     * @ORM\ManyToOne(targetEntity="Klipper\Component\DoctrineChoice\Model\ChoiceInterface")
     *
     * @Serializer\Expose
     */
    protected ?ChoiceInterface $deliveryMethod = null;

    /**
     * @ORM\ManyToOne(targetEntity="Klipper\Component\DoctrineChoice\Model\ChoiceInterface")
     *
     * @Serializer\Expose
     */
    protected ?ChoiceInterface $paymentTerms = null;

    /**
     * @ORM\ManyToOne(targetEntity="Klipper\Component\DoctrineChoice\Model\ChoiceInterface")
     *
     * @Serializer\Expose
     */
    protected ?ChoiceInterface $purchasePaymentTerms = null;

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): self
    {
        $this->websiteUrl = $websiteUrl;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getNumberVat(): ?string
    {
        return $this->numberVat;
    }

    public function setNumberVat(?string $numberVat): self
    {
        $this->numberVat = $numberVat;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(?string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAnnualRevenue(): ?float
    {
        return $this->annualRevenue;
    }

    public function setAnnualRevenue(?float $annualRevenue): self
    {
        $this->annualRevenue = $annualRevenue;

        return $this;
    }

    public function getMasterAccount(): ?AccountInterface
    {
        return $this->masterAccount;
    }

    public function setMasterAccount(?AccountInterface $masterAccount): self
    {
        $this->masterAccount = $masterAccount;

        return $this;
    }

    public function setCustomer(bool $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function isCustomer(): bool
    {
        return $this->customer;
    }

    public function setSupplier(bool $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function isSupplier(): bool
    {
        return $this->supplier;
    }

    public function getBusinessType(): ?ChoiceInterface
    {
        return $this->businessType;
    }

    public function setBusinessType(?ChoiceInterface $businessType): self
    {
        $this->businessType = $businessType;

        return $this;
    }

    public function getDeliveryMethod(): ?ChoiceInterface
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(?ChoiceInterface $deliveryMethod): self
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function getPaymentTerms(): ?ChoiceInterface
    {
        return $this->paymentTerms;
    }

    public function setPaymentTerms(?ChoiceInterface $paymentTerms): self
    {
        $this->paymentTerms = $paymentTerms;

        return $this;
    }

    public function getPurchasePaymentTerms(): ?ChoiceInterface
    {
        return $this->purchasePaymentTerms;
    }

    public function setPurchasePaymentTerms(?ChoiceInterface $purchasePaymentTerms): self
    {
        $this->purchasePaymentTerms = $purchasePaymentTerms;

        return $this;
    }
}
