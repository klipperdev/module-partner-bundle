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
 * Account interface.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface AccountableInterface
{
    public function getAccount(): ?AccountInterface;

    /**
     * @return static
     */
    public function setAccount(?AccountInterface $account);

    /**
     * @return null|int|string
     */
    public function getAccountId();
}
