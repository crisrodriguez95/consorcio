<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActividadProceso extends AbstractController {

  /**
   * @Route("/actividad_proceso", name="actividadProceso");
   */
  public function index(): response {
    return $this->render("admin/asignarActividadProceso.html.twig");
  }

}