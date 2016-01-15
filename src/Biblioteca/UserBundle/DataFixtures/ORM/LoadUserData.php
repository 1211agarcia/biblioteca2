<?php
namespace Biblioteca\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Biblioteca\UserBundle\Entity\usuario as User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i <= 3 ; $i++) { 
           
            $user = new User();
            //$user->setIndentityCard($entityCard);
            $user->setUserName('user'.$i);
            $user->setName('name'.$i);
            //$user->setLastName('user'.$i.'last_name');
            $user->setEmail('user'.$i.'@facyt.uc.edu.ve');
            $user->setPlainPassword('123456');
            //$user->setPhone('0412-000000'.$i);
            //$school = $manager->getRepository('DSFacytDomain:School')->findOneById(1);
            //$user->setSchool($school);
            $user->addRole($i+1);
            
            $user->setEnabled(true);


            $manager->persist($user);
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