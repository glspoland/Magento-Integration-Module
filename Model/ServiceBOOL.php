<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Service\ServiceBOOLInterface;

class ServiceBOOL implements ServiceBOOLInterface
{
    /** @var bool */
    public bool $cod;

    /** @var float */
    public float $cod_amount;

    /** @var bool */
    public bool $exw;

    /** @var bool */
    public bool $rod;

    /** @var bool */
    public bool $pod;

    /** @var bool */
    public bool $exc;

    /** @var bool */
    public bool $ident;

    /** @var bool */
    public bool $daw;

    /** @var bool */
    public bool $ps;

    /** @var bool */
    public bool $pr;

    /** @var bool */
    public bool $s10;

    /** @var bool */
    public bool $s12;

    /** @var bool */
    public bool $sat;

    /** @var bool */
    public bool $ow;

    /** @var bool */
    public bool $srs;

    /** @var bool */
    public bool $sds;

    /** @var bool|null */
    public ?bool $cdx;

    /** @var float|null */
    public ?float $cdx_amount;

    /** @var string|null */
    public ?string $cdx_currency;

    /** @var bool|null */
    public ?bool $ado;

    /**
     * Constructor method for ServicesBool
     *
     * @param bool $cod
     * @param float $cod_amount
     * @param bool $exw
     * @param bool $rod
     * @param bool $pod
     * @param bool $exc
     * @param bool $ident
     * @param bool $daw
     * @param bool $ps
     * @param bool $pr
     * @param bool $s10
     * @param bool $s12
     * @param bool $sat
     * @param bool $ow
     * @param bool $srs
     * @param bool $sds
     * @param bool|null $cdx
     * @param float|null $cdx_amount
     * @param string|null $cdx_currency
     * @param bool|null $ado
     */
    public function __construct(
        bool $cod,
        float $cod_amount,
        bool $exw,
        bool $rod,
        bool $pod,
        bool $exc,
        bool $ident,
        bool $daw,
        bool $ps,
        bool $pr,
        bool $s10,
        bool $s12,
        bool $sat,
        bool $ow,
        bool $srs,
        bool $sds,
        bool $cdx = null,
        float $cdx_amount = null,
        string $cdx_currency = null,
        bool $ado = null
    ) {
        $this->setCod($cod);
        $this->setCodAmount($cod_amount);
        $this->setExw($exw);
        $this->setRod($rod);
        $this->setPod($pod);
        $this->setExc($exc);
        $this->setIdent($ident);
        $this->setDaw($daw);
        $this->setPs($ps);
        $this->setPr($pr);
        $this->setS10($s10);
        $this->setS12($s12);
        $this->setSat($sat);
        $this->setOw($ow);
        $this->setSrs($srs);
        $this->setSds($sds);
        $this->setCdx($cdx);
        $this->setCdxAmount($cdx_amount);
        $this->setCdxCurrency($cdx_currency);
        $this->setAdo($ado);
    }

    /**
     * Get Cash on delivery
     *
     * @return bool
     */
    public function getCod(): bool
    {
        return $this->cod;
    }

    /**
     * Set Cash on delivery
     *
     * @param bool $cod
     * @return void
     */
    public function setCod(bool $cod): void
    {
        $this->cod = $cod;
    }

    /**
     * Get Cash on delivery amount.
     *
     * @return float
     */
    public function getCodAmount(): float
    {
        return $this->cod_amount;
    }

    /**
     * Set Cash on delivery amount.
     *
     * @param float $cod_amount
     * @return void
     */
    public function setCodAmount(float $cod_amount): void
    {
        $this->cod_amount = $cod_amount;
    }

    /**
     * Get Exw
     *
     * @return bool
     */
    public function getExw(): bool
    {
        return $this->exw;
    }

    /**
     * Set EXW
     *
     * @param bool $exw
     * @return void
     */
    public function setExw(bool $exw): void
    {
        $this->exw = $exw;
    }

    /**
     * Get ROD
     *
     * @return bool
     */
    public function getRod(): bool
    {
        return $this->rod;
    }

    /**
     * Set ROD
     *
     * @param bool $rod
     * @return void
     */
    public function setRod(bool $rod): void
    {
        $this->rod = $rod;
    }

    /**
     * Get POD
     *
     * @return bool
     */
    public function getPod(): bool
    {
        return $this->pod;
    }

    /**
     * Set POD
     *
     * @param bool $pod
     * @return void
     */
    public function setPod(bool $pod): void
    {
        $this->pod = $pod;
    }

    /**
     * Get EXC
     *
     * @return bool
     */
    public function getExc(): bool
    {
        return $this->exc;
    }

    /**
     * Set EXC
     *
     * @param bool $exc
     * @return void
     */
    public function setExc(bool $exc): void
    {
        $this->exc = $exc;
    }

    /**
     * Get Ident
     *
     * @return bool
     */
    public function getIdent(): bool
    {
        return $this->ident;
    }

    /**
     * Set Ident
     *
     * @param bool $ident
     * @return void
     */
    public function setIdent(bool $ident): void
    {
        $this->ident = $ident;
    }

    /**
     * Get Daw
     *
     * @return bool
     */
    public function getDaw(): bool
    {
        return $this->daw;
    }

    /**
     * Set Daw
     *
     * @param bool $daw
     * @return void
     */
    public function setDaw(bool $daw): void
    {
        $this->daw = $daw;
    }

    /**
     * Get Ps
     *
     * @return bool
     */
    public function getPs(): bool
    {
        return $this->ps;
    }

    /**
     * Set Ps.
     *
     * @param bool $ps
     * @return void
     */
    public function setPs(bool $ps): void
    {
        $this->ps = $ps;
    }

    /**
     * Get Pr
     *
     * @return bool
     */
    public function getPr(): bool
    {
        return $this->pr;
    }

    /**
     * Set Pr
     *
     * @param bool $pr
     * @return void
     */
    public function setPr(bool $pr): void
    {
        $this->pr = $pr;
    }

    /**
     * Get S10
     *
     * @return bool
     */
    public function getS10(): bool
    {
        return $this->s10;
    }

    /**
     * Set S10
     *
     * @param bool $s10
     * @return void
     */
    public function setS10(bool $s10): void
    {
        $this->s10 = $s10;
    }

    /**
     * Get S12
     *
     * @return bool
     */
    public function getS12(): bool
    {
        return $this->s12;
    }

    /**
     * Set S12
     *
     * @param bool $s12
     * @return void
     */
    public function setS12(bool $s12): void
    {
        $this->s12 = $s12;
    }

    /**
     * Get Sat
     *
     * @return bool
     */
    public function getSat(): bool
    {
        return $this->sat;
    }

    /**
     * Set sat
     *
     * @param bool $sat
     * @return void
     */
    public function setSat(bool $sat): void
    {
        $this->sat = $sat;
    }

    /**
     * Get Ow
     *
     * @return bool
     */
    public function getOw(): bool
    {
        return $this->ow;
    }

    /**
     * Set Ow
     *
     * @param bool $ow
     * @return void
     */
    public function setOw(bool $ow): void
    {
        $this->ow = $ow;
    }

    /**
     * Get Srs
     *
     * @return bool
     */
    public function getSrs(): bool
    {
        return $this->srs;
    }

    /**
     * Set Srs
     *
     * @param bool $srs
     * @return void
     */
    public function setSrs(bool $srs): void
    {
        $this->srs = $srs;
    }

    /**
     * Get Sds
     *
     * @return bool
     */
    public function getSds(): bool
    {
        return $this->sds;
    }

    /**
     * Set Sds
     *
     * @param bool $sds
     * @return void
     */
    public function setSds(bool $sds): void
    {
        $this->sds = $sds;
    }

    /**
     * Get Cdx
     *
     * @return bool|null
     */
    public function getCdx(): ?bool
    {
        return $this->cdx;
    }

    /**
     * Set Cdx
     *
     * @param bool|null $cdx
     * @return void
     */
    public function setCdx(bool $cdx = null): void
    {
        $this->cdx = $cdx;
    }

    /**
     * Get Cdx Amount
     *
     * @return float|null
     */
    public function getCdxAmount(): ?float
    {
        return $this->cdx_amount;
    }

    /**
     * Set Cdx amount
     *
     * @param float|null $cdx_amount
     * @return void
     */
    public function setCdxAmount(float $cdx_amount = null): void
    {
        $this->cdx_amount = $cdx_amount;
    }

    /**
     * Get Cdx Currency
     *
     * @return string|null
     */
    public function getCdxCurrency(): ?string
    {
        return $this->cdx_currency;
    }

    /**
     * Set Cdx Currency
     *
     * @param string|null $cdx_currency
     * @return void
     */
    public function setCdxCurrency(string $cdx_currency = null): void
    {
        $this->cdx_currency = $cdx_currency;
    }

    /**
     * Get Ado
     *
     * @return bool|null
     */
    public function getAdo(): ?bool
    {
        return $this->ado;
    }

    /**
     * Set Ado
     *
     * @param bool|null $ado
     * @return void
     */
    public function setAdo(bool $ado = null): void
    {
        $this->ado = $ado;
    }
}
