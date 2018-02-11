<?php

namespace MusicManager\ManageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomePageController extends Controller
{
    public function indexAction()
    {
//        return $this->render('MusicManagerManageBundle:HomePage:index.html.twig', array(
//        ));
        return $this->render('homepage/index.html.twig');
    }
    
    public function testBootstrapAction() 
    {
        return $this->render('homepage/testBootstrap.html.twig');
    }
    

}
