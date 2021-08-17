<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


use App\Entity\TipoTramite;
use App\Entity\Tramite;

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
                        return new JsonResponse($this->registrarTramite());
                    }
                }
            }
        }
        return $this->render('usuario/registrarTramite.html.twig');
    }

    public function registrarTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();


        $tipoTramite = $em->getRepository(TipoTramite::class)
                       ->find($request->query->get("tipo_tramite"));
       
        // dd($tipoTramite);
        $tramite = new Tramite();
         // relates this tramite to the tipoTramite
        $tramite->setTipoTramite($tipoTramite);
        $tramite->tramite($request->query->get('tramite'));
        // $em->persist($tipoTramite);
        $em->persist($tramite);
        $em->flush();

        return "Saved new tramite";
    }

    public function getTipoTramite()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoTramite = $em->getRepository(TipoTramite::class)->findAll();

        return $this->render('/components/_tramite.html.twig', ["tiposTramite" => $tipoTramite]);
    }


    /**
     * @Route("/tipoTramite", name="tipo")
     */
    public function getViewType(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->registrar());
                    }
                }
            }
        }
        return $this->render('usuario/registrarTipoTramite.html.twig');
    }

    public function registrar()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        // die('<pre>'.print_r($request->query->get('cedula'),true).'</pre>');

        // if (
        //     $this->getDoctrine()
        //         ->getRepository(TipoTramite::class)
        //         ->find($request->query->get('id'))
        // ) {
        //     return 'El cliente que desea registrar ya esta registrado';
        // }

        $tipo_tramite = new TipoTramite();

        $tipo_tramite->tipoTramite($request->query->get('tipoTramite'));
        $em->persist($tipo_tramite);
        $em->flush();

        return 'heythere';
    }
}
