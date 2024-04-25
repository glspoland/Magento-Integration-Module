<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use stdClass;

class Consign
{
    /** @var string */
    public string $rname1;

    /** @var string|null */
    public ?string $rname2;

    /** @var string|null */
    public ?string $rname3;

    /** @var string */
    public string $rcountry;

    /** @var string */
    public string $rzipcode;

    /** @var string */
    public string $rcity;

    /** @var string */
    public string $rstreet;

    /** @var string */
    public string $rphone;

    /** @var string */
    public string $rcontact;

    /** @var string|null */
    public ?string $references;

    /** @var string|null */
    public ?string $notes;

    /** @var int|null */
    public ?int $quantity;

    /** @var float|null */
    public ?float $weight;

    /** @var string|null */
    public ?string $date;

    /** @var string|null */
    public ?string $pfc;

    /** @var stdClass|SenderAddress|null */
    // phpcs:ignore
    public stdClass|SenderAddress|null $sendaddr;

    /** @var stdClass|ServiceBOOL|null */
    // phpcs:ignore
    public stdClass|ServiceBOOL|null $srv_bool;

    /** @var string|null */
    public ?string $srv_ade;

    /** @var stdClass|ServiceDAW|null */
    // phpcs:ignore
    public stdClass|ServiceDAW|null $srv_daw;

    /** @var stdClass|ServiceIDENT|null */
    // phpcs:ignore
    public stdClass|ServiceIDENT|null $srv_ident;

    /** @var stdClass|ServicePPE|null */
    // phpcs:ignore
    public stdClass|ServicePPE|null $srv_ppe;

    /** @var stdClass|ServiceSDS|null */
    // phpcs:ignore
    public stdClass|ServiceSDS|null $srv_sds;

    /** @var stdClass|ParcelsArray|null */
    // phpcs:ignore
    public stdClass|ParcelsArray|null $parcels;

    /**
     * Construct.
     *
     * @param string $rname1
     * @param string $rcountry
     * @param string $rzipcode
     * @param string $rcity
     * @param string $rstreet
     * @param string $rphone
     * @param string $rcontact
     * @param string|null $rname2
     * @param string|null $rname3
     * @param string|null $references
     * @param string|null $notes
     * @param int|null $quantity
     * @param float|null $weight
     * @param string|null $date
     * @param string|null $pfc
     * @param stdClass|SenderAddress|null $sendaddr
     * @param stdClass|ServiceBOOL|null $srv_bool
     * @param string|null $srv_ade
     * @param stdClass|ServiceDAW|null $srv_daw
     * @param stdClass|ServiceIDENT|null $srv_ident
     * @param stdClass|ServicePPE|null $srv_ppe
     * @param stdClass|ServiceSDS|null $srv_sds
     * @param stdClass|ParcelsArray|null $parcels
     */
    public function __construct(
        string $rname1,
        string $rcountry,
        string $rzipcode,
        string $rcity,
        string $rstreet,
        string $rphone,
        string $rcontact,
        ?string $rname2 = null,
        ?string $rname3 = null,
        ?string $references = null,
        ?string $notes = null,
        ?int $quantity = null,
        ?float $weight = null,
        ?string $date = null,
        ?string $pfc = null,
        stdClass|SenderAddress|null $sendaddr = null,
        stdClass|ServiceBOOL|null $srv_bool = null,
        ?string $srv_ade = null,
        stdClass|ServiceDAW|null $srv_daw = null,
        stdClass|ServiceIDENT|null $srv_ident = null,
        stdClass|ServicePPE|null $srv_ppe = null,
        stdClass|ServiceSDS|null $srv_sds = null,
        stdClass|ParcelsArray|null $parcels = null
    ) {
        $this->setRname1($rname1);
        $this->setRcountry($rcountry);
        $this->setRzipcode($rzipcode);
        $this->setRcity($rcity);
        $this->setRstreet($rstreet);
        $this->setRphone($rphone);
        $this->setRcontact($rcontact);
        $this->setRname2($rname2);
        $this->setRname3($rname3);
        $this->setReferences($references);
        $this->setNotes($notes);
        $this->setQuantity($quantity);
        $this->setWeight($weight);
        $this->setDate($date);
        $this->setPfc($pfc);
        $this->setSendaddr($sendaddr);
        $this->setSrvBool($srv_bool);
        $this->setSrvAde($srv_ade);
        $this->setSrvDaw($srv_daw);
        $this->setSrvIdent($srv_ident);
        $this->setSrvPpe($srv_ppe);
        $this->setSrvSds($srv_sds);
        $this->setParcels($parcels);
    }

    /**
     * Set data for object properties from array.
     *
     * @param array $data
     * @return Consign
     */
    public function setData(array $data): Consign
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * Set rname1.
     *
     * @param string $rname1
     * @return void
     */
    public function setRname1(string $rname1): void
    {
        $this->rname1 = $rname1;
    }

    /**
     * Get rname1.
     *
     * @return string
     */
    public function getRname1(): string
    {
        return $this->rname1;
    }

    /**
     * Set rname2.
     *
     * @param string|null $rname2
     * @return void
     */
    public function setRname2(?string $rname2 = null): void
    {
        $this->rname2 = $rname2;
    }

    /**
     * Get rname2.
     *
     * @return string|null
     */
    public function getRname2(): ?string
    {
        return $this->rname2;
    }

    /**
     * Set rname3.
     *
     * @param string|null $rname3
     * @return void
     */
    public function setRname3(?string $rname3 = null): void
    {
        $this->rname3 = $rname3;
    }

    /**
     * Get rname3.
     *
     * @return string|null
     */
    public function getRname3(): ?string
    {
        return $this->rname3;
    }

    /**
     * Set rcountry.
     *
     * @param string $rcountry
     * @return void
     */
    public function setRcountry(string $rcountry): void
    {
        $this->rcountry = $rcountry;
    }

    /**
     * Get rcountry.
     *
     * @return string
     */
    public function getRcountry(): string
    {
        return $this->rcountry;
    }

    /**
     * Set rzipcode.
     *
     * @param string $rzipcode
     * @return void
     */
    public function setRzipcode(string $rzipcode): void
    {
        $this->rzipcode = $rzipcode;
    }

    /**
     * Get rzipcode.
     *
     * @return string
     */
    public function getRzipcode(): string
    {
        return $this->rzipcode;
    }

    /**
     * Set rcity.
     *
     * @param string $rcity
     * @return void
     */
    public function setRcity(string $rcity): void
    {
        $this->rcity = $rcity;
    }

    /**
     * Get rcity.
     *
     * @return string
     */
    public function getRcity(): string
    {
        return $this->rcity;
    }

    /**
     * Set rstreet.
     *
     * @param string $rstreet
     * @return void
     */
    public function setRstreet(string $rstreet): void
    {
        $this->rstreet = $rstreet;
    }

    /**
     * Get rstreet.
     *
     * @return string
     */
    public function getRstreet(): string
    {
        return $this->rstreet;
    }

    /**
     * Set rphone.
     *
     * @param string $rphone
     * @return void
     */
    public function setRphone(string $rphone): void
    {
        $this->rphone = $rphone;
    }

    /**
     * Get rphone.
     *
     * @return string
     */
    public function getRphone(): string
    {
        return $this->rphone;
    }

    /**
     * Set rcontact.
     *
     * @param string $rcontact
     * @return void
     */
    public function setRcontact(string $rcontact): void
    {
        $this->rcontact = $rcontact;
    }

    /**
     * Get rcontact.
     *
     * @return string
     */
    public function getRcontact(): string
    {
        return $this->rcontact;
    }

    /**
     * Set references.
     *
     * @param string|null $references
     * @return void
     */
    public function setReferences(?string $references = null): void
    {
        $this->references = $references;
    }

    /**
     * Get references.
     *
     * @return string|null
     */
    public function getReferences(): ?string
    {
        return $this->references;
    }

    /**
     * Set notes.
     *
     * @param string|null $notes
     * @return void
     */
    public function setNotes(?string $notes = null): void
    {
        $this->notes = $notes;
    }

    /**
     * Get notes.
     *
     * @return string|null
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * Set quantity.
     *
     * @param int|null $quantity
     * @return void
     */
    public function setQuantity(?int $quantity = null): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity.
     *
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Set weight.
     *
     * @param float|null $weight
     * @return void
     */
    public function setWeight(?float $weight = null): void
    {
        $this->weight = $weight;
    }

    /**
     * Get weight.
     *
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * Set date.
     *
     * @param string|null $date
     * @return void
     */
    public function setDate(?string $date = null): void
    {
        $this->date = $date;
    }

    /**
     * Get date.
     *
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * Set pfc.
     *
     * @param string|null $pfc
     * @return void
     */
    public function setPfc(?string $pfc = null): void
    {
        $this->pfc = $pfc;
    }

    /**
     * Get pfc.
     *
     * @return string|null
     */
    public function getPfc(): ?string
    {
        return $this->pfc;
    }

    /**
     * Set sender address.
     *
     * @param stdClass|SenderAddress|null $sendaddr
     * @return void
     */
    public function setSendaddr(stdClass|SenderAddress|null $sendaddr = null): void
    {
        $this->sendaddr = $sendaddr;
    }

    /**
     * Get sender address.
     *
     * @return stdClass|SenderAddress|null
     */
    public function getSendaddr(): stdClass|SenderAddress|null
    {
        return $this->sendaddr;
    }

    /**
     * Set service bool.
     *
     * @param stdClass|ServiceBOOL|null $srv_bool
     * @return void
     */
    public function setSrvBool(stdClass|ServiceBOOL|null $srv_bool = null): void
    {
        $this->srv_bool = $srv_bool;
    }

    /**
     * Get service bool.
     *
     * @return stdClass|ServiceBOOL|null
     */
    public function getSrvBool(): stdClass|ServiceBOOL|null
    {
        return $this->srv_bool;
    }

    /**
     * Set service ade.
     *
     * @param string|null $srv_ade
     * @return void
     */
    public function setSrvAde(?string $srv_ade = null): void
    {
        $this->srv_ade = $srv_ade;
    }

    /**
     * Get service ade.
     *
     * @return string|null
     */
    public function getSrvAde(): ?string
    {
        return $this->srv_ade;
    }

    /**
     * Set service daw.
     *
     * @param stdClass|ServiceDAW|null $srv_daw
     * @return void
     */
    public function setSrvDaw(stdClass|ServiceDAW|null $srv_daw = null): void
    {
        $this->srv_daw = $srv_daw;
    }

    /**
     * Get service daw.
     *
     * @return stdClass|ServiceDAW|null
     */
    public function getSrvDaw(): stdClass|ServiceDAW|null
    {
        return $this->srv_daw;
    }

    /**
     * Set service ident.
     *
     * @param stdClass|ServiceIDENT|null $srv_ident
     * @return void
     */
    public function setSrvIdent(stdClass|ServiceIDENT|null $srv_ident = null): void
    {
        $this->srv_ident = $srv_ident;
    }

    /**
     * Get service ident.
     *
     * @return stdClass|ServiceIDENT|null
     */
    public function getSrvIdent(): stdClass|ServiceIDENT|null
    {
        return $this->srv_ident;
    }

    /**
     * Set service ppe.
     *
     * @param stdClass|ServicePPE|null $srv_ppe
     * @return void
     */
    public function setSrvPpe(stdClass|ServicePPE|null $srv_ppe = null): void
    {
        $this->srv_ppe = $srv_ppe;
    }

    /**
     * Get service ppe.
     *
     * @return stdClass|ServicePPE|null
     */
    public function getSrvPpe(): stdClass|ServicePPE|null
    {
        return $this->srv_ppe;
    }

    /**
     * Set service sds.
     *
     * @param stdClass|ServiceSDS|null $srv_sds
     * @return void
     */
    public function setSrvSds(stdClass|ServiceSDS|null $srv_sds = null): void
    {
        $this->srv_sds = $srv_sds;
    }

    /**
     * Get service sds.
     *
     * @return stdClass|ServiceSDS|null
     */
    public function getSrvSds(): stdClass|ServiceSDS|null
    {
        return $this->srv_sds;
    }

    /**
     * Set parcels.
     *
     * @param stdClass|ParcelsArray|null $parcels
     * @return void
     */
    public function setParcels(stdClass|ParcelsArray|null $parcels = null): void
    {
        $this->parcels = $parcels;
    }

    /**
     * Get parcels.
     *
     * @return stdClass|ParcelsArray|null
     */
    public function getParcels(): stdClass|ParcelsArray|null
    {
        return $this->parcels;
    }
}
