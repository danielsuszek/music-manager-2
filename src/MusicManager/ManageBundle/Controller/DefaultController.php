<?php

namespace MusicManager\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MusicManagerManageBundle:Default:index.html.twig');
    }
}
