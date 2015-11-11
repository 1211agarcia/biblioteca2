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
use Biblioteca\TegBundle\Form\searchType;
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
            
        $form = $this->createForm(new searchType(), null, array(
            'action' => $this->generateUrl('teg_search'),
            'attr'   => array('class' => 'searchform')));
        
        return array(
            'form' => $form->createView(),
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
        // Se crea el formulario
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            foreach ($entity->getCapitulos() as $actualCapitulo) {  
                
                $capitulo = new documento();

                $capitulo = $actualCapitulo;

                $capitulo->setTeg($entity);

                $entity->addCapitulo($capitulo);

              //  $em->persist($entity);

                $em->persist($capitulo);
            }
            
            $em->flush();


            return $this->redirect($this->generateUrl('teg_show', array('id' => $entity->getId())));
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

        $publishForm = $this->createPublishForm($id);

        return array(
            'entity'      => $entity,
            'publish_form' => $publishForm->createView(),
        );
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
            'entity'      => $entity,
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
     * @Template("BibliotecaTegBundle:teg:edit.html.twig")
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
            $em->flush();

            return $this->redirect($this->generateUrl('teg_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
            if ($entity->getPublished() && !$form->getData()['published']) {
                $entity->setPublished($form->getData()['published']);
                $em->persist($entity);
                $em->flush();
                //Se actualiza el formulario
                $form = $this->createPublishForm($id);
            }
            
        }
        return array(
            'entity'      => $entity,
            'publish_form' => $form->createView(),
        );
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
        $form = $this->createFormBuilder(null, array('attr' => array('class' => 'form-inline')))
            ->setAction($this->generateUrl('teg_publish', array('id' => $id)))
            ->setMethod('POST')
            ->setAttribute('class', 'form-group')
            ->add('published', 'checkbox',
                array(
                    'label'    => '¿Publicado?',
                    //'label_attr' => array('class' => 'control-label col-xs-3') ,
                    'attr'=> array('class' => 'checkbox-inline','data-on-text'=> 'Sí','data-off-text'=> 'No', 'checked'=>$entity->getPublished()),
                    'required' => false,
                )
            )
            ->add('submit', 'submit', array('label' => 'Aplicar', 'attr'=> array('class' => 'button save btn-info')))
            ->getForm()
        ;
        return $form;
    }
}
