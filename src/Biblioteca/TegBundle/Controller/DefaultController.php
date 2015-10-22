<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Lists all teg entities.
     *
     * @Route("/", name="home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');

        $query = $repository->createQueryBuilder('t')
		    ->where('t.published = 1')
		    ->orderBy('t.publicacion', 'DESC')
		    ->setMaxResults(3)
		    ->getQuery();

        $entities = $query->getResult();
		
	    $form = $this->searchCreateForm();
	 
  		return array(
            'form' => $form->createView(),
            'entities' => $entities);

    }
    /**
     * Creates a new teg entity.
     *
     * @Route("/search", name="teg_search")
     * @Method("POST")
     * @Template("BibliotecaTegBundle:teg:index.html.twig")
     */
    public function searchAction(Request $request)
    {
        
        // Se cre el formulario
        $form = $this->searchCreateForm();
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

	        $entities = $em->getRepository('BibliotecaTegBundle:teg')->findAll();

	        return array(
	            'entities' => $entities,
	        );
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to search a teg entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function searchCreateForm()
    {
		$defaultSearch = array('message' => 'Type your message here');
    	return $this->createFormBuilder($defaultSearch)
            ->setAction($this->generateUrl('teg_search'))
            ->setMethod('POST')
            ->add('message', 'text')
            ->add('desde', 'date')
            ->add('hasta', 'date')
            ->add('escuela', 'text')
            ->add('submit', 'submit', array('label' => 'Buscar',
                                             'attr' => array('class' => 'btn btn-primary' )
                                             )
            )
            ->add('reset', 'reset', array('label' => 'Limpiar',
                                             'attr' => array('class' => 'btn btn-default' )
                                             )
            )
            ->getForm()
        ;

        return $form;
    }
    
}
