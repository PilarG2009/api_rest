<?php

namespace App\Controller\Api;

use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Rest\Route("/direccion")
 */
class Direccion extends AbstractFOSRestController
{
    private $repo;

    public function __construct(DireccionRepository $repo) {
        $this->repo = $repo;
    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_dir"}, serializerEnableMaxDepthChecks=true
     */
    public function createDireccion(Request $request) {

    }

}