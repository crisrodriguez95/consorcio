<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\UsuarioTramite;
use App\Entity\TramiteTransferencia;
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

    public function getUsuarioTramiteList()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarioTramites = $em
            ->getRepository(UsuarioTramite::class)
            ->findBy(['estado' => 'Y']);

        $i = 0;
        $tramiteTransferencia = $em
            ->getRepository(TramiteTransferencia::class)
            ->findAll();

        $tramiteCamposLlenos = [];

        foreach ($tramiteTransferencia as $tramite) {
            if ($tramite->cedula() == 'true') {
                $i++;
            }

            if ($tramite->papeleta() == 'true') {
                $i++;
            }
            if ($tramite->escrituraBienes() == 'true') {
                $i++;
            }
            if ($tramite->estaEnagenado() == 'true') {
                $i++;
            }
            if ($tramite->minuta()) {
                $i++;
            }
            if ($tramite->insinuacionDonacion()) {
                $i++;
            }
            if ($tramite->valoresMunicipio()) {
                $i++;
            }
            if ($tramite->peticionValores() == 'true') {
                $i++;
            }
            if ($tramite->pagoValores()) {
                $i++;
            }
            if ($tramite->horaReunion()) {
                $i++;
            }
            if ($tramite->fechaReunion()) {
                $i++;
            }
            if ($tramite->fechaEjecucion()) {
                $i++;
            }
            if ($tramite->retraso()) {
                $i++;
            }
            if ($tramite->pagoTasaNotarial()) {
                $i++;
            }
            if ($tramite->pagoCompleto() == 'true') {
                $i++;
            }
            if ($tramite->esMutualista() == 'true') {
                $i++;
            }
            if ($tramite->entregadoMutualista() == 'true') {
                $i++;
            }
            if ($tramite->documentoFirmado()) {
                $i++;
            }
            if ($tramite->entregadaNotaria() == 'true') {
                $i++;
            }
            if ($tramite->subirEscritura()) {
                $i++;
            }
            if ($tramite->entregadaRegistroPropiedad() == 'true') {
                $i++;
            }
            if ($tramite->clienteAprueba() == 'true') {
                $i++;
            }
            if ($tramite->tituloPagoEntregado() == 'true') {
                $i++;
            }
            if ($tramite->tituloPago() == 'true') {
                $i++;
            }
            if ($tramite->escrituraValida() == 'true') {
                $i++;
            }
            if ($tramite->actaInscripcion()) {
                $i++;
            }
            if ($tramite->informeGastos()) {
                $i++;
            }
            if ($tramite->pagoGastos() == 'true') {
                $i++;
            }
            if ($tramite->Observa()) {
                $i++;
            }
            $tramiteCamposLlenos[$tramite->getIdClienteTramite()->id()] = [$i];
            $i = 0;
        }

        $campos = [
            'Código',
            'Usuario',
            'Nombre',
            'Apellido',
            'Cliente',
            'Nombre',
            'Apellido',
            'Tipo de Trámite',
            'Fecha',
            'Estado',
            'Progreso',
            '  ',
        ];

        $usuariosTramite = [];

        foreach ($usuarioTramites as $key => $data) {
            $idClienteTramite = $data->getIdClienteTramite()->id();

            $usuariosTramite[$key] = [
                $data->id(),
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
                $data->estadoProceso(),
                $tramiteCamposLlenos[$idClienteTramite][0],
            ];
        }

        return $this->render('tramite/modal/_tabla.html.twig', [
            'datos' => $usuariosTramite,
            'campos' => $campos,
            'crear' => ' Aún no tiene trámites asignados',
            'tituloTabla' => 'Todos los tramites asignados',
        ]);
    }
    /**
     * @Route("/usuarioTramiteIndividual", name="usuarioTramiteIndividual");
     */
    public function getViewTramitePorUsuario(Request $request)
    {
        return $this->render('tramite/usuarioTramiteIndividual.html.twig');
    }

    public function getUsuarioTramiteListPorUser(UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $usuarioTramites = $em
            ->getRepository(UsuarioTramite::class)
            ->findBy(['idUser' => $user->getId(), 'estado' => 'Y']);

        $i = 0;
        $tramiteTransferencia = $em
            ->getRepository(TramiteTransferencia::class)
            ->findAll();

        $tramiteCamposLlenos = [];

        foreach ($tramiteTransferencia as $tramite) {
            if ($tramite->cedula() == 'true') {
                $i++;
            }

            if ($tramite->papeleta() == 'true') {
                $i++;
            }
            if ($tramite->escrituraBienes() == 'true') {
                $i++;
            }
            if ($tramite->estaEnagenado() == 'true') {
                $i++;
            }
            if ($tramite->minuta()) {
                $i++;
            }
            if ($tramite->insinuacionDonacion()) {
                $i++;
            }
            if ($tramite->valoresMunicipio()) {
                $i++;
            }
            if ($tramite->peticionValores() == 'true') {
                $i++;
            }
            if ($tramite->pagoValores()) {
                $i++;
            }
            if ($tramite->horaReunion()) {
                $i++;
            }
            if ($tramite->fechaReunion()) {
                $i++;
            }
            if ($tramite->fechaEjecucion()) {
                $i++;
            }
            if ($tramite->retraso()) {
                $i++;
            }
            if ($tramite->pagoTasaNotarial()) {
                $i++;
            }
            if ($tramite->pagoCompleto() == 'true') {
                $i++;
            }
            if ($tramite->esMutualista() == 'true') {
                $i++;
            }
            if ($tramite->entregadoMutualista() == 'true') {
                $i++;
            }
            if ($tramite->documentoFirmado()) {
                $i++;
            }
            if ($tramite->entregadaNotaria() == 'true') {
                $i++;
            }
            if ($tramite->subirEscritura()) {
                $i++;
            }
            if ($tramite->entregadaRegistroPropiedad() == 'true') {
                $i++;
            }
            if ($tramite->clienteAprueba() == 'true') {
                $i++;
            }
            if ($tramite->tituloPagoEntregado() == 'true') {
                $i++;
            }
            if ($tramite->tituloPago() == 'true') {
                $i++;
            }
            if ($tramite->escrituraValida() == 'true') {
                $i++;
            }
            if ($tramite->actaInscripcion()) {
                $i++;
            }
            if ($tramite->informeGastos()) {
                $i++;
            }
            if ($tramite->pagoGastos() == 'true') {
                $i++;
            }
            if ($tramite->Observa()) {
                $i++;
            }
            $tramiteCamposLlenos[$tramite->getIdClienteTramite()->id()] = [$i];
            $i = 0;
        }

        $campos = [
            'Código',
            'Usuario',
            'Nombre',
            'Apellido',
            'Cliente',
            'Nombre',
            'Apellido',
            'Tipo de Trámite',
            'Fecha',
            'Estado',
            'Progreso',
            '  ',
        ];

        $usuariosTramite = [];

        foreach ($usuarioTramites as $key => $data) {
            $idClienteTramite = $data->getIdClienteTramite()->id();

            $usuariosTramite[$key] = [
                $data->id(),
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
                $data->estadoProceso(),
                $tramiteCamposLlenos[$idClienteTramite][0],
            ];
        }

        return $this->render('tramite/modal/_tabla.html.twig', [
            'datos' => $usuariosTramite,
            'campos' => $campos,
            'crear' => ' Aún no tiene trámites asignados',
            'tituloTabla' => 'Tramites asignados a mi',
        ]);
    }
}
