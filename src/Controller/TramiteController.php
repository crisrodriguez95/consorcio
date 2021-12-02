<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Tramite;
use App\Entity\TipoTramite;
use App\Entity\TramiteTransferencia;

class TramiteController extends AbstractController
{
    /**
     * @Route("/tramite", name="tramite")
     */
    public function getViewTramite(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registerTramite());
                    }
                }
            }
        }
        return $this->render('usuario/crearTramite.html.twig');
    }

    public function registerTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $tipoTramite = $em
            ->getRepository(TipoTramite::class)
            ->find($request->query->get('tipo_tramite'));

        $tramite = new Tramite();
        // relates this tramite to the tipoTramite
        $tramite->setTipoTramite($tipoTramite);
        $tramite->tramite($request->query->get('tramite'));
        $em->persist($tramite);
        $em->flush();

        return 'Saved new tramite';
    }

    public function getTipoTramite()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoTramite = $em->getRepository(TipoTramite::class)->findAll();

        return $this->render('/components/_tipoTramite.html.twig', [
            'tiposTramite' => $tipoTramite,
        ]);
    }

    /**
     * @Route("/procesotramite/{idTramite}", name="procesotramite", requirements={"idTramite"="\d+"})
     */
    public function getProcesoTramiteView(Request $request) {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registerTramite());
                    }
                }
            }
        }
        
        return $this->render('tramite/procesotramite.html.twig');
    }
    public function registerProcesoTramite() {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $clienteTramite= $em
            ->getRepository(ClienteTramite::class)
            ->find($request->query->get('tipo_tramite'));

        $tramiteTransferencia= new TramiteTransferencia();
        // relates this tramite to the tipoTramite
        $tramiteTransferencia->tramite($clienteTramite);
        $tramiteTransferencia->cedula($request->query->get('cedula'));
        $tramiteTransferencia->papeleta($request->query->get('papeleta'));
        $tramiteTransferencia->papeleta($request->query->get('bienes'));
       
        $em->persist($tramiteTransferencia);
        $em->flush();

        return 'Saved new tramite';
        
        
       
    }


}
