<?php

namespace Bundles\OptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Bundles\OptionBundle\Entity\StaticPage;

class StaticPageController extends Controller
{
    /**
     * @Route("/page/{slug}", name="static_page")
     */
    public function indexAction($slug)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository(StaticPage::class);
        $page = $repo->findOneBySlug($slug);

        if (null === $page) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
        }

        return $this->render('BundlesOptionBundle:StaticPage:index.html.twig', compact('page'));
    }
}
