<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente_tramite")
 * @ORM\HasLifecycleCallbacks
 */

 class ClienteTramite {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   * @ORM\Column(name="ID_CLIENTETRAMITE", type="integer")
   */
  private $id;

   /**
   *@ORM\ManyToOne(targetEntity="App\Entity\Tramite", inversedBy="clienteTramite")
   *@ORM\JoinColumn(name="ID_TRAMITE", referencedColumnName="ID_TRAMITE")
   */
  private $idTramite;

  /**
   *@ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="clienteTramite")
   *@ORM\JoinColumn(name="ID_CLIENTE", referencedColumnName="ID_CLIENTE")
   */
  private $idCliente;

  /**
   * @ORM\Column(name="FUNCIONARIO", type="string", nullable=false)
   */

  private $funcionario;


  function id($value = null){
    if(!$value)
      return $this->id;

    $this->id = $value;
    return $this;
  }

  public function setIdTramite(Tramite $tramite): self {

    $this->idTramite = $tramite;
    return $this;
    
  }

  public function setIdCliente(Cliente $cliente): self {

    $this->idCliente = $cliente;
    return $this;

  }

  public function funcionario($value = null){
    if(!$value)
      return $this->funcionario;
    
    $this->funcionario = $value;
    return $this;

  }


 }




