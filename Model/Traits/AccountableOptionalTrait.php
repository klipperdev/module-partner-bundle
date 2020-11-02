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

/**
 * Trait to indicate that the model is linked with an optional account.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
trait AccountableOptionalTrait
{
    use AccountableTrait;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Klipper\Module\PartnerBundle\Model\AccountInterface",
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Serializer\Type("AssociationId")
     * @Serializer\Expose
     */
    protected ?AccountInterface $account = null;
}
