<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ProcesoController extends AbstractController {

  /**
   * @Route("/proceso", name="proceso")
   */

   public function index(): Response {
     
    return $this->render("admin/crearProceso.html.twig", [
      "controller_name" => "UsuarioController"
    ]);

   }

}