<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Rest\Route("/categoria")
 */
class CategoriaController extends AbstractFOSRestController
{
    // CRUD
    // Create, update, read, delete

    private $categoriaRepository;

    public function __construct(CategoriaRepository $repo)
    {
        $this->categoriaRepository = $repo;
    }

    /**
     * @Rest\Get (path="/")
     * @Rest\View (serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks = true)
     */

    public function getCategorias(){
        return $this->categoriaRepository->findAll();
    }

    // Traer una categoria:
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_categoria"}, serializerEnableMaxDepthChecks = true)
     */
    public function getCategoria(Request $request)
    {
        $idCategoria = $request->get('id');
        $categoria = $this->categoriaRepository->find($idCategoria);
        if (!$categoria) {
            return new JsonResponse('No se ha encontrado categoria', Response::HTTP_NOT_FOUND );
        }
        return $categoria;
    }


    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_categoria"}, serializerEnableMaxDepthChecks= true)
     */
    public function createCategoria(Request $request)
    {
        // Formularios -> sirven mara manejar las peticiones y validar el tipado -> null, si viene el texto en blanco (string vacio)...
        // Validator -> Null; si es un string poner el máximo de caracteres,..
        // 1. Creo el objeto vació
        $cat = new Categoria();
        // 2. Inicializamos el form
        $form = $this->createForm(CategoriaType::class, $cat);
        // 3. Le decimos al formulario que maneje la request (petición)
        $form->handleRequest($request);
        // 4. Comprobar que no hay error
        if (!$form->isSubmitted() || !$form->isValid()) {
            return $form;
        }
        // 5. Si esta correcto, guardo en BD
        $this->categoriaRepository->add($cat, true);
        return $cat;
    }


    //UPDATE con Patch
    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"up_categoria"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateCategoria(Request $request) {
        // Me guardo el id de la categoria
        $categoriaid = $request->get('id');

        //OJO Comprobar que existe esa categoria
        $categoria = $this->categoriaRepository->find($categoriaid);
        if (!$categoria) {
            return new JsonResponse('No se ha encontrado', Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(CategoriaType::class, $categoria, ['method'=>$request->getMethod()]);
        $form->handleRequest($request);

        // Tenemos que comprobar la validez del form
        if(!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse('Bad data', 400);
        }
        $this->categoriaRepository->add($categoria, true);
        return $categoria;
    }

    // DELETE
    /**
     * @Rest\Delete (path="/{id}")
     *
     */
    public function deleteCategoria(Request $request) {
        $categoriaId = $request->get('id');
        $categoria = $this->categoriaRepository->find($categoriaId);
        if (!$categoria) {
            return new JsonResponse('No se ha encontrado', 400);
        }
        $this->categoriaRepository->remove($categoria, true);
        return new JsonResponse('Categoria borrada', 200);
    }


}