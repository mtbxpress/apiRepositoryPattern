<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configuracion
 *
 * @ORM\Table(name="configuracion", uniqueConstraints={@ORM\UniqueConstraint(name="clave_unica", columns={"clave"})})
 * @ORM\Entity(repositoryClass="App\Repository\ConfiguracionRepository")
 */
class Configuracion
{
    const CONFIGURACION_IDIOMA_ESPANOL = '1';
    const CONFIGURACION_IDIOMA_INGLES  = '2';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=255, nullable=false)
     */
    private $clave;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255, nullable=false)
     */
    private $valor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }


}
