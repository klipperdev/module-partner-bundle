<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Module\PartnerBundle\Model\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Klipper\Module\PartnerBundle\Model\AccountInterface;
use Klipper\Module\PartnerBundle\Model\ContactInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait to indicate that the model is linked with an account and/or a contact.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
trait PartnerableTrait
{
    use AccountableTrait;
    use ContactableTrait;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\AccountInterface",
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Assert\Expression(
     *     expression="null == this.getAccount() and null == this.getContact()",
     *     message="klipper_partner.patnerable.account_or_contact_required"
     * )
     *
     * @Serializer\Type("AssociationId")
     * @Serializer\Expose
     */
    protected ?AccountInterface $account = null;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\ContactInterface",
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Assert\Expression(
     *     expression="null == this.getAccount() and null == this.getContact()",
     *     message="klipper_partner.patnerable.account_or_contact_required"
     * )
     *
     * @Serializer\Type("AssociationId")
     * @Serializer\Expose
     */
    protected ?ContactInterface $contact = null;
}
