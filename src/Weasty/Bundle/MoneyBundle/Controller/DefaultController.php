<?php

namespace Weasty\Bundle\MoneyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WeastyMoneyBundle:Default:index.html.twig', array('name' => $name));
    }
}
