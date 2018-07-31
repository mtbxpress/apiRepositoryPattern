<?php

namespace App\Controller;

use App\Entity\Board;
use App\Entity\Task;
use App\Entity\User;
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
use App\Entity\Formula;
use App\Entity\Componente;
/**
 * Class ApiController
 *
 * @Route("/api")
 */
class ApiController extends FOSRestController
{
    // USER URI's

    /**
     * @Rest\Post("/login_check", name="user_login_check")
     *
     * @SWG\Response(
     *     response=200,
     *     description="User was logged in successfully"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="User was not logged in successfully"
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={
     *     }
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="body",
     *     type="string",
     *     description="The password",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function getLoginCheckAction(Request $request) {//

    }


    /**
     * @Rest\Post("/register", name="user_register")
     *
     * @SWG\Response(
     *     response=201,
     *     description="User was successfully registered"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="User was not successfully registered"
     * )
     *
     * @SWG\Parameter(
     *     name="_name",
     *     in="body",
     *     type="string",
     *     description="The name",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="The email",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="The password"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $user = [];
        $message = "";

        try {
            $code = 200;
            $error = false;

            $name = $request->request->get('_name');
            $email = $request->request->get('_email');
            $username = $request->request->get('_username');
            $password = $request->request->get('_password');

            $user = new User();
            $user->setName($name);
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPlainPassword($password);
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setPassword($encoder->encodePassword($user, $password));
        //    $user->setPassword($password);

            $em->persist($user);
            $em->flush();

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to register the user - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $user : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }
// -------------------------------------------------------------------------------

    /**
     * @Rest\Get("/prueba", name="prueba_1")
     *   
     * @SWG\Response(
     *     response=201,
     *     description="List of users successfully"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="List of users was not successfully"
     * )
     *
     * @SWG\Tag(name="Users")
     */
    public function getAllUserAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $users = [];
        $message = "";

        try {
            $code = 200;
            $error = false;

            $rep = $em->getRepository('App:User');
            $users = $rep->findAll();               

            if (is_null($users)) {
                $users = [];
            }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all users - Error: {$ex->getMessage()}";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $users : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }



    /**
     * @Route("/v1/", name="api")
     */
    public function api()
    {
        //return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    //    $this->createFile();
        return new Response(sprintf('Logged in as %s',$this->getUser()->getUsername()." - ". json_encode($this->getUser()->getRoles())));
    //    return new Response(sprintf('Logged in as %s',$this->getUser()->getUsername()." - ". Role::getRole()));
        
    }


    public function createFile(){
        $nombre_archivo = "pruebaJJ.yml"; 
     
        if(file_exists($nombre_archivo))
        {
            $mensaje = "clave: traduccion";
        }
     
        else
        {
            $mensaje = "clave: traduccion";
        }
     
        if($archivo = fopen($nombre_archivo, "a"))
        {
            if(fwrite($archivo, date("d m Y H:m:s"). " ". $mensaje. "\n"))
            {
                echo "Se ha ejecutado correctamente";
            }
            else
            {
                echo "Ha habido un problema al crear el archivo";
            }     
            fclose($archivo);
        }        
    }



// ##############################################################################
    /**
     * @Rest\Get("/v1/lista", name="obtener_lista")
     *   
     * @SWG\Response(
     *     response=200,
     *     description="List of colorss successfully obtained."
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="List of colorss was not successfully obtained."
     * )
     *
     * @SWG\Parameter(
     *     name="entidad",
     *     in="query",
     *     type="string",
     *     description="The Entity name"
     * )
     *     
     * @SWG\Tag(name="Lista Generica")
     */
    public function getListaAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $obj = [];
        $message = "";
        $entidad = ucfirst($request->headers->get('entidad'));
        $roles = $this->getUser()->getRoles();
//$roles = array("admin" => "ROLE_ADMIN","user" => "ROLE_USER");
//echo '<pre>'; print_r(json_encode($roles)); echo '</pre>';


$entidad = "ColorCliente";
        try {
            $code = 200;
            $error = false;

            $rep = $em->getRepository('App:'.$entidad.'');
            $obj = $rep->findAll();               

       /* $obj = $rep->findBy(
            ['clienteid' => '1'],
            ['id' => 'ASC']
        ); */ 

            if (is_null($obj)) {
                $obj = [];
            }

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to get all colors - Error: {$ex->getMessage()}";
        }
        if(count($obj) == 0){ $obj = "No results"; }
        $response = [
            'code' => $code,
            'error' => $error,
            'roles' => json_encode($roles),
            'data' => $code == 200 ? $obj : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }


}//FIN DEL CONTROLADOR
