<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Funcion;
use App\Services\ServiceReply;

class FuncionController extends AbstractController
{
    /**
     * @Route("/funciones", name="funcion")
     */
    public function getView(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse($this->register());
                    } elseif ($tipo == 2) {
                        return new JsonResponse($this->updateFuncion());
                    } elseif ($tipo == 6) {
                        return new JsonResponse($this->deleteFuncion());
                    } elseif ($tipo == 7) {
                        return new JsonResponse($this->dataFuncion());
                    }
                }
            }
        }
        return $this->render('funciones/index.html.twig');
    }

    public function register()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $funcion = new Funcion();

        $funcion->rol($request->query->get('rol'));
        $funcion->estado('Activo');

        $em->persist($funcion);
        $em->flush();

        return 'heythere';

        // die('<pre>'.print_r($request->query->get('cedula'),true).'</pre>');
    }

    // -------------------- Delete funcion --------------------
    public function deleteFuncion()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $funcion = $em->getRepository(funcion::class)->find($id);

        $funcion->estado('Inactivo');
        $em->flush();
    }
    // -------------------- update funcion --------------------

    public function updateFuncion()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $id = $request->query->get('id');
        $funcion = $em->getRepository(funcion::class)->find($id);

        $funcion->rol($request->query->get('rol'));
        $funcion->estado($request->query->get('estado'));
        $em->flush();
    }

    public function dataFuncion()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();
        $funcion = $em->getRepository(funcion::class)->find($id);

        $dato = [
            'funcion' => $funcion->rol(),
            'estado' => $funcion->estado(),
        ];

        $data = [
            'datooos' => $dato,
        ];

        return $data;
    }

    // -------------------- Rendering funcions --------------------
    public function getFuncionList()
    {
        $em = $this->getDoctrine()->getManager();
        $func = $em->getRepository(Funcion::class)->findAll();

        $campos = ['Función', 'Estado'];
        $funciones = [];

        // $idClients = [];

        foreach ($func as $key => $data) {
            $funciones[$key] = [$data->id(), $data->rol(), $data->estado()];
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $funciones,
            'campos' => $campos,
            'crear' => 'Crear nueva función',
            'tituloTabla' => 'Funciones',
        ]);
    }
}
