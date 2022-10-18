<?php

namespace App\EventListener;

use App\Repository\ClienteRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class OnLoginListener
{

    private $repo;
    public function __construct(ClienteRepository $repository){
        $this->repo = $repository;
    }

    // creamos un evento que se va aquedar ala escucha de que se
    // dispare el evento de on login response
    // traducción: respuesta del login conseguido
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) {
        // Cojo todos los datos de la respuesta y me los guardo
        $data = $event->getData();
        // Me traigo el user
        $user = $event->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }
        $data['userId'] = $user->getId();
        $clienteId = null;
        // Traer el cliente
        $cliente = $this->repo->findOneBy(['user'=>$user]);
        if (!$cliente) {
            $clienteId = $cliente->getId();
        }
        // Por último añadimos los campos a la respuesta
        $data['idCliente'] = $clienteId;

        $event->setData($data);




    }

}