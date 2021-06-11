<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TramiteController extends AbstractController
{
    /**
     * @Route("/tramite", name="tramite")
     */
    public function index(): Response
    {
        return $this->render('usuario/registrarTramite.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }

    /**
     * @Route("/tipoTramite", name="tipo")
     */
    public function typeTramit(): Response
    {
        return $this->render('usuario/registrarTipoTramite.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }

}
