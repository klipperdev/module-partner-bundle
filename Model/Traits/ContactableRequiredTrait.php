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
use Klipper\Module\PartnerBundle\Model\ContactInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait to indicate that the model is linked with a required contact.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
trait ContactableRequiredTrait
{
    use ContactableTrait;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\ContactInterface"
     * )
     *
     * @Assert\NotNull
     *
     * @Serializer\Expose
     * @Serializer\MaxDepth(1)
     */
    protected ?ContactInterface $contact = null;
}
