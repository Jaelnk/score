<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Annotation\IsGranted;

class AdminGestorController extends AbstractController
{
    
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
