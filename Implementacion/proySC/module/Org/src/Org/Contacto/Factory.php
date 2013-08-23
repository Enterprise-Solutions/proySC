<?php

namespace Org\Contacto;
use Org\Contacto\Contacto\Email;

use Org\Contacto\Contacto\LinkedIn;

use Org\Contacto\Contacto\Twitter;

use Org\Contacto\Contacto\Facebook;

use Org\Contacto\Contacto\TelefonoPart;

use Org\Contacto\Contacto\TelefonoLab;

use Org\Contacto\Contacto\CelularPart;

use Org\Contacto\Contacto\CelularLab;

use Org\Contacto\Repository;

class Factory
{
	public $_repository;
	public function __construct(Repository $repository)
	{
		$this->_repository = $repository;
	}
	
	/**
	 * @param unknown_type $codigoTipoDeDocumento
	 * @return \Org\Contacto\Contacto
	 */
	public function crearContacto($codigoTipoDeContacto)
	{
		$tipoDeContacto = $this->_repository
		->getTipoDeContacto($codigoTipoDeContacto);
		if(!$tipoDeContacto){
			//lanzar excepcion
		}
	
		switch ($codigoTipoDeContacto){
			case 'celularlab':
				$contacto = new CelularLab($tipoDeContacto);
				break;
			case 'celularpart':
				$contacto = new CelularPart($tipoDeContacto);
				break;
			case 'telefonolab':
				$contacto = new TelefonoLab($tipoDeContacto);
				break;
			case 'telefonopart':
				$contacto = new TelefonoPart($tipoDeContacto);
				break;
			case 'facebook':
				$contacto = new Facebook($tipoDeContacto);
				break;
			case 'twitter':
				$contacto = new Twitter($tipoDeContacto);
				break;
			case 'linkedIn':
				$contacto = new LinkedIn($tipoDeContacto);
				break;
			case 'email':
				$contacto = new Email($tipoDeContacto);
				break;
		}
	
		return $contacto;
	}
}