<?php

class ViewPage extends PHPUnit_Extensions_SeleniumPageObject_Model
{

    protected $map = array(
        'header' => '//h1[@id="title"]',
        'real_name' => '//td[@id="output_your_name"]',
        'gender' => '//td[@id="output_your_gender"]'
    );
    protected $modelSkip = array('gender', 'header');

    public function assertPreConditions()
    {
        $this->se->assertEquals('Viewing your data', $this->getTextByMap('header'));
    }

    public function assertEqualsModel($object, $message = '')
    {
        parent::assertEqualsModel($object, $message);

        $this->se->assertEquals(
            $object->getGenderString(),
            $this->getTextByMap('gender')
        );
    }

    public function getRealName()
    {
        return $this->getTextByMap('real_name');
    }

}