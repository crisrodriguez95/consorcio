<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\UsuarioTramite;
use App\Entity\User;

class UsuarioTramiteController extends AbstractController
{
    /**
     * @Route("/usuarioTramite", name="usuarioTramite");
     */

    public function getViewTramite(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            if ($request->getMethod() == 'GET') {
                $tipo = $request->query->get('tipo');
                if ($tipo) {
                    if ($tipo == 1) {
                        return new JsonResponse(
                            $this->registerUsuarioTramite()
                        );
                    }
                }
            }
        }
        return $this->render('tramite/usuarioTramite.html.twig');
    }

    public function registerUsuarioTramite()
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $em = $this->getDoctrine()->getManager();

        $cliente = $em
            ->getRepository(Cliente::class)
            ->find($request->query->get('cliente'));
        $TipoTramite = $em
            ->getRepository(TipoTramiteTransferencia::class)
            ->find($request->query->get('tipo_tramite'));

        $clienteTramite = new ClienteTramite();

        $clienteTramite->setIdCliente($cliente);
        $clienteTramite->setIdTipoTramite($TipoTramite);
        $clienteTramite->fechaInicio(date('Y-m-d'));

        $em->persist($clienteTramite);
        $em->flush();
    }

    public function getUser()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('/components/usuario/_usuario.html.twig', [
            'usuarios' => $users,
        ]);
    }
    public function getClienteTramite()
    {
        $em = $this->getDoctrine()->getManager();
        $usuariosTramite = $em->getRepository(UsuarioTramite::class)->findAll();
        dd($usuariosTramite);
        return $this->render('/components/usuario/_usuario.html.twig', [
            'clienteTramite' => $usuariosTramite,
        ]);
    }

    public function getUsuarioTramiteList()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarioTramites = $em->getRepository(UsuarioTramite::class)->findAll();

        $campos = [
            'Usuario',
            'Nombre',
            'Apellido',
            'Cliente',
            'Nombre',
            'Apellido',
            'Tipo de Trámite',
            'Fecha',
        ];
        $usuariosTramite = [];

        foreach ($usuarioTramites as $key => $data) {
            // dd($data->getIdClienteTramite()->id());
            $usuariosTramite[$key] = [
                $data->getIdUsuario()->getCedula(),
                $data->getIdUsuario()->getNombre(),
                $data->getIdUsuario()->getApellido(),

                $data
                    ->getIdClienteTramite()
                    ->getIdCliente()
                    ->cedula(),
                $data
                    ->getIdClienteTramite()
                    ->getIdCliente()
                    ->nombre(),
                $data
                    ->getIdClienteTramite()
                    ->getIdCliente()
                    ->apellido(),

                $data
                    ->getIdClienteTramite()
                    ->getIdTipoTramiteTransferencia()
                    ->tramite(),

                $data->fecha(),
            ];
        }

        return $this->render('tramite/modal/_tabla.html.twig', [
            'datos' => $usuariosTramite,
            'campos' => $campos,
            'crear' => ' Asignar usuario',
            'tituloTabla' => 'Asignacion',
        ]);
    }
}
