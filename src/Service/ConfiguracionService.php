<?php
namespace App\Service;
use App\Inter\ConfiguracionRepositoryInterface;
use App\Entity\Configuracion;

final class ConfiguracionService
{
    private $configuracionRepository;

    public function __construct(ConfiguracionRepositoryInterface $configuracionRepository){
        $this->configuracionRepository = $configuracionRepository;
    }
    public function getConfiguracion(int $configuracionId): Configuracion
    {
        $configuracion = $this->configuracionRepository->findBy($configuracionId);
        if (!$configuracion) {
            throw new EntityNotFoundException('Configuracion with id '.$configuracionId.' does not exist!');
        }            
    }
   /* public function updateCat(Configuracion $configuracion): void
    {
        $this->configuracionRepository->save($configuracion);
        // Dispatch some event on every update
    }*/
}