<?php

require_once 'HomePage.php';
require_once 'ViewPage.php';
require_once __DIR__ . '/../PersonModel.php';

class SubmitTest extends PHPUnit_Extensions_SeleniumTestCase
{
    public function setUp()
    {
        $this->setBrowserUrl('http://po.dev');
        $this->setBrowser('firefox');
    }

    public function testSubmit()
    {
        $this->open('/');

        $person = new PersonModel();
        $person->setRealName('Graham Christensen');
        $person->setGender(PersonModel::G_MALE);
        
        $home = new HomePage($this);
        $home->setFromModel($person);
        $view = $home->save();

        $view->assertEqualsModel($person);
    }
}