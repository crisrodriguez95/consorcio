<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "tramite_transferencia")
 * @ORM\HasLifecycleCallbacks
 */

class TramiteTransferencia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name = "ID_TRANSFERENCIA", type = "integer")
     */
    private $id;
    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\ClienteTramite", inversedBy="tramiteTransferencia")
     *@ORM\JoinColumn(name="ID_CLIENTETRAMITE", referencedColumnName="ID_CLIENTETRAMITE")
     */
    private $idClienteTramite;

    /**
     * @ORM\Column(name = "COPIA_CEDULA", type = "string", nullable = false)
     */
    private $cedula;
    /**
     * @ORM\Column(name = "COPIA_PAPELETA", type = "string", nullable = false)
     */
    private $papeleta;
    /**
     * @ORM\Column(name = "ESCRITURA_BIENES", type = "string", nullable = false)
     */
    private $escrituraBienes;
    /**
     * @ORM\Column(name = "ENAJENADO", type = "string", nullable = false)
     */
    private $estaEnagenado;
    /**
     * @ORM\Column(name = "MINUTA", type = "string", nullable = false)
     */
    private $minuta;

    /**
     * @ORM\Column(name = "INSINUACION_DONACION", type = "string", nullable = false)
     */
    private $insinuacionDonacion;

    /**
     * @ORM\Column(name = "VALORES_MUNICIPIO", type = "string", nullable = false)
     */
    private $valoresMunicipio;

    /**
     * @ORM\Column(name = "PETICION_VALORES", type = "string", nullable = false)
     */
    private $peticionValores;
    /**
     * @ORM\Column(name = "PAGO_VALORES", type = "string", nullable = false)
     */
    private $pagoValores;
    /**
     * @ORM\Column(name = "HORA_REUNION", type = "string", nullable = false)
     */
    private $horaReunion;
    /**
     * @ORM\Column(name = "FECHA_REUNION", type = "string", nullable = false)
     */
    private $fechaReunion;

    /**
     * @ORM\Column(name = "FECHA_EJECUCION", type = "string", nullable = false)
     */
    private $fechaEjecucion;
    /**
     * @ORM\Column(name = "RETRASO", type = "string", nullable = false)
     */
    private $retraso;
    /**
     * @ORM\Column(name = "PAGO_TASA_NOTARIAL", type = "string", nullable = false)
     */
    private $pagoTasaNotarial;
    /**
     * @ORM\Column(name = "PAGO_COMPLETO", type = "string", nullable = false)
     */
    private $pagoCompleto;

    /**
     * @ORM\Column(name = "ES_MUTUALISTA", type = "string", nullable = false)
     */
    private $esMutualista;
    /**
     * @ORM\Column(name = "ENTREGADO_MUTUALISTA", type = "string", nullable = false)
     */
    private $entregadoMutualista;

    /**
     * @ORM\Column(name = "FIRMA_DOCUMENTO", type = "string", nullable = false)
     */
    private $documentoFirmado;

    /**
     * @ORM\Column(name = "ENTREGADA_NOTARIA", type = "string", nullable = false)
     */
    private $entregadaNotaria;
    /**
     * @ORM\Column(name = "SUBIR_ESCRITURA", type = "string", nullable = false)
     */
    private $subirEscritura;
    /**
     * @ORM\Column(name = "DOCUMENTOS_ENTREGADOS_REGISTRO_PROPIEDAD", type = "string", nullable = false)
     */
    private $entregadaRegistroPropiedad;
    /**
     * @ORM\Column(name = "APROBACION_VALORES", type = "string", nullable = false)
     */
    private $clienteAprueba;
    /**
     * @ORM\Column(name = "TITULO_ENTREGADO", type = "string", nullable = false)
     */
    private $tituloPagoEntregado;
    /**
     * @ORM\Column(name = "TITULO_PAGO", type = "string", nullable = false)
     */
    private $tituloPago;
    /**
     * @ORM\Column(name = "ESCRITURA_VALIDA", type = "string", nullable = false)
     */
    private $escrituraValida;
    /**
     * @ORM\Column(name = "SUBIR_ACTA", type = "string", nullable = false)
     */
    private $actaInscripcion;
    /**
     * @ORM\Column(name = "INFORME_GASTOS", type = "string", nullable = false)
     */
    private $informeGastos;
    /**
     * @ORM\Column(name = "PAGO_GASTOS", type = "string", nullable = false)
     */
    private $pagoGastos;

    /**
     * @ORM\Column(name = "OBSERVACIONES", type = "string", nullable = false)
     */
    private $observacion;

    public function id($value = null)
    {
        if (!$value) {
            return $this->id;
        }

        $this->id = $value;
        return $this;
    }

    public function setIdClienteTramite(ClienteTramite $ClienteTramite): self
    {
        $this->idClienteTramite = $ClienteTramite;
        return $this;
    }

    public function getIdClienteTramite(): ClienteTramite
    {
        return $this->idClienteTramite;
    }

    public function cedula($value = null)
    {
        if (!$value) {
            return $this->cedula;
        }

        $this->cedula = $value;
        return $this;
    }

    public function papeleta($value = null)
    {
        if (!$value) {
            return $this->papeleta;
        }

        $this->papeleta = $value;
        return $this;
    }
    public function escrituraBienes($value = null)
    {
        if (!$value) {
            return $this->escrituraBienes;
        }

        $this->escrituraBienes = $value;
        return $this;
    }

    public function estaEnagenado($value = null)
    {
        if (!$value) {
            return $this->estaEnagenado;
        }

        $this->estaEnagenado = $value;
        return $this;
    }

    public function minuta($value = null)
    {
        if (!$value) {
            return $this->minuta;
        }

        $this->minuta = $value;
        return $this;
    }

    public function insinuacionDonacion($value = null)
    {
        if (!$value) {
            return $this->insinuacionDonacion;
        }

        $this->insinuacionDonacion = $value;
        return $this;
    }

    public function valoresMunicipio($value = null)
    {
        if (!$value) {
            return $this->valoresMunicipio;
        }

        $this->valoresMunicipio = $value;
        return $this;
    }

    public function peticionValores($value = null)
    {
        if (!$value) {
            return $this->peticionValores;
        }

        $this->peticionValores = $value;
        return $this;
    }

    public function pagoValores($value = null)
    {
        if (!$value) {
            return $this->pagoValores;
        }

        $this->pagoValores = $value;
        return $this;
    }

    public function horaReunion($value = null)
    {
        if (!$value) {
            return $this->horaReunion;
        }

        $this->horaReunion = $value;
        return $this;
    }

    public function fechaReunion($value = null)
    {
        if (!$value) {
            return $this->fechaReunion;
        }

        $this->fechaReunion = $value;
        return $this;
    }

    public function fechaEjecucion($value = null)
    {
        if (!$value) {
            return $this->fechaEjecucion;
        }

        $this->fechaEjecucion = $value;
        return $this;
    }

    public function retraso($value = null)
    {
        if (!$value) {
            return $this->retraso;
        }

        $this->retraso = $value;
        return $this;
    }
    public function pagoTasaNotarial($value = null)
    {
        if (!$value) {
            return $this->pagoTasaNotarial;
        }

        $this->pagoTasaNotarial = $value;
        return $this;
    }

    public function pagoCompleto($value = null)
    {
        if (!$value) {
            return $this->pagoCompleto;
        }

        $this->pagoCompleto = $value;
        return $this;
    }
    public function esMutualista($value = null)
    {
        if (!$value) {
            return $this->esMutualista;
        }

        $this->esMutualista = $value;
        return $this;
    }
    public function entregadoMutualista($value = null)
    {
        if (!$value) {
            return $this->entregadoMutualista;
        }

        $this->entregadoMutualista = $value;
        return $this;
    }

    public function documentoFirmado($value = null)
    {
        if (!$value) {
            return $this->documentoFirmado;
        }

        $this->documentoFirmado = $value;
        return $this;
    }
    public function entregadaNotaria($value = null)
    {
        if (!$value) {
            return $this->entregadaNotaria;
        }

        $this->entregadaNotaria = $value;
        return $this;
    }
    public function subirEscritura($value = null)
    {
        if (!$value) {
            return $this->subirEscritura;
        }

        $this->subirEscritura = $value;
        return $this;
    }

    public function entregadaRegistroPropiedad($value = null)
    {
        if (!$value) {
            return $this->entregadaRegistroPropiedad;
        }

        $this->entregadaRegistroPropiedad = $value;
        return $this;
    }

    public function clienteAprueba($value = null)
    {
        if (!$value) {
            return $this->clienteAprueba;
        }

        $this->clienteAprueba = $value;
        return $this;
    }
    public function tituloPagoEntregado($value = null)
    {
        if (!$value) {
            return $this->tituloPagoEntregado;
        }

        $this->tituloPagoEntregado = $value;
        return $this;
    }

    public function tituloPago($value = null)
    {
        if (!$value) {
            return $this->tituloPago;
        }

        $this->tituloPago = $value;
        return $this;
    }

    public function escrituraValida($value = null)
    {
        if (!$value) {
            return $this->escrituraValida;
        }

        $this->escrituraValida = $value;
        return $this;
    }

    public function actaInscripcion($value = null)
    {
        if (!$value) {
            return $this->actaInscripcion;
        }

        $this->actaInscripcion = $value;
        return $this;
    }

    public function informeGastos($value = null)
    {
        if (!$value) {
            return $this->informeGastos;
        }

        $this->informeGastos = $value;
        return $this;
    }

    public function pagoGastos($value = null)
    {
        if (!$value) {
            return $this->pagoGastos;
        }

        $this->pagoGastos = $value;
        return $this;
    }

    public function Observa($value = null)
    {
        if (!$value) {
            return $this->observacion;
        }

        $this->observacion = $value;
        return $this;
    }
}
