<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class LoggedUser extends AbstractHelper
{
    public function __invoke()
    {
        $auth = new AuthenticationService();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            return $identity->nombre_persona . ' ' . $identity->apellido_persona;
        }
        return "Usuario No Registrado";
    }
}