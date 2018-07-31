<?php
namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectRepository;

use App\Inter\ConfiguracionRepositoryInterface;
use App\Entity\Configuracion;

final class ConfiguracionRepository implements ConfiguracionRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ObjectRepository
     */
    private $objectRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectRepository = $this->entityManager->getRepository(Configuracion::class);
    }
    
    public function findBy(int $configuracionId): Configuracion
    {
        $conf = $this->objectRepository->find($configuracionId);
        return $conf;
    }


 /*   public function findOneByValor(string $valor): Configuracion
    {
        $conf = $this->objectRepository
            ->findOneBy(['valor' => $valor]);
        return $conf;
    }
    public function save(Configuracion $configuracion): void
    {
        $this->entityManager->persist($configuracion);
        $this->entityManager->flush();
    }*/

}
