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

use Klipper\Component\DoctrineChoice\Model\ChoiceInterface;

/**
 * Person interface.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface PersonInterface
{
    public function getSalutation(): ?ChoiceInterface;

    /**
     * @return static
     */
    public function setSalutation(?ChoiceInterface $salutation);

    public function getFirstName(): ?string;

    /**
     * @return static
     */
    public function setFirstName(?string $firstName);

    public function getLastName(): ?string;

    /**
     * @return static
     */
    public function setLastName(?string $lastName);

    public function getEmail(): ?string;

    /**
     * @return static
     */
    public function setEmail(?string $email);

    public function getPhone(): ?string;

    /**
     * @return static
     */
    public function setPhone(?string $phone);

    public function getMobilePhone(): ?string;

    /**
     * @return static
     */
    public function setMobilePhone(?string $mobilePhone);

    public function getFax(): ?string;

    /**
     * @return static
     */
    public function setFax(?string $fax);

    public function getWebsiteUrl(): ?string;

    /**
     * @return static
     */
    public function setWebsiteUrl(?string $websiteUrl);
}
