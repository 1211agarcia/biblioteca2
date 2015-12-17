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

            $query = $repository->search($data);//->getQuery();
            
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

/*
    Filtro sobre ArrayCollections, verifica si un stringToFind es semejante a los valores de Array
*/
class LikeFilter {
    private $stringToFind;

    function __construct($stringToFind) {
        /**
         * Reemplaza todos los acentos por sus equivalentes sin ellos 
         **/
        $stringToFind = trim($stringToFind);
        $stringToFind = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $stringToFind );
        $stringToFind = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $stringToFind );
        $stringToFind = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $stringToFind );
        $stringToFind = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $stringToFind );
        $stringToFind = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $stringToFind );
        $stringToFind = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',), $stringToFind );
            $this->stringToFind = $stringToFind;
    }
    /**
     * @param $i cadena donde se buscara la cadena inferior.
     * @return "true" si la substring se encuantre en $i al menos una vez
     * @var $i valor original, $ii string limpia
     */
    function isLike($i) {
        $ii = trim($i);
        $ii = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $ii );
        $ii = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $ii );
        $ii = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $ii );
        $ii = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $ii );
        $ii = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $ii );
        $ii = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',), $ii );
        

        echo "i = ".$i." ------ stringToFind = ".$this->stringToFind."\n";
        return (stristr($ii, $this->stringToFind) !== false);
    }
     
   
}