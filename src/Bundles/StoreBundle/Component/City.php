<?php

namespace Bundles\StoreBundle\Component;

/**
 * City
 */
trait City
{
    /**
     * @var string
     */
    private $city;
    
    /**
     * @var string
     */
    private $lat = 0;

    /**
     * @var string
     */
    private $lng = 0;


    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return Advert
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return Advert
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Advert
     */
    public function setCity($city)
    {
        $this->city = $city;
        $this->setLocation();
        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    private function setLocation()
    {
        $city = str_replace(' ', '+', trim($this->getCity()));
        
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=$city&sensor=false";

        $ch = curl_init();
        // Disable SSL verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);
        
        $data = json_decode($result, true);
//        dump($data); die;
        
        if ($data['status'] == "OK") {
            $this->setLat($data['results'][0]['geometry']['location']['lat']);
            $this->setLng($data['results'][0]['geometry']['location']['lng']);
            return;
        } else {
            if ($data['status'] == "ZERO_RESULTS") {
                throw new \Exception("Google doesn't have information about this city: $city");
            }
            
            sleep(3);
            $this->setLocation();
        }
    }
}
