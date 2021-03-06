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
                    } elseif ($tipo == 2) {
                        return new JsonResponse($this->updateTipoTramite());
                    } elseif ($tipo == 6) {
                        return new JsonResponse($this->deleteTipoTramite());
                    } elseif ($tipo == 7) {
                        return new JsonResponse($this->dataTipoTramite());
                    }
                }
            }
        }
        return $this->render('tramite/tipoTramiteTransferencia.html.twig');
    }

    // ----------------------Register tipo de trámite-----------------
    function registerTipoTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $tipoTramite = new TipoTramiteTransferencia();

        $tipoTramite->tramite($request->query->get('tipoTramite'));
        $tipoTramite->Observa($request->query->get('observacion'));
        $tipoTramite->pesoTiempo($request->query->get('tiempo'));
        $tipoTramite->pesoCarga($request->query->get('carga'));
        $tipoTramite->estado('Activo');
        $em->persist($tipoTramite);
        $em->flush();
    }

    // ----------------------Update tipo de trámite-----------------
    function updateTipoTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get('id');
        $tipo = $em->getRepository(TipoTramiteTransferencia::class)->find($id);

        $tipo->tramite($request->query->get('tipoTramite'));
        $tipo->Observa($request->query->get('observacion'));
        $tipo->pesoTiempo($request->query->get('tiempo'));
        $tipo->pesoCarga($request->query->get('carga'));
        $tipo->estado($request->query->get('estado'));

        $em->flush();
    }

    // -------------------- Delete tipo de trámite --------------------
    public function deleteTipoTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $tipoTramite = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->find($id);

        $tipoTramite->estado('Inactivo');
        $em->flush();
    }

    // -------------------- Data tipo de trámite --------------------

    public function dataTipoTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $tipo = $em->getRepository(TipoTramiteTransferencia::class)->find($id);

        $dato = [
            'tramite' => $tipo->tramite(),
            'observacion' => $tipo->Observa(),
            'tiempo' => $tipo->pesoTiempo(),
            'carga' => $tipo->pesoCarga(),
            'estado' => $tipo->estado(),
        ];

        $data = [
            'datooos' => $dato,
        ];

        return $data;
    }

    public function getTipoTramiteTransferencia()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoTramites = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->findAll();

        $campos = ['Trámite', 'Observación', 'Tiempo', 'Carga', 'Estado'];

        $tipos = [];
        foreach ($tipoTramites as $key => $data) {
            array_push($tipos, [
                $data->id(),
                $data->tramite(),
                $data->Observa(),
                $data->pesoTiempo(),
                $data->pesoCarga(),
                $data->estado(),
            ]);
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $tipos,
            'campos' => $campos,
            'crear' => 'Crear tipo de trámite',
            'tituloTabla' => 'TIPO DE TRÁMITE',
        ]);
    }
}
