<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Biblioteca\TegBundle\Entity\documento;
use Biblioteca\TegBundle\Form\documentoType;

/**
 * documento controller.
 *
 * @Route("/documento")
 */
class documentoController extends Controller
{

    /**
     * Lists all documento entities.
     *
     * @Route("/", name="documento")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BibliotecaTegBundle:documento')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new documento entity.
     *
     * @Route("/", name="documento_create")
     * @Method("POST")
     * @Template("BibliotecaTegBundle:documento:new.html.twig")
     */
    public function createAction(Request $request)
    {

        $document = new documento();
        $form = $this->createCreateForm($document);

        //if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //$document->upload();
                $em->persist($document);
                $em->flush();

                return $this->redirect($this->generateUrl('documento_show', array('id' => $document->getId())));
            }
        //}

        return array('form' => $form->createView());
    }

    /**
     * Creates a form to create a documento entity.
     *
     * @param documento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(documento $entity)
    {
        $form = $this->createForm(new documentoType(), $entity, array(
            'action' => $this->generateUrl('documento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new documento entity.
     *
     * @Route("/new", name="documento_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new documento();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a documento entity.
     *
     * @Route("/{id}", name="documento_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:documento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find documento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing documento entity.
     *
     * @Route("/{id}/edit", name="documento_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:documento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find documento entity.');
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
    * Creates a form to edit a documento entity.
    *
    * @param documento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(documento $entity)
    {
        $form = $this->createForm(new documentoType(), $entity, array(
            'action' => $this->generateUrl('documento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing documento entity.
     *
     * @Route("/{id}", name="documento_update")
     * @Method("PUT")
     * @Template("BibliotecaTegBundle:documento:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BibliotecaTegBundle:documento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find documento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('documento_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a documento entity.
     *
     * @Route("/{id}", name="documento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BibliotecaTegBundle:documento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find documento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('documento'));
    }

    /**
     * Creates a form to delete a documento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('documento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
