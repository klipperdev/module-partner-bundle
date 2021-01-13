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
use Klipper\Component\Model\Traits\SimpleNameableInterface;

/**
 * Company interface.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
interface CompanyInterface extends SimpleNameableInterface
{
    public function getSiret(): ?string;

    /**
     * @return static
     */
    public function setSiret(?string $siret);

    public function getNumberVat(): ?string;

    /**
     * @return static
     */
    public function setNumberVat(?string $numberVat);

    public function getWebsiteUrl(): ?string;

    /**
     * @return static
     */
    public function setWebsiteUrl(?string $websiteUrl);

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

    public function getFax(): ?string;

    /**
     * @return static
     */
    public function setFax(?string $fax);

    public function getAnnualRevenue(): ?float;

    /**
     * @return static
     */
    public function setAnnualRevenue(?float $annualRevenue);

    public function getMasterAccount(): ?AccountInterface;

    /**
     * @return static
     */
    public function setMasterAccount(?AccountInterface $masterAccount);

    public function getBusinessType(): ?ChoiceInterface;

    /**
     * @return static
     */
    public function setBusinessType(?ChoiceInterface $businessType);
}
