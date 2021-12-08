<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario_tramite")
 * @ORM\HasLifecycleCallbacks
 */
class UsuarioTramite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="ID_USUARIOTRAMITE", type="integer")
     */
    private $id;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\ClienteTramite", inversedBy="usuarioTramite")
     *@ORM\JoinColumn(name="ID_CLIENTETRAMITE", referencedColumnName="ID_CLIENTETRAMITE")
     */
    private $idClienteTramite;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="usuarioTramite")
     *@ORM\JoinColumn(name="ID_FUNC", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @ORM\Column(name = "ESTADO", type = "string", nullable = false)
     */
    private $estado;
    /**
     * @ORM\Column(name = "FECHA", type = "string", nullable = false)
     */
    private $fecha;
    /**
     * @ORM\Column(name = "DESCRIPCION", type = "string", nullable = false)
     */
    private $descripcion;
    /**
     * @ORM\Column(name = "ESTADO_PROCESO", type = "string", nullable = false)
     */
    private $estadoProceso;

    public function setIdClienteTramite(ClienteTramite $clienteTramite): self
    {
        $this->idClienteTramite = $clienteTramite;
        return $this;
    }

    public function getIdClienteTramite(): ClienteTramite
    {
        return $this->idClienteTramite;
    }

    public function setIdUsuario(User $user): self
    {
        $this->idUser = $user;
        return $this;
    }

    public function getIdUsuario(): User
    {
        return $this->idUser;
    }

    function id($value = null)
    {
        if (!$value) {
            return $this->id;
        }

        $this->id = $value;
        return $this;
    }
    function estado($value = null)
    {
        if (!$value) {
            return $this->estado;
        }

        $this->estado = $value;
        return $this;
    }
    function fecha($value = null)
    {
        if (!$value) {
            return $this->fecha;
        }

        $this->fecha = $value;
        return $this;
    }
    function describe($value = null)
    {
        if (!$value) {
            return $this->descripcion;
        }

        $this->descripcion = $value;
        return $this;
    }

    function estadoProceso($value = null)
    {
        if (!$value) {
            return $this->estadoProceso;
        }

        $this->estadoProceso = $value;
        return $this;
    }
}
