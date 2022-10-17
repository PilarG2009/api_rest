<?php

namespace App\Controller\Api;

use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route ("/provincias")
 */
class ProvinciasController extends AbstractFOSRestController
{
    private $repoP;
    private $repoM;

    public function __construct(ProvinciasRepository $repoP, MunicipiosRepository $repoM) {
        $this->repoM = $repoM;
        $this->repoP = $repoP;
    }
    // 1. Devolver todas las provincias (id y nombre)
    /**
     * @Rest\Get (path="/")
     * @Rest\View (serializerGroups={"provincias"}, serializerEnableMaxDepthChecks=true)
     */
    public function getProvincias() {
        return $this->repoP->findAll();
    }

    // 2. Devolver los municipios de una provincia (id y nombre)
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"municipios"}, serializerEnableMaxDepthChecks=true)
     */
    public function getMunicipiobyProvincias(Request $request){
        return $this->repoM->findBy(['idProvincia'=>$request->get('id')]);
    }




}