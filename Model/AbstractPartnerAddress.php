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
use Klipper\Component\DoctrineChoice\Validator\Constraints\EntityDoctrineChoice;
use Klipper\Component\Geocoder\Model\Traits\AddressTrait;
use Klipper\Component\Model\Traits\EmailableTrait;
use Klipper\Component\Model\Traits\LabelableTrait;
use Klipper\Component\Model\Traits\OrganizationalRequiredTrait;
use Klipper\Component\Model\Traits\TimestampableTrait;
use Klipper\Component\Model\Traits\UserTrackableTrait;
use Klipper\Module\PartnerBundle\Model\Traits\PartnerableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 *
 * @Serializer\ExclusionPolicy("all")
 */
abstract class AbstractPartnerAddress implements PartnerAddressInterface
{
    use PartnerableTrait;
    use AddressTrait;
    use LabelableTrait;
    use OrganizationalRequiredTrait;
    use EmailableTrait;
    use TimestampableTrait;
    use UserTrackableTrait;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max=255)
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     */
    protected ?string $label = null;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(max=100)
     *
     * @Serializer\Expose
     */
    protected ?string $reference = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=0, max=255)
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     */
    protected ?string $street = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=0, max=255)
     *
     * @Serializer\Expose
     */
    protected ?string $streetComplement = null;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=0, max=50)
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     */
    protected ?string $postalCode = null;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=0, max=128)
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     */
    protected ?string $city = null;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     *
     * @Assert\Type(type="string")
     * @Assert\Length(min=0, max=128)
     *
     * @Serializer\Expose
     */
    protected ?string $state = null;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     *
     * @Assert\Country
     * @Assert\Length(max=3)
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     */
    protected ?string $country = null;

    /**
     * @ORM\ManyToOne(targetEntity="Klipper\Component\DoctrineChoice\Model\ChoiceInterface", fetch="EAGER")
     *
     * @EntityDoctrineChoice("partner_address_type")
     * @Assert\NotBlank
     *
     * @Serializer\Expose
     */
    protected ?ChoiceInterface $type = null;

    public function setType(?ChoiceInterface $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?ChoiceInterface
    {
        return $this->type;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }
}
