<?php

namespace Bundles\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BundlesUserBundle:Default:index.html.twig');
    }
}
