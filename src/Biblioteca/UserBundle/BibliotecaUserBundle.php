<?php

namespace Biblioteca\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BibliotecaUserBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
