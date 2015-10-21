<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Biblioteca\TegBundle\Entity\teg;
use Biblioteca\TegBundle\Entity\documento;
use Biblioteca\TegBundle\Form\tegType;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliotecaTegBundle:teg')->findAll();

        return array(
            'entities' => $entities,
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
        // Se cre el formulario
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            //foreach ($entity->getCapitulos() as $key => $value) {
                # code...
            //}
printf("<pre>");
                print_r( $entity);
                printf("</pre>");
            foreach ($entity->getCapitulos() as $actualCapitulo) {  
                
                $capitulo = new documento();

                $capitulo = $actualCapitulo;

                //$capitulo->setFile($actualCapitulo);

                $capitulo->setTeg($entity);

                $entity->addCapitulo($capitulo);

                $em = $this->getDoctrine()->getManager();

                $em->persist($entity);

                $em->persist($capitulo);
            }

            //$capitulo = new documento();
                //printf("<pre>");
                //print_r( $entity->getCapitulos()[0] );
                //printf("</pre>");
            //$capitulo->setFile($entity->getCapitulos()[0]);
            //$capitulo->setTeg($entity);
            /*
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->persist($capitulo);

            $em->flush();


            return $this->redirect($this->generateUrl('teg_show', array('id' => $entity->getId())));*/
        }

        return array(
            'entity' => $entity,
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
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find teg entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing teg entity.
     *
     * @Route("/{id}/edit", name="teg_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find teg entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        ;

        return $form;
    }
    /**
     * Edits an existing teg entity.
     *
     * @Route("/{id}", name="teg_update")
     * @Method("PUT")
     * @Template("BibliotecaTegBundle:teg:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find teg entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teg_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a teg entity.
     *
     * @Route("/{id}", name="teg_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliotecaTegBundle:teg')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find teg entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teg'));
    }

    /**
     * Creates a form to delete a teg entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teg_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
