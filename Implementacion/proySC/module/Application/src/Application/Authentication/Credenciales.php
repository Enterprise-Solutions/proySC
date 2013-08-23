<?php

namespace Application\Authentication;

use Zend\Form\Annotation;

/**
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("Credenciales")
 */
class Credenciales {
	/**
	 * @Annotation\Type("Zend\Form\Element\Text")
	 * @Annotation\Required({"required":"true" })
	 * @Annotation\Filter({"name":"StripTags"})
	 * @Annotation\Options({"label":"Cedula:"})
	 */
	public $cedula;
	
	/**
	 * @Annotation\Type("Zend\Form\Element\Password")
	 * @Annotation\Required({"required":"true" })
	 * @Annotation\Filter({"name":"StripTags"})
	 * @Annotation\Options({"label":"Contrasenha:"})
	 */
	public $contrasenha;
	
	
	/**
	 * @Annotation\Type("Zend\Form\Element\Text")
	 * @Annotation\Filter({"name":"StripTags"})
	 * @Annotation\Options({"label":"PerDocTipoId:"})
	 * @Annotation\AllowEmpty()
	 */
	public $orgDocumentoTipoCodigo;
	
	
	/**
	 * @Annotation\Type("Zend\Form\Element\Text")
	 * @Annotation\Filter({"name":"StripTags"})
	 *
	 * @Annotation\Options({"label":"DirPaisId:"})
	 * @Annotation\AllowEmpty()
	 */
	public $dirPaisId;
	
	/**
	 * @Annotation\Type("Zend\Form\Element\Submit")
	 * @Annotation\Filter({"name": "Boolean", "options": {"type":"string"}})
	 * @Annotation\Attributes({"value":"Ingresar"})
	 */
	public $ingresar;
}