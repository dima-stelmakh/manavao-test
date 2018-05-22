<?php

namespace Bundles\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BundlesImageBundle:Default:index.html.twig');
    }
}
