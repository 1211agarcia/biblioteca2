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
     * @Method("GET")
     * @Template("BibliotecaTegBundle:teg:index.html.twig")
     */
    public function searchAction(Request $request)
    {
        
        // Se cre el formulario
        $form = $this->searchCreateForm();
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $data = $form->getData();
            
            $repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');

            $qb = $repository->createQueryBuilder('t');
            
            if (isset($data['q'])) {
                $exprQ = $qb->expr()->orX(
                    $qb->expr()->like('t.cota', "'%".$data['q']."%'"),
                    $qb->expr()->like('t.titulo', "'%".$data['q']."%'"),
                    $qb->expr()->like('t.resumen', "'%".$data['q']."%'"),
                    $qb->expr()->like('t.palabrasClave', "'%".$data['q']."%'"),
                    $qb->expr()->like('t.autores', "'%".$data['q']."%'"),
                    $qb->expr()->like('t.tutores', "'%".$data['q']."%'")
                );
            }
            else
            {
                //$exprEscuela = $qb->expr()->isNotNull('t.escuela');
            }

            //Si se filtra por Escuela se 
            if (isset($data['escuela'])){
                $exprEscuela = $qb->expr()->eq('t.escuela', "'".$data['escuela']."'");}
            else{$exprEscuela = $qb->expr()->isNotNull('t.escuela');}

            
            //Si rangos de fechas es ignorado
            if (!isset($data['desde']) && !isset($data['hasta'])){
                $exprInteval= $qb->expr()->isNotNull('t.publicacion');}
            else{
                //Si ingreso rango inferior
                if (isset($data['desde'])) {
                    $desde = "'".$data['desde']."-1-1'";
                }else{$desde = 't.publicacion';}
                //Si ingreso rango superior
                if (isset($data['hasta'])) {
                    $hasta = "'".$data['hasta']."-12-31'";
                }else{$hasta = 't.publicacion';}
                $exprInteval = $qb->expr()->between('t.publicacion', $desde, $hasta);
            }

            $condiciones = $qb->expr()->andX(
                        $exprEscuela,
                        $exprInteval, $exprQ
            );
            
            $qb->where($qb->expr()->andX(
                $qb->expr()->eq('t.published', '1'),
                $condiciones
                )
            )
            ->orderBy('t.publicacion', 'DESC');

            $query = $qb->getQuery();
            $entities = $query->getResult();

            return array(
                'form' => $form->createView(),
                'entities' => $entities);
        
        }
        else{
            //esto no se que hace es para ir a una pagina si hay error en el form
            return $this->redirectToRoute('home', array(), 301);
        }

        return array(
            'form' => $form->createView());
    }

    /**
     * Creates a form to search a teg entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function searchCreateForm()
    {
		$form = $this->createForm(new searchType(), null, array(
            'action' => $this->generateUrl('teg_search'),
            'attr'   => array('class' => 'searchform col-md-7 col-xs-12',
                'style' => 'margin: 0 auto 25px;float: initial;')));

        return $form;
    }
    
}
