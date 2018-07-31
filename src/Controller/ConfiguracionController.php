<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use App\Entity\Configuracion;

use App\Repository\ConfiguracionRepository;
use App\Service\ConfiguracionService;
use App\Service\MessageGenerator;

use Psr\Log\LoggerInterface;

/**
 * Class ConfiguracionController
 *
 * @Route("/api")
 */
class ConfiguracionController extends FOSRestController
{


/*    private $configuracionService;

    public function __construct(ConfiguracionService $configuracionService)
    {
        syslog(LOG_DEBUG,"CONSTRUCTOR");
        $this->configuracionService = $configuracionService;
    }
*/

    /**
     * @Rest\Get("/obtenerConfiguracion", name="obtener_configuracion")
     *   
     * @SWG\Response(
     *     response=200,
     *     description="List of coonfiguration successfully obtained "
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="List of coonfiguration was not successfully obtained "
     * )
     *
     * @SWG\Tag(name="Configuracion")
     */
    public function obtenerConfiguracionAction(Request $request) {

        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $entidad = [];
        $message = "";

        try {
            $code = 200;
            $error = false;

    //        $rep = $em->getRepository('App:Configuracion');
    //        $entidad = $rep->findAll(); 

            $entidad = $this->configuracionService->getConfiguracion(2);

            if (is_null($entidad)) {
                $entidad = [];
            }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all configurations - Error: {$ex->getMessage()}";
        }
        if(count($entidad) == 0){ $entidad = "No results"; }
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $entidad : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }

}