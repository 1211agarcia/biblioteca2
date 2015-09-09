<?php
namespace Biblioteca\TegBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Biblioteca\TegBundle\Entity\teg as Teg;

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

        for ($i=1; $i < 18 ; $i++) { 
            
            $teg = new Teg();
            
            $teg->setPublicacion(new \DateTime());
            $teg->setEscuela("computacion");
            $teg->setCota("DC-".($i+1)."-00");
            $teg->setTitulo("Titulo-".$i);
            //$teg->setCreated(new \DateTime());
            //$teg->setUpdated(new \DateTime());
            
            $teg->setResumen("Resumen-".$i);
            $teg->setPalabrasClave(array('Palabra-$i-1', 'Palabra-$i-2','Palabra-$i-3'));
            $teg->setAutores(array('Autor-$i-1', 'Autor-$i-2'));
            $teg->setTutores(array('Tutor-$i-1', 'Tutor-$i-2'));
            //$teg->removeAllCapitulos();
            
            $manager->persist($teg);
            $manager->flush();
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