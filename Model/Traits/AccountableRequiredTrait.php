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
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait to indicate that the model is linked with a required account.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
trait AccountableRequiredTrait
{
    use AccountableTrait;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\AccountInterface",
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Assert\NotNull
     *
     * @Serializer\Type("Relation")
     * @Serializer\Expose
     * @Serializer\ReadOnly
     */
    protected ?AccountInterface $account;
}
