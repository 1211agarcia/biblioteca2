<?php

namespace Biblioteca\TegBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
    public $message = 'El Valor "%string%" contiene un carácter no válido: sólo puede contener letras o números.';

    public function validatedBy()
	{
	    return get_class($this).'Validator';
	}
}

