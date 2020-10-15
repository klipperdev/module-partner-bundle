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
use Klipper\Component\Model\Traits\OrganizationalRequiredTrait;
use Klipper\Component\Model\Traits\OwnerableTrait;
use Klipper\Component\Model\Traits\TimestampableTrait;
use Klipper\Component\Model\Traits\UserTrackableTrait;
use Klipper\Module\PartnerBundle\Model\Traits\AccountableOptionalTrait;
use Klipper\Module\PartnerBundle\Model\Traits\PersonTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact model.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
abstract class AbstractContact implements ContactInterface
{
    use PersonTrait;
    use AccountableOptionalTrait;
    use OrganizationalRequiredTrait;
    use OwnerableTrait;
    use TimestampableTrait;
    use UserTrackableTrait;

    /**
     * @ORM\OneToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\AccountInterface",
     *     mappedBy="personalContact",
     *     cascade={"persist", "remove"}
     * )
     *
     * @Serializer\Type("Relation")
     * @Serializer\Expose
     * @Serializer\ReadOnly
     */
    protected ?AccountInterface $personalAccount = null;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\AccountInterface",
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Assert\Expression(
     *     "!(null === this.getPersonalAccount() && null === value)",
     *     message="This value should not be null."
     * )
     *
     * @Serializer\Type("Relation")
     * @Serializer\Expose
     * @Serializer\ReadOnly
     */
    protected ?AccountInterface $account = null;

    public function getPersonalAccount(): ?AccountInterface
    {
        return $this->personalAccount;
    }

    public function setPersonalAccount(?AccountInterface $personalAccount): self
    {
        $this->personalAccount = $personalAccount;

        return $this;
    }
}
