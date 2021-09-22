<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\TipoTramiteTransferencia;

class TipoTramiteTransferenciaController extends AbstractController
{
    /**
     * @Route("/tipoTramiteTransferencia", name = "tipoTransferencia")
     */
    public function getView(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registerTipoTramite());
                    }
                }
            }
        }

        return $this->render('admin/crearTipoTramiteTransferencia.html.twig');
    }

    function registerTipoTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();


				$tipoTramite = new TipoTramiteTransferencia();

				$tipoTramite->tramite($request->query->get('tramite'));
				$tipoTramite->Observa($request->query->get('descripcion'));

				$em->persist($tipoTramite);
				$em->flush();

    }
}
