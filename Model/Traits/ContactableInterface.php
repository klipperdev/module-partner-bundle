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

use Klipper\Module\PartnerBundle\Model\ContactInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface ContactableInterface
{
    public function getContact(): ?ContactInterface;

    /**
     * @return static
     */
    public function setContact(?ContactInterface $contact);

    /**
     * @return null|int|string
     */
    public function getContactId();
}
