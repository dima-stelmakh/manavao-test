<?php
namespace Bundles\UserBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class LocationFinder
{
    protected $requestStack;
    protected $ipServiceLink;

    private $info = array();

    private $error = false;

    public function __construct(RequestStack $requestStack, $ipServiceLink)
    {
        $this->requestStack = $requestStack;
        $this->ipServiceLink = $ipServiceLink;

    }

    public function getError(){
        return $this->error;
    }

    public function getCoordinatesByIp(){
        $coordinates = $this->getCoordinates();
        if ($this->error) {
            return false;
        }
        return $coordinates;
    }


    private function getCoordinates(){
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request->server->get('HTTP_X_REAL_IP');
        if (!$ip) {
            $ip = $request->getClientIp();
        }
        if ($ip) {
            try {
                $location = file_get_contents(str_replace('{IP}', $ip, $this->ipServiceLink));

                if ($location === false) {
                    $this->error = "Can't connect to get information by IP";
                } else {
                    $location = json_decode($location);
                    if (isset($location->latitude) && $location->latitude && isset($location->longitude) && $location->longitude) {
                        return array( 'lat' => $location->latitude, 'lng' => $location->longitude );
                    } else {
                        $this->error = "Can't find information for ".$ip;
                    }
                }
            } catch (Exception $e) {
                $this->error = $e->getMessage();
            }
        } else {
            $this->error = "Can't get the user ID";
        }
    }

}