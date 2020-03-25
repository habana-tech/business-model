<?php


namespace HabanaTech\BusinessModel\Services;

class LocationPoint
{

    private $longitude;
    private $latitude;

    /**
     * LocationPoint constructor
     * @param $longitude
     * @param $latitude
     */
    public function __construct($longitude = null, $latitude = null)
    {
        $this->longitude = $longitude;
        $this->latitude  = $latitude;
    }

    public function setFromLocationString($str)
    {
        $point = explode(',', $str);
        if (count($point) !== 2) {
            // Location not valid!
            return false;
        }

        $this->longitude = $point[0];
        $this->latitude  = $point[1];
        return $this;

    }


    public function getLocationString(): string
    {
        return $this->longitude.', '.$this->latitude;
    }


    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }


    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }


    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }


    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

}
