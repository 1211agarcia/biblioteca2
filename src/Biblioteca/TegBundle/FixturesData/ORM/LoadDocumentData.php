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

class LoadDocumentoData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {
        $j = 1;

        for ($i=0; $i < 18 ; $i++) { 
            
            $document = new Document();
            
            if ($i < 9) {

                $document->setName('name_image'.$j);
                $document->setFileName('/name_image/image'.$i.".jpg");
                if ($i == 8)
                    $j = 1;

            } else if ($i < 18) {
                $document->setName('name_video'.$j);
                $document->setFileName('/name_video/video'.$i.".mp4");
            }

            $manager->persist($document);
            $manager->flush();
            $j++;
        }
    }
    
    /**
    * Función que identifica el orden de ejecución de DataFixture
    * @return int
    */
    public function getOrder()
    {
        return 1;
    }
}