<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use App\Entity\Rol;

/** 
 * @ORM\Entity
 * @ORM\Table(name="funcionario")
 * @ORM\HasLifecycleCallbacks
 */
class Usuario implements UserInterface
{
  /**
   * @ORM\Id   
   * @ORM\GeneratedValue(strategy="AUTO")    
   * @ORM\Column(name="ID_FUNC", type="integer")
   */
  private $id;

  /**
   * @ORM\OneToOne(targetEntity="Rol", mappedBy="rol")
   * @ORM\JoinColumn(name="ID_ROL", referencedColumnName="ID_ROL")
   */
  private $roles;

  /**       
   * @ORM\Column(name="CEDULA_FUN", type="integer",nullable=false)
   */
  private $cedula;

  /**       
   * @ORM\Column(name="NOMBRE", type="string",nullable=false)
   */
  private $nombre;

  /**       
   * @ORM\Column(name="APELLIDO", type="string",nullable=false)
   */
  private $apellido;

  /**       
   * @ORM\Column(name="EMAIL", type="string",nullable=false)
   */
  private $email;

  /**
   * @ORM\Column(name="salt",type="string", length=32, nullable=true)
   */
  private $salt;

  public function id($value = null)
  {
    if (!$value)
      return $this->id;

    $this->id = $value;

    return $this;
  }
  public function cedula($value = null)
  {
    if (!$value)
      return $this->cedula;

    $this->cedula = $value;

    return $this;
  }
  public function nombre($value = null)
  {
    if (!$value)
      return $this->nombre;

    $this->nombre = $value;

    return $this;
  }
  public function apellido($value = null)
  {
    if (!$value)
      return $this->apellido;

    $this->apellido = $value;

    return $this;
  }
  public function direccion($value = null)
  {
    if (!$value)
      return $this->direccion;

    $this->direccion = $value;

    return $this;
  }
  public function telefono($value = null)
  {
    if (!$value)
      return $this->telefono;

    $this->telefono = $value;

    return $this;
  }
  public function movil($value = null)
  {
    if (!$value)
      return $this->movil;

    $this->movil = $value;

    return $this;
  }
  public function email($value = null)
  {
    if (!$value)
      return $this->email;

    $this->email = $value;

    return $this;
  }

  public function getRoles()
  {
    if (empty($roles)) {
      $roles[] = 'ROLE_USER';
    }
    return array_unique($roles);
    return [
      $this->roles->rol()
    ];
  }
  public function getPassword()
  {
    return $this->password;
  }
  public function getSalt()
  {
    return $this->salt;
  }
  public function getUsername()
  {
    return $this->email;
  }
  public function eraseCredentials()
  {
  }
  public function encodePassword($raw, $salt)
  {
    if (\strlen($raw) > self::MAX_PASSWORD_LENGTH) {
    }

    // Ignore $salt, the auto-generated one is always the best

    $encoded = password_hash($raw, $this->algo, $this->options);

    if (72 < \strlen($raw) && 0 === strpos($encoded, '$2')) {
      // BCrypt encodes only the first 72 chars


      return $encoded;
    }
  }
}
