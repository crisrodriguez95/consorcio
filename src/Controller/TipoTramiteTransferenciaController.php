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
        return $this->render('tramite/tipoTramiteTransferencia.html.twig');
    }

    function registerTipoTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $tipoTramite = new TipoTramiteTransferencia();

        $tipoTramite->tramite($request->query->get('tipoTramite'));
        $tipoTramite->Observa($request->query->get('observacion'));
        $tipoTramite->pesoTiempo($request->query->get('tiempo'));
        $tipoTramite->pesoCarga($request->query->get('carga'));
        $em->persist($tipoTramite);
        $em->flush();
    }

    public function getTipoTramiteTransferencia()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoTramites = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->findAll();

        $campos = ['Trámite', 'Observación'];

        $tipos = [];
        foreach ($tipoTramites as $key => $data) {
            array_push($tipos, [$data->tramite(), $data->Observa()]);
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $tipos,
            'campos' => $campos,
            'crear' => 'Crear tipo de trámite',
            'tituloTabla' => 'TIPO DE TRÁMITE',
        ]);
    }
}
