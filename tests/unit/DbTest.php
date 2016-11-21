<?php

require_once __DIR__ . '/../../vendor/autoload.php';

class DbTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $em = $this->getModule('Doctrine2')->em;
        $user = $em->find('CodersLabBundle\Entity\Email', 1);
    }
}