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
use Klipper\Component\Model\Traits\EmailableTrait;
use Klipper\Component\Model\Traits\LabelableTrait;
use Klipper\Component\Model\Traits\OrganizationalRequiredTrait;
use Klipper\Component\Model\Traits\TimestampableTrait;
use Klipper\Component\Model\Traits\UserTrackableTrait;
use Klipper\Module\PartnerBundle\Model\Traits\PartnerableTrait;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
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
     * @ORM\ManyToOne(targetEntity="Klipper\Component\DoctrineChoice\Model\ChoiceInterface")
     *
     * @Serializer\Expose
     */
    protected ?ChoiceInterface $type = null;

    public function getType(): ?ChoiceInterface
    {
        return $this->type;
    }

    public function setType(?ChoiceInterface $type): self
    {
        $this->type = $type;

        return $this;
    }
}
