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
        
        for ($i=1; $i < 18 ; $i++) { 
            
            $document = new Document();
            $teg = $manager->getRepository('BibliotecaTegBundle:teg')->find($i);
            
            $document->setTeg($teg);

            $document->setName('Todo el tomo'.$i);
            $document->setPath($i.".pdf");

            $manager->persist($document);
            $manager->flush();
            
        }
    }
    
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 3;
    }
}