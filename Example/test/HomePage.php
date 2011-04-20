<?php

class HomePage extends PHPUnit_Extensions_SeleniumPageObject_Model
{
    protected $map = array(
        'real_name' => '//input[@id="your_name"]',
        'gender' => '//select[@id="gender"]',
        'save' => '//input[@id="form_submit"]'
        );

    protected $modelSkip = array('gender', 'save');

    public function setFromModel($object)
    {
        parent::setFromModel($object);

        // Since `gender` on the model maps to an integer, override and set
        // by the gender string.
        $this->setGender($object->getGenderString());
    }

    public function setRealName($value)
    {
        $this->typeByMap('real_name', $value);
    }

    public function setGender($gender)
    {
        $this->selectByMap('gender', 'label=' . $gender);
    }

    public function save()
    {
        $this->clickAndWaitByMap('save');
        
        return new ViewPage($this->se);
    }
}