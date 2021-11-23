<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cliente_tramite")
 * @ORM\HasLifecycleCallbacks
 */
class ClienteTramite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="ID_CLIENTETRAMITE", type="integer")
     */
    private $id;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="clienteTramite")
     *@ORM\JoinColumn(name="ID_CLIENTE", referencedColumnName="ID_CLIENTE")
     */
    private $idCliente;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\TipoTramiteTransferencia", inversedBy="clienteTramite")
     *@ORM\JoinColumn(name="ID_TRAMITE", referencedColumnName="ID_TRAMITE")
     */
    private $idTipoTramite;

    /**
     * @ORM\Column(name = "FECHA_INICIO", type = "string", nullable = false)
     */
    private $fechaInicio;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UsuarioTramite", mappedBy="idClienteTramite")
     */
    private $usuarioTramite;

    function id($value = null)
    {
        if (!$value) {
            return $this->id;
        }

        $this->id = $value;
        return $this;
    }

    public function setIdCliente(Cliente $cliente): self
    {
        $this->idCliente = $cliente;
        return $this;
    }

    public function getIdCliente(): Cliente
    {
        return $this->idCliente;
    }

    public function setIdTipoTramite(
        TipoTramiteTransferencia $TipoTramite
    ): self {
        $this->idTipoTramite = $TipoTramite;
        return $this;
    }

    public function getIdTipoTramiteTransferencia(): TipoTramiteTransferencia
    {
        return $this->idTipoTramite;
    }

    public function fechaInicio($value = null)
    {
        if (!$value) {
            return $this->fechaInicio;
        }

        $this->fechaInicio = $value;
        return $this;
    }
}
