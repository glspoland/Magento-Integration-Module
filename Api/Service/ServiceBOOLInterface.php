<?php

namespace GlsPoland\Shipping\Api\Service;

interface ServiceBOOLInterface
{
    /**
     * Get Cash on delivery
     *
     * @return bool
     */
    public function getCod(): bool;

    /**
     * Set Cash on delivery
     *
     * @param bool $cod
     * @return void
     */
    public function setCod(bool $cod): void;

    /**
     * Get Cash on delivery amount.
     *
     * @return float
     */
    public function getCodAmount(): float;

    /**
     * Set Cash on delivery amount.
     *
     * @param float $cod_amount
     * @return void
     */
    public function setCodAmount(float $cod_amount): void;

    /**
     * Get Exw
     *
     * @return bool
     */
    public function getExw(): bool;

    /**
     * Set EXW
     *
     * @param bool $exw
     * @return void
     */
    public function setExw(bool $exw): void;

    /**
     * Get ROD
     *
     * @return bool
     */
    public function getRod(): bool;

    /**
     * Set ROD
     *
     * @param bool $rod
     * @return void
     */
    public function setRod(bool $rod): void;

    /**
     * Get POD
     *
     * @return bool
     */
    public function getPod(): bool;

    /**
     * Set POD
     *
     * @param bool $pod
     * @return void
     */
    public function setPod(bool $pod): void;

    /**
     * Get EXC
     *
     * @return bool
     */
    public function getExc(): bool;

    /**
     * Set EXC
     *
     * @param bool $exc
     * @return void
     */
    public function setExc(bool $exc): void;

    /**
     * Get Ident
     *
     * @return bool
     */
    public function getIdent(): bool;

    /**
     * Set Ident
     *
     * @param bool $ident
     * @return void
     */
    public function setIdent(bool $ident): void;

    /**
     * Get Daw
     *
     * @return bool
     */
    public function getDaw(): bool;

    /**
     * Set Daw
     *
     * @param bool $daw
     * @return void
     */
    public function setDaw(bool $daw): void;

    /**
     * Get Ps
     *
     * @return bool
     */
    public function getPs(): bool;

    /**
     * Set Ps.
     *
     * @param bool $ps
     * @return void
     */
    public function setPs(bool $ps): void;

    /**
     * Get Pr
     *
     * @return bool
     */
    public function getPr(): bool;

    /**
     * Set Pr
     *
     * @param bool $pr
     * @return void
     */
    public function setPr(bool $pr): void;

    /**
     * Get S10
     *
     * @return bool
     */
    public function getS10(): bool;

    /**
     * Set S10
     *
     * @param bool $s10
     * @return void
     */
    public function setS10(bool $s10): void;

    /**
     * Get S12
     *
     * @return bool
     */
    public function getS12(): bool;

    /**
     * Set S12
     *
     * @param bool $s12
     * @return void
     */
    public function setS12(bool $s12): void;

    /**
     * Get Sat
     *
     * @return bool
     */
    public function getSat(): bool;

    /**
     * Set sat
     *
     * @param bool $sat
     * @return void
     */
    public function setSat(bool $sat): void;

    /**
     * Get Ow
     *
     * @return bool
     */
    public function getOw(): bool;

    /**
     * Set Ow
     *
     * @param bool $ow
     * @return void
     */
    public function setOw(bool $ow): void;

    /**
     * Get Srs
     *
     * @return bool
     */
    public function getSrs(): bool;

    /**
     * Set Srs
     *
     * @param bool $srs
     * @return void
     */
    public function setSrs(bool $srs): void;

    /**
     * Get Sds
     *
     * @return bool
     */
    public function getSds(): bool;

    /**
     * Set Sds
     *
     * @param bool $sds
     * @return void
     */
    public function setSds(bool $sds): void;

    /**
     * Get Cdx
     *
     * @return bool|null
     */
    public function getCdx(): ?bool;

    /**
     * Set Cdx
     *
     * @param bool|null $cdx
     * @return void
     */
    public function setCdx(bool $cdx = null): void;

    /**
     * Get Cdx Amount
     *
     * @return float|null
     */
    public function getCdxAmount(): ?float;

    /**
     * Set Cdx amount
     *
     * @param float|null $cdx_amount
     * @return void
     */
    public function setCdxAmount(float $cdx_amount = null): void;

    /**
     * Get Cdx Currency
     *
     * @return string|null
     */
    public function getCdxCurrency(): ?string;

    /**
     * Set Cdx Currency
     *
     * @param string|null $cdx_currency
     * @return void
     */
    public function setCdxCurrency(string $cdx_currency = null): void;

    /**
     * Get Ado
     *
     * @return bool|null
     */
    public function getAdo(): ?bool;

    /**
     * Set Ado
     *
     * @param bool|null $ado
     * @return void
     */
    public function setAdo(bool $ado = null): void;
}
