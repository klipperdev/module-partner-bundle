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

use Klipper\Component\Model\Traits\OrganizationalRequiredTrait;
use Klipper\Component\Model\Traits\OwnerableTrait;
use Klipper\Component\Model\Traits\TimestampableTrait;
use Klipper\Component\Model\Traits\UserTrackableTrait;
use Klipper\Module\PartnerBundle\Model\Traits\AccountableRequiredTrait;
use Klipper\Module\PartnerBundle\Model\Traits\PersonTrait;

/**
 * Contact model.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
abstract class AbstractContact implements ContactInterface
{
    use PersonTrait;
    use AccountableRequiredTrait;
    use OrganizationalRequiredTrait;
    use OwnerableTrait;
    use TimestampableTrait;
    use UserTrackableTrait;
}
