<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Funcion;
use App\Entity\User;
use App\Entity\FuncionUsuario;
use App\Services\ServiceReply;

class FuncionUsuarioController extends AbstractController
{
    /**
     * @Route("/funcionUsuario", name="funcionUsuario")
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
        return $this->render('funciones/funcionUsuario.html.twig');
    }

    public function register()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $user = $em
            ->getRepository(User::class)
            ->find($request->query->get('idusuario'));

        $funcion = $em
            ->getRepository(Funcion::class)
            ->find($request->query->get('idFuncion'));

        $funcionUsuario = new FuncionUsuario();

        $funcionUsuario->setIdUsuario($user);
        $funcionUsuario->setIdFuncion($funcion);

        $em->persist($funcionUsuario);
        $em->flush();

        return 'heythere';

        // die('<pre>'.print_r($request->query->get('cedula'),true).'</pre>');
    }

    public function getUser()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em
            ->getRepository(User::class)
            ->findBy(['estado' => 'Activo']);

        return $this->render('user/modal/_usuarios.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }
    public function getFuncion()
    {
        $em = $this->getDoctrine()->getManager();
        $funciones = $em
            ->getRepository(Funcion::class)
            ->findBy(['estado' => 'Activo']);

        return $this->render('funciones/modal/_funcion.html.twig', [
            'funciones' => $funciones,
        ]);
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
    public function getFuncionUsuarioList()
    {
        $em = $this->getDoctrine()->getManager();
        $funcionUsuarios = $em->getRepository(FuncionUsuario::class)->findAll();

        $campos = ['Nombre', 'Apellido', 'Email', 'Función'];
        $funciones = [];

        // $idClients = [];

        foreach ($funcionUsuarios as $key => $data) {
            $funciones[$key] = [
                $data->id(),
                $data->getIdUsuario()->getNombre(),
                $data->getIdUsuario()->getApellido(),
                $data->getIdUsuario()->getEmail(),
                $data->getIdFuncion()->rol(),
            ];
        }

        return $this->render('/components/_tabla.html.twig', [
            'datos' => $funciones,
            'campos' => $campos,
            'crear' => 'Asignar función al usuario',
            'tituloTabla' => 'Funciones',
        ]);
    }
}
