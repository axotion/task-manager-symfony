<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $task = new Task();
            $task->setContent('Task '.$i);
            $task->setDate(\DateTime::createFromFormat('d-m-Y', random_int(1,31)."-09-2017"));
            $manager->persist($task);
        }
        $manager->flush();
    }
}