<?php

namespace Biblioteca\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Biblioteca\UserBundle\Entity\usuario as User;
use Biblioteca\UserBundle\Form\Type\RegistrationType as userType;
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
     * @Route("/", name="users")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        
        $users = $userManager->findUsers();

        return (array(
            'users' => $users
        ));
    }

    /**
     * Encuentra y muestra un usuario.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="user_show")
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
        $operationForm = $this->createtolockForm($id);

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'operation_form' => $operationForm->createView())
        );
    }
    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", requirements={"id" = "\d+"}, name="user_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find user.');
        }

        $editForm = $this->createEditForm($user);
        
        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form'   => $editForm->createView(),
            'id_user' =>$id
        ));
    }

    /**
     * Creates a form to edit a teg entity.
     *
     * @param teg $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $user)
    {
  
        $form = $this->createForm(new userType(), $user, array(
            'action' => $this->generateUrl('user_update', array('id' => $user->getId())),
            'method' => 'PUT',
            'attr'   => array('class' => 'form-horizontal'),
        ));

        $form
            ->add('submit', 'submit', array('label' => 'Actualizar',
                                             'attr' => array('class' => 'btn btn-primary' )
                                             )
            )
        ;
        return $form;
    }
    /**
     * Edits an existing user entity.
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="user_update")
     * @Method("PUT")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));
        if (!$user) {
            throw $this->createNotFoundException('Unable to find user entity.');
        }

        $editForm = $this->createEditForm($user);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
        }

        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form'   => $editForm->createView(),
            'id_user' => $id
        ));
    }
    /**
     * Bloquear a user entity.
     *
     * @Route("/{id}", name="user_lock")
     * @Method("POST")
     * @Template("BibliotecaUserBundle:usuario:show.html.twig")
     */
    public function toLockAction(Request $request, $id)
    {
        $form = $this->createToLockForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            
            $user = $userManager->findUserBy(array('id'=>$id));
            if (!$user) {
                throw $this->createNotFoundException('Unable to find usuario.');
            }
            if(!$user->isEnabled()){
                $user->setConfirmationToken(null);
                $user->setEnabled(true);
            }else
            {
                $user->setLocked(!$user->isLocked());
            }
            $userManager->updateUser($user);
            
        }
        return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
        
    }
    /**
     * Creates a form to "bloaquear" a user entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createToLockForm($id)
    {
        $userManager = $this->get('fos_user.user_manager');
            
        $user = $userManager->findUserBy(array('id'=>$id));
        $form = $this->createFormBuilder(null, array('attr' => array('style' => 'display:initial;')))
            ->setAction($this->generateUrl('user_lock', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit')
            ->getForm()
        ;
        return $form;
    }

}