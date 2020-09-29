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
 * Trait to indicate that the model is linked with a contact.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
trait ContactableTrait
{
    protected ?ContactInterface $contact = null;

    /**
     * @see ContactableInterface::setContact()
     */
    public function setContact(?ContactInterface $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @see ContactableInterface::getContact()
     */
    public function getContact(): ?ContactInterface
    {
        return $this->contact;
    }

    /**
     * @see ContactableInterface::getContactId()
     */
    public function getContactId()
    {
        return null !== $this->getContact()
            ? $this->getContact()->getId()
            : null;
    }
}
