<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Form\DireccionType;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Rest\Route("/direccion")
 */
class DireccionController extends AbstractFOSRestController
{
    private $repo;

    public function __construct(DireccionRepository $repo) {
        $this->repo = $repo;
    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_dir"}, serializerEnableMaxDepthChecks=true)
     */
    public function createDireccion(Request $request) {

        $direccion = new Direccion();
        $form = $this->createForm(DireccionType::class, $direccion);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse('Bad data', Response::HTTP_BAD_REQUEST);
        }
        $this->repo->add($direccion, true);
        return $direccion;

    }

}