<?php

namespace Biblioteca\TegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Biblioteca\TegBundle\Entity\teg;

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
                    //$qb->expr()->like('t.cota', "'%".$data['q']."%'"),
                    //$qb->expr()->like('t.escuela', "'%".$data['q']."%'"),
                    //$qb->expr()->like('t.titulo', "'%".$data['q']."%'"),
                    //$qb->expr()->like('t.resumen', "'%".$data['q']."%'")
                    //$qb->expr()->like('t.palabrasClave', "'%".$data['q']."%'"),
                    //$qb->expr()->like('t.autores', "'%".$data['q']."%'"),
                    //$qb->expr()->like('t.tutores', "'%".$data['q']."%'")
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

            if (isset($data['desde'])) {
                $desde = $data['desde']->format('Y-m-d');
            }else{$desde = 't.publicacion';}
            if (isset($data['hasta'])) {
                $hasta = $data['hasta']->format('Y-m-d');
            }else{$hasta = 't.publicacion';}

            $exprInteval = $qb->expr()->between('t.publicacion', "'".$desde."'", "'".$hasta."'");

            if($data['operador'])
            {
                $condiciones = $qb->expr()->andX(
                        $exprEscuela,
                        $exprInteval//, $exprQ
                );
            }
            else
            {
                $condiciones = $qb->expr()->orX(
                        $exprEscuela,
                        $exprInteval//, $exprQ
                );
            }
            
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
        else
            return $this->redirectToRoute('home', array(), 301);

        return array(
            'form' => $form->createView());
    }

    /**
     * Creates a form to search a teg entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function searchCreateForm()
    {
		$defaultSearch = array();
    	return $this->createFormBuilder($defaultSearch)
            ->setAction($this->generateUrl('teg_search'))
            ->setMethod('GET')
            ->add('q', 'text')
            ->add('tipo', 'checkbox',
                array(
                    'label' => '¿Fresa Exacta?',
                    'attr' => array('class' => 'btn btn-primary' ),
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'required' => false,
                )
            )
            ->add('desde', 'birthday',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr' => array('class' => 'col-xs-9'),
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(1998, date('Y')),
                    'empty_value' => 
                        array('day' => 'Dia', 'month' => 'Mes', 'year' => 'Año'),
                    'required' => false,
                )
            )
            ->add('hasta', 'birthday',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr' => array('class' => 'col-xs-9'),
                    'widget' => 'choice',
                    'format' => 'dd-MM-yyyy',
                    'years' => range(1998, date('Y')),
                    'empty_value' => 
                        array('day' => 'Dia', 'month' => 'Mes', 'year' => 'Año'),
					'required' => false,
                )
            )

            ->add('escuela', 'choice',
                array(
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'attr'=> array('class' => 'form-control'),
                    'empty_value' => 'Todas',
                    'choices'  => teg::getSchools(),
                    'required' => false,
                )
            )
            ->add('operador', 'checkbox',
                array(
                    'label' => '¿Que Cumpla con todo?',
                    'attr' => array('class' => 'btn btn-primary' ),
                    'label_attr' => array('class' => 'control-label col-xs-3'),
                    'required' => false,
                )
            )
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
