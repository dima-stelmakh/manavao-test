<?php
namespace AppBundle\Services;

class SiteManagement {
  static public function is_spt() {
    return (substr($_SERVER['HTTP_HOST'], 0, 5) == 'www.s');
  }
}