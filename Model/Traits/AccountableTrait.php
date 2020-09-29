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

use Klipper\Module\PartnerBundle\Model\AccountInterface;

/**
 * Trait to indicate that the model is linked with an account.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
trait AccountableTrait
{
    protected ?AccountInterface $account = null;

    /**
     * @see AccountableInterface::setAccount()
     */
    public function setAccount(?AccountInterface $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @see AccountableInterface::getAccount()
     */
    public function getAccount(): ?AccountInterface
    {
        return $this->account;
    }

    /**
     * @see AccountableInterface::getAccountId()
     */
    public function getAccountId()
    {
        return null !== $this->getAccount()
            ? $this->getAccount()->getId()
            : null;
    }
}
