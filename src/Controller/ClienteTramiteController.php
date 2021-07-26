<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteTramiteController extends AbstractController {

  /**
   * @Route("/cliente_tramite", name="clienteTramite");
   */
  public function index(): Response {
    return $this->render("admin/asignarClienteTramite.html.twig");
  }


}