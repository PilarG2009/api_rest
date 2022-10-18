<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;

class AbstractApiController extends AbstractFOSRestController
{
    // Método intermedio para sobreescribir las opciones del formulario y
    // así poder desactivar el csrf_token

}