<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "Tipos_Tramite_Transferencia")
 * @ORM\HasLifecycleCallbacks
 */

class TipoTramiteTransferencia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name = "ID_TRAMITE", type = "integer")
     */
    private $id;

    /**
     * @ORM\Column(name = "TRAMITE", type = "string", nullable = false)
     */
    private $tramite;

    /**
     * @ORM\Column(name = "OBSERVACION", type = "string", nullable = false)
     */
    private $observacion;
    /**
     * @ORM\Column(name = "PESOTIEMPO", type = "string", nullable = false)
     */
    private $pesoTiempo;
    /**
     * @ORM\Column(name = "PESOCARGA", type = "string", nullable = false)
     */
    private $pesoCarga;
    /**
     * @ORM\Column(name = "ESTADO", type = "string", nullable = false)
     */
    private $estado;

    /**
     *@ORM\OneToMany(targetEntity="App\Entity\ClienteTramite", mappedBy="idTipoTramite")
     */
    private $clienteTramite;

    public function id($value = null)
    {
        if (!$value) {
            return $this->id;
        }

        $this->id = $value;
        return $this;
    }

    public function tramite($value = null)
    {
        if (!$value) {
            return $this->tramite;
        }

        $this->tramite = $value;
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
    public function pesoTiempo($value = null)
    {
        if (!$value) {
            return $this->pesoTiempo;
        }

        $this->pesoTiempo = $value;
        return $this;
    }
    public function pesoCarga($value = null)
    {
        if (!$value) {
            return $this->pesoCarga;
        }

        $this->pesoCarga = $value;
        return $this;
    }
    public function estado($value = null)
    {
        if (!$value) {
            return $this->estado;
        }

        $this->estado = $value;
        return $this;
    }
}
