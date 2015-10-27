<?php
namespace Biblioteca\TegBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Biblioteca\TegBundle\Entity\documento as Document;

/**
 * Clase LoadDocumentData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema para los documentos (videos, images).
 *
 * @author Freddy Contreras <freddy.contreras3@gmail.com>
 * @author Currently Working: Freddy Contreras <freddy.contreras3@gmail.com>
 * @version 31/05/2015
 */

class LoadDocumentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        $TEGS = $manager->getRepository('BibliotecaTegBundle:teg')->findAll();
        foreach ($TEGS as $teg) {           
            
            for ($i=1; $i <= 5 ; $i++) { 
            
                $document = new Document();
                $document->setName('name_capitulo'.$i.'_'.$teg->getCota());
                $document->setPath($teg->getEscuela().'/'.$teg->getCota().'/capitulo'.$i.".pdf");
                
                $document->setTeg($teg);
                $teg->addCapitulo($document);

                $manager->persist($teg);
                $manager->persist($document);
                $manager->flush();
            }
        }
    }
    
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 10;
    }
}