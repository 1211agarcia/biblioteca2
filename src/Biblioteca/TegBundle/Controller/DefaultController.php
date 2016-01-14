<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Biblioteca\TegBundle\Entity\teg;
use Biblioteca\TegBundle\Form\searchType;

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

        //$repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');

        /*$query = $repository->createQueryBuilder('t')
		    ->where('t.published = 1')
		    ->orderBy('t.publicacion', 'DESC')
		    ->setMaxResults(3)
		    ->getQuery();

        $entities = $query->getResult();
		*/
	    
        $form = $this->createForm(new searchType(), null, array(
            'action' => $this->generateUrl('teg_search'),
            'attr'   => array('class' => 'searchform col-md-7 col-xs-12',
                'style' => 'margin: 0 auto 25px;float: initial;')));

  		return array(
            'form' => $form->createView(),
            /*'entities' => $entities*/);
    }
    /**
     * Creates a new teg entity.
     *
     * @Route("/search", name="teg_search")
     * @Method("GET")
     * @Template("BibliotecaTegBundle:teg:index.html.twig")
     */
    public function searchAction(Request $request)
    {
        
        // Se cre el formulario
        $form = $this->createForm(new searchType(), null, array(
            'action' => $this->generateUrl('teg_search'),
            'attr'   => array('class' => 'searchform')));
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $data = $form->getData();
            
            $repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');
            if( $this->isGranted('ROLE_ADMIN')){
                $query = $repository->search($data);//->getQuery();
            }
            else
            {
                //Se muestran los resultados de TEGs publicos solamente
                $query = $repository->search($data, false);
            }
            
            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                10/*limit per page*/
            );

            return array(
                    'form' => $form->createView(),
                    'entities' => $pagination,
                    'pagination' => $pagination
                );
        
        }
        /*else{
            //esto no se que hace es para ir a una pagina si hay error en el form
            return $this->redirectToRoute('home', array(), 301);
        }*/

        return $this->redirect($this->generateUrl('teg'));
        
    }
}