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
     * @Route("/", name="users")
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

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user
        ));
    }
    /**
     * Bloquear a teg entity.
     *
     * @Route("/{id}", name="user_toblock")
     * @Method("POST")
     * @Template("BibliotecaUserBundle:usuario:show.html.twig")
     */
    public function ToBlockAction(Request $request, $id)
    {
        $form = $this->createToBlockForm($id);
      $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliotecaUserBundle:usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find teg entity.');
            }
          //Si el valor existente es diferente al entrante se hace la accion
            $entity->setToBlocked(!$entity->getBlocked());
            $em->persist($entity);
            $em->flush();
            
        }
        return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
        
    }

    /**
     * Creates a form to "publicar" a teg entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createToBlockForm($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BibliotecaUserBundle:usuario')->find($id);
        $form = $this->createFormBuilder(null, array('attr' => array('style' => 'display:initial;')))
            ->setAction($this->generateUrl('user_toblock', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => ($entity->getBlocked()?'Ocultar':'publicar'), 'attr'=> array('class' => 'btn btn-default')))
            ->getForm()
        ;
        return $form;
    }
}