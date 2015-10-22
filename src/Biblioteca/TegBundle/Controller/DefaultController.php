<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');

        $query = $repository->createQueryBuilder('t')
		    ->where('t.published = 1')
		    ->orderBy('t.publicacion', 'DESC')
		    ->setMaxResults(3)
		    ->getQuery();

        $entities = $query->getResult();
		
		$defaultData = array('message' => 'Type your message here');
	    $form = $this->createFormBuilder($defaultData)
	        ->add('name', 'text')
	        ->add('email', 'email')
	        ->add('message', 'textarea')
	        ->add('send', 'submit')
	        ->getForm();
	 
	    $form->handleRequest($request);
	 
	    if ($form->isValid()) {
	        // data es un array con claves 'name', 'email', y 'message'
	        $data = $form->getData();
	        printf("<pre>");
                print_r($data);
                printf("</pre>");
	    }
	 
  		return $this->render('BibliotecaTegBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'entities' => $entities));

    }
}
