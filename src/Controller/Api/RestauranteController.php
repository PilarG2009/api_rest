<?php

namespace App\Controller\Api;

use App\Repository\RestauranteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/restaurante")
 */
class RestauranteController extends AbstractFOSRestController
{
    private $repo;

    public function __construct(RestauranteRepository $repo) {
        $this->repo = $repo;
    }

    // 1. Devolver restaurante por id
    // Me servirá para mostrar la página del restuarante con toda su información
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"restaurante"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurante(Request $request){
        // Comprobaríamos 1º si existe en BBDD
        return $this->repo->find($request->get('id'));
    }


    // 2. Devolver listado de restaurantes según dia, hora y municipio
    // Primero seleccionamos la dirección a la que se va enviar la comida
    // Dp seleccionamos día y hora del reparto
    // Mostrar los restaurante que cumplan esas condiciones
    // Vamos a hacer un post pq vamos a enviarle hora, dia y municipio

    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"res_filtered"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestaurantesBy(Request $request) {
        $dia = $request->get('dia');
        $hora = $request->get('hora');
        $idMunicipio = $request->get('municipio');

        // ahora comprobar que vienen esos datos, sinó viene alguno hacemos un BAD REQUEST
        $restaurantes = $this->repo->findByDayTimeMunicipio($dia, $hora, $idMunicipio);
        return $restaurantes;


    }
}