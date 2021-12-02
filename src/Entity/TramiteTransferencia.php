<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "tramite_transferencia")
 * @ORM\HasLifecycleCallbacks
 */

class TramiteTransferencia {

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
   * @ORM\Column(name = "ENAGENADO", type = "string", nullable = false)
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
  private $valoresMinucipio; 

  /**
   * @ORM\Column(name = "PETICION_VALORES", type = "string", nullable = false)
   */
  private $peticionValores; 
  /**
   * @ORM\Column(name = "PAGO_VALORES", type = "string", nullable = false)
   */
  private $pagoValores; 
  /**
   * @ORM\Column(name = "HORA_REUNION", type = "time", nullable = false)
   */
  private $horaReunion; 
  /**
   * @ORM\Column(name = "FECHA_REUNION", type = "date", nullable = false)
   */
  private $fechaReunion; 

  /**
   * @ORM\Column(name = "FECHA_EJECUCION", type = "date", nullable = false)
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
   * @ORM\Column(name = "DOCUMENTO_FIRMADO", type = "string", nullable = false)
   */
  private $documentoFirmado;
  
  /**
   * @ORM\Column(name = "ENTREGADA_NOTARIA", type = "string", nullable = false)
   */
  private $entregadaNotaria;
  /**
   * @ORM\Column(name = "ESCRITURA", type = "string", nullable = false)
   */
  private $subirEscritura;
  /**
   * @ORM\Column(name = "ENTREGADA_REGISTRO_PROPIEDAD", type = "string", nullable = false)
   */
  private $entregadaRegistroPropiedad;
  /**
   * @ORM\Column(name = "APROBACION_PAGOS", type = "string", nullable = false)
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
   * @ORM\Column(name = "SUBIR_INFORME", type = "string", nullable = false)
   */
  private $informeGastos;
  /**
   * @ORM\Column(name = "PAGO_GASTOS", type = "string", nullable = false)
   */
  private $pagoGastos; 



  /**
   * @ORM\Column(name = "OBSERVACION", type = "string", nullable = false)
   */
  private $observacion; 

  

  public function id($value = null){
    if(!$value)
      return $this->id;
    
    $this->id = $value;
    return $this;

  }

  public function setIdClienteTramite(
    ClienteTramite $ClienteTramite
): self {
    $this->idClienteTramite = $ClienteTramite;
    return $this;
}

public function getIdClienteTramite(): ClienteTramite
{
    return $this->idClienteTramite;
}
  
  public function cedula($value = null){
    if(!$value)
      return $this->cedula;
    
    $this->cedula = $value;
    return $this;

  }

  public function papeleta($value = null){
    if(!$value)
      return $this->papeleta;
    
    $this->papeleta = $value;
    return $this;

  }
  public function bienes($value = null){
    if(!$value)
      return $this->bienes;
    
    $this->bienes = $value;
    return $this;

  }

  public function Observa($value = null){
    if(!$value)
      return $this->observacion;
    
    $this->observacion = $value;
    return $this;

  }

}