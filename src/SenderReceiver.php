<?php
/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 02/06/16
 * Time: 14:53
 */

namespace Savjee\BpostTrack;


class SenderReceiver
{
    private $countryCode;
    private $municipality;
    private $name;
    private $zipcode;

    public function __construct($countryCode, $municipality, $zipcode, $name = '')
    {
        $this->setCountryCode($countryCode);
        $this->setMunicipality($municipality);
        $this->setZipcode($zipcode);
        $this->setName($name);
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param mixed $municipality
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }
}