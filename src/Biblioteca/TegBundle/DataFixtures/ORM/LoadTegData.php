<?php
namespace Biblioteca\TegBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Biblioteca\TegBundle\Entity\teg as Teg;
use Biblioteca\TegBundle\Entity\documento as Document;
use Biblioteca\TegBundle\Entity\author;
use Biblioteca\TegBundle\Entity\tuthor;
use Biblioteca\TegBundle\Entity\keyWord;

/**
 * Clase LoadTegData "DataFixtures".
 *
 * La clase carga los datos de prueba del sistema para los TEG.
 *
 * @author Armando Garcia <1211agarcia@gmail.com>
 * @author Currently Working: Armando Garcia <1211agarcia@gmail.com>
 * @version 08/09/2015
 */

class LoadTegData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * Función donde se implementa el DataFixture
    * @param ObjectManager $manager Manejador de Doctrine
    * @return void
    */
    public function load(ObjectManager $manager)
    {

        foreach (Teg::getSchools() as $escuela) {
            for ($y=1; $y <= 10; $y++) { 
                
                for ($i=1; $i <= 3 ; $i++) { 
                    
                    $teg = new Teg();
                    
                    $teg->setPublicacion(new \DateTime('10/05/'.(2000+$y)));
                    $teg->setEscuela($escuela);

                    $teg->setCota("D".$escuela[0].(($i<10)?"0".$i : $i)."/".(($y<10)?"0".$y : $y));

                    $teg->setTitulo("Titulo-".$escuela." ".$y." ".$i);
                    if(($i % 2) == 0){
                        $teg->setPublished(true);
                    }
                    $teg->setResumen("Resumen-".$i);
                    foreach ($teg->getAuthors() as $author) {    
                        $author->setName("Name autor ".$i." ".$y);
                        $author->setLastname("LastName autor ".$i." ".$y);
                        $author->setTeg($teg);
                    }
                    foreach ($teg->getTuthors() as $tuthor) {    
                        $tuthor->setName("Name tutor ".$i." ".$y);
                        $tuthor->setLastname("LastName tutor ".$i." ".$y);
                        $tuthor->setTeg($teg);
                    }
                    
                    
                    for ($k=1; $k <=3 ; $k++) { 
                        $keyWord = new keyWord();
                        $keyWord->setKeyWord("Name palabra ".$k." ".$i." ".$y);
                        $keyWord->setTeg($teg);
                        $teg->addKeyWord($keyWord);
                    }
                    foreach ($teg->getCapitulos() as $document) { 
            
                        $document->setPath($teg->getEscuela().'/'.$teg->getCota().'/capitulo'.".pdf");
                        $document->setTeg($teg);
                         
                        $manager->persist($document);
                    }

                    $manager->persist($teg);

                    $manager->flush();
                
                }
            }
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