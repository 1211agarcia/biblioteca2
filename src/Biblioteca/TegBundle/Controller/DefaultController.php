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
     * @Method("POST")
     * @Template("BibliotecaTegBundle:teg:index.html.twig")
     */
    public function searchAction(Request $request)
    {
        
        // Se cre el formulario
        $form = $this->searchCreateForm();
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $data = $form->getData();
            
            /*$em = $this->getDoctrine()->getManager();

	        $entities = $em->getRepository('BibliotecaTegBundle:teg')->findByEscuela($data['escuela']);
*/          
            $repository = $this->getDoctrine()->getRepository('BibliotecaTegBundle:teg');

            $query = $repository->createQueryBuilder('t')
            ->where('t.published = 1')
            ->andWhere('t.escuela = ?1 AND t.publicacion < ?2')
            ->orderBy('t.publicacion', 'DESC')
            //->setMaxResults(3)
            ->setParameter(1, $data['escuela'])
            ->setParameter(2, $data['hasta'])
            ->getQuery();
    
            $entities = $query->getResult();

            $form = $this->searchCreateForm();

            return array(
                'form' => $form->createView(),
                'entities' => $entities);
        
        }

        return array(
            'form' => $form->createView(),
            'entities' => $entities);
    }

    /**
     * Creates a form to search a teg entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function searchCreateForm()
    {
		$defaultSearch = array('busqueda' => 'Type your message here');
    	return $this->createFormBuilder($defaultSearch)
            ->setAction($this->generateUrl('teg_search'))
            ->setMethod('POST')
            ->add('busqueda', 'text')
            ->add('tipo', 'checkbox', array('label' => '¿Fresa Exacta?',
                                             'attr' => array('class' => 'btn btn-primary' )
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
                    'empty_value' => 'Seleccionar',
                    'choices'  => teg::getSchools(),
                    'required' => false,
                )
            )
            ->add('operador', 'checkbox', array('label' => '¿Que Cumpla con todo?',
                                             'attr' => array('class' => 'btn btn-primary' )
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
