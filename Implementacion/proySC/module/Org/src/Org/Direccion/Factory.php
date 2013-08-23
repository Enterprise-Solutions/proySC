<?php

namespace Org\Direccion;
use Org\Direccion\Direccion;

class Factory
{
	public function crearDireccion($dirDireccionTipoId = 1)
	{
		$direccion = new Direccion($dirDireccionTipoId);
		return $direccion;
	}
}