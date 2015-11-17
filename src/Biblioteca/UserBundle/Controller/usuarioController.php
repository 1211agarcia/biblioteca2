<?php

namespace Biblioteca\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Biblioteca\UserBundle\Entity\usuario as User;
/**
 * ususario controller.
 *
 * @Route("/user")
 */
class usuarioController extends Controller
{

    /**
     * Lists all users.
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        
        $users = $userManager->findUsers();
        /* fomulario para filtrar usuarios    
        $form = $this->createForm(new searchType(), null, array(
            'action' => $this->generateUrl('teg_search'),
            'attr'   => array('class' => 'searchform')));
        */
        return $this->render('BibliotecaUserBundle:index.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * Encuentra y muestra un usuario.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserBy(array('id'=>$id));
        if (!$user) {
            throw $this->createNotFoundException('El usuario No se pudo encontrar.');
        }
        /*if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }*/

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
    }
}