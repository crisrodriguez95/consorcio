<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActividadController extends AbstractController {

  /**
   * @Route("/actividad", name="actividad");
   */
  public function index(): Response {
    return $this->render("admin/crearActividad.html.twig");
  }


}