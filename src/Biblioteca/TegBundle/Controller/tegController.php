<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Biblioteca\TegBundle\Entity\teg;
use Biblioteca\TegBundle\Entity\documento;
use Biblioteca\TegBundle\Entity\author;
use Biblioteca\TegBundle\Entity\tuthor;
use Biblioteca\TegBundle\Entity\keyWord;
use Biblioteca\TegBundle\Form\tegType;
use Biblioteca\TegBundle\Form\searchType;
use Biblioteca\UserBundle\Entity\usuario as User;
use Symfony\Component\Validator\Constraints\NotBlank as NotBlankConstraint;
use Symfony\Component\Form\FormError;

/**
 * teg controller.
 *
 * @Route("/teg")
 */
class tegController extends Controller
{

    /**
     * Lists all teg entities.
     *
     * @Route("/", name="teg")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');
        
        $userLogged = $this->get('security.token_storage')->getToken()->getUser();
        if( $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') && ($userLogged->getRoles()[0] === "ROLE_ADMIN" || $userLogged->getRoles()[0] === "ROLE_SUPER_ADMIN" )){
            $query = $repository->findAllQuery();
        }
        else
        {
            $query = $repository->findAllQuery(false);
        }                
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        $form = $this->createForm(new searchType(), null, array(
            'action' => $this->generateUrl('teg_search'),
            'attr'   => array('class' => 'searchform')));
        
        return array(
                'form' => $form->createView(),
                'entities' => $pagination,
                'pagination' => $pagination
            );
    }
    /**
     * Creates a new teg entity.
     *
     * @Route("/", name="teg_create")
     * @Method("POST")
     * @Template("BibliotecaTegBundle:teg:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new teg();
        $creator = new User();
        // Se crea el formulario
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        //Validacion de Archios
        $notBlankConstraint = new NotBlankConstraint();
        $notBlankConstraint->message = 'Por favor, debe cargar un archivo PDF.';
        //Para cada capitulo validamos de ser asi agregamos el error
        foreach ($entity->getCapitulos() as $key => $capitulo) {
            $errors = $this->get('validator')->validateValue(
                $entity->getCapitulos()->get($key)->getFile(),
                $notBlankConstraint );   
                foreach ($errors as $error) {
                    $form->get('capitulos')->addError( new FormError("Para el Capítulo ".($key + 1)." , debe cargar un archivo PDF."));
                }
        }
        if ($form->isValid()) {
            // Se obtiene el usuario creador
            $creator = $this->getUser();
            
            // Se agrega la nueva teg creada al creador
            $creator->addCreation($entity);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            foreach ($entity->getCapitulos() as $actualCapitulo) {  
                $actualCapitulo->setTeg($entity);
            }
            foreach ($entity->getAuthors() as $actualAuthor) {
                $actualAuthor->setTeg($entity);
            }
            foreach ($entity->getTuthors() as $actualTuthor) {
                $actualTuthor->setTeg($entity);
            }
            foreach ($entity->getKeyWords() as $actualKeyWord) {
                $actualKeyWord->setTeg($entity);
            }

            $em->flush();
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($creator);

            return $this->redirect($this->generateUrl('teg_show', array('id' => $entity->getId())));
        }

        return array(
            'operacion' => 0,
            'id' => $entity->getId(),
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a teg entity.
     *
     * @param teg $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(teg $entity)
    {
        $form = $this->createForm(new tegType(), $entity, array(
            'action' => $this->generateUrl('teg_create'),
            'method' => 'POST',
            'attr'   => array('class' => 'form-horizontal'),
        ));

        $form
            ->add('submit', 'submit', array('label' => 'Guardar',
                                             'attr' => array('class' => 'btn btn-primary' )
                                             )
            )
            ->add('reset', 'reset', array('label' => 'Limpiar',
                                             'attr' => array('class' => 'btn btn-default' )
                                             )
            )
        ;
        

        return $form;
    }

    /**
     * Displays a form to create a new teg entity.
     *
     * @Route("/new", name="teg_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new teg();
        $form   = $this->createCreateForm($entity);

        return array(
            'operacion' => 0,//Significa que sera NEW
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to create a new teg entity.
     *
     * @Route("/miteg", name="teg_my")
     * @Method("GET")
     * @Template()
     */
    public function myTegAction()
    {
        $userLogged = $this->get('security.token_storage')->getToken()->getUser();

        if($userLogged->getCreations()->count() === 0){
            return $this->redirect($this->generateUrl('teg_new'));
        }
        else
        {
            //se busca y se muestra.
            $id = $userLogged->getCreations()->get(0)->getId();
            return $this->redirect($this->generateUrl('teg_show', array('id' => $id)));
        
        }

    }

    /**
     * Finds and displays a teg entity.
     *
     * @Route("/{id}", name="teg_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);

        if (!$entity ) {
            throw $this->createNotFoundException('Unable to find teg entity.');
        }

        $arrayReturn = array('entity' => $entity);

        //Si el user es de Rol Admin, puede publicar.
        if( $this->isGranted('ROLE_ADMIN'))
        {
            $publishForm = $this->createPublishForm($id);
            $arrayReturn['publish_form'] = $publishForm->createView();
        }
        //Si el user es de Rol Admin ó Autor puede Editar.
        $arrayReturn['edit'] = ($this->getUser()->getCreations()->contains($entity) || $this->isGranted('ROLE_ADMIN'));
        return $arrayReturn;
    }

    /**
     * Displays a form to edit an existing teg entity.
     *
     * @Route("/{id}/edit", name="teg_edit")
     * @Method("GET")
     * @Template("BibliotecaTegBundle:teg:new.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find teg entity.');
        }

        $editForm = $this->createEditForm($entity);
        $publishForm = $this->createPublishForm($id);

        return array(
            'operacion' => 1,//significa que es edicion
            'id'      => $entity->getId(),
            'form'   => $editForm->createView(),
            'publish_form' => $publishForm->createView(),
        );
    }

    /**
    * Creates a form to edit a teg entity.
    *
    * @param teg $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(teg $entity)
    {
  
        $form = $this->createForm(new tegType(), $entity, array(
            'action' => $this->generateUrl('teg_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr'   => array('class' => 'form-horizontal'),
        ));

        $form
            ->add('submit', 'submit', array('label' => 'Actualizar',
                                             'attr' => array('class' => 'btn btn-primary' )
                                             )
            )
            ->add('reset', 'reset', array('label' => 'Cancelar',
                                             'attr' => array('class' => 'btn btn-default' )
                                             )
            )
        ;

        return $form;
    }
    /**
     * Edits an existing teg entity.
     *
     * @Route("/{id}", name="teg_update")
     * @Method("PUT")
     * @Template("BibliotecaTegBundle:teg:new.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find teg entity.');
        }

        $publishForm = $this->createPublishForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            
            foreach ($entity->getCapitulos() as $actualCapitulo) {
                $actualCapitulo->setTeg($entity);
            }
            foreach ($entity->getAuthors() as $actualAuthor) {
                $actualAuthor->setTeg($entity);
            }
            foreach ($entity->getTuthors() as $actualTuthor) {
                $actualTuthor->setTeg($entity);
            }
            foreach ($entity->getKeyWords() as $actualKeyWord) {
                $actualKeyWord->setTeg($entity);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('teg_show', array('id' => $id)));
        }

        return array(
            'operacion' => 1,//significa que es edicion
            'id'      => $entity->getId(),
            'form'   => $editForm->createView(),
            'publish_form' => $publishForm->createView(),
        );
    }
    /**
     * Deletes a teg entity.
     *
     * @Route("/{id}", name="teg_publish")
     * @Method("POST")
     * @Template("BibliotecaTegBundle:teg:show.html.twig")
     */
    public function publishAction(Request $request, $id)
    {
        $form = $this->createPublishForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find teg entity.');
            }
            //Si el valor existente es diferente al entrante se hace la accion
            $entity->setPublished(!$entity->getPublished());
            $em->persist($entity);
            $em->flush();
            
        }
        return $this->redirect($this->generateUrl('teg_show', array('id' => $id)));
        
    }

    /**
     * Creates a form to "publicar" a teg entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPublishForm($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);
        $form = $this->createFormBuilder(null, array('attr' => array('style' => 'display:initial;')))
            ->setAction($this->generateUrl('teg_publish', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => ($entity->getPublished()?'Ocultar':'publicar'), 'attr'=> array('class' => 'btn btn-default')))
            ->getForm()
        ;
        return $form;
    }
}
