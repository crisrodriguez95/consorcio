<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="funcion_usuario")
 * @ORM\HasLifecycleCallbacks
 */
class FuncionUsuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="ID_UF", type="integer")
     */
    private $id;
    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="funcionUsuario")
     *@ORM\JoinColumn(name="ID", referencedColumnName="id")
     */
    private $idUser;

    /**
     *@ORM\ManyToOne(targetEntity="App\Entity\Funcion", inversedBy="funcionUsuario")
     *@ORM\JoinColumn(name="ID_FUNCION", referencedColumnName="ID_FUNCION")
     */
    private $idFuncion;

    public function id($value = null)
    {
        if (!$value) {
            return $this->id;
        }

        $this->id = $value;

        return $this;
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

    public function setIdFuncion(Funcion $funcion): self
    {
        $this->idFuncion = $funcion;
        return $this;
    }

    public function getIdFuncion(): Funcion
    {
        return $this->idFuncion;
    }
}
