<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="funcion")
 * @ORM\HasLifecycleCallbacks
 */
class Funcion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="ID_FUNCION", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="FUNCION", type="string",nullable=false)
     */
    private $rol;

    /**
     * @ORM\Column(name="ESTADO", type="string", nullable=false)
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FuncionUsuario", mappedBy="idFuncion")
     */
    private $funcionUsuario;

    public function id($value = null)
    {
        if (!$value) {
            return $this->id;
        }

        $this->id = $value;

        return $this;
    }
    public function rol($value = null)
    {
        if (!$value) {
            return $this->rol;
        }

        $this->rol = $value;

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
