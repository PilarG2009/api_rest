<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{

    /**
     * @Route ("/categoria",name="create_categoria")
     */
    public function createCategoriaAction(Request $request, EntityManagerInterface $em) {
        // 1. Cogemos la información a guardar que nos viene en la petición (request)
        $nombreCategoria = $request->get('categoria');

        // 2. Creamos un nuevo objeto JsonResponse que va a ser la respuesta que enviaremos de vuelta
        $response = new JsonResponse();

        // 3. Tengo que comprobar que la categoria no venga a null o no venga.
        // Comprobamos primero el error para que pare la ejecución si hay error
        if(!$nombreCategoria) { //solo pasa si es null, o no tiene valor asignado o si es entero igual a 0, o es false
            // Nos han enviado mal los datos en la petición (request)
            $response->setData([
                'succes'=> false,
                'data'=> null,
                'error'=> 'Categoria controller can.t be null or empty'
            ]);
            return $response->setStatusCode(404);
        }

        // 4. Si llegamos aquí es que me ha llegado bien el request. Y ahora ya tengo que crear un nuevo objeto y setear sus atributos
        $categoria = new Categoria();
        $categoria->setCategoria($nombreCategoria);

        // 5. Una vez creado el objeto ya podemos guardarlo en base de datos con EntityManagerInterface
        $em->persist($categoria);   // Doctrine -> prepara la query para guardar el objeto en BBDD
        $em->flush();     //Dctrine -> Ejecuta las querys que tenga pendientes

        // 6. Siempre de volver una respuesta
        $response->setData([
            'succes'=> true,
            'data'=> [
                'id'=> $categoria->getId(),
                'categoria'=> $categoria->getCategoria(),   //son los dos campos en la tabla categoria
            ]
        ]);
        return $response;
    }

    /**
     * @Route("/categoria/list", name="/categoria/list")
     */
    public function getAllCategorias(CategoriaRepository $categoriaRepository) {
        //1. Lamar al método del Repository
        $categorias = $categoriaRepository->findAll();

        //2. Comprobar que hay algo
       // if(!$categorias) {
            //Enviar una respuesta de error
       // }
        // esto devuelve un array de categorias, pero este array hay que enviarlo en formato Json
        // pero symfony no sabe pasar de array de objetos a Json
        // Hay que coger cada objeto del array a json por separado
        // estamos recorriendo el array de categorias, y estamos pasando cada objeto de este array a un array y cada objeto lo guardamos en un array temporal
        $categoriasAsArray = [];   //array temporal
        foreach ($categoriasAsArray as $cat) {
            $categoriasAsArray[] = [
                'id'=> $cat->getId(),
                'categoria'=> $cat->getCategoria()
            ];
        }
        $response = new JsonResponse();
        $response->setData([
            'succes'=> true,
            'data' => $categoriasAsArray
            ]);
        return $response;


    }
}