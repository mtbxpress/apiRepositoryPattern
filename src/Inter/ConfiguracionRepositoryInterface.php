<?php
namespace App\Inter;

use App\Entity\Configuracion;

interface ConfiguracionRepositoryInterface
{
    public function findBy(int $configuracionId): Configuracion;
    
 //   public function findOneByValor(string $valor): Configuracion;
 //   public function save(Configuracion $Configuracion): void;
}

