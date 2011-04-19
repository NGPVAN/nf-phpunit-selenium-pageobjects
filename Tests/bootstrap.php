<?php

require_once __DIR__ . '/../PHPUnit/Extensions/SeleniumPageObject.php';
require_once __DIR__ . '/../PHPUnit/Extensions/SeleniumPageObject/Model.php';

class MockPageObjectModel extends PHPUnit_Extensions_SeleniumPageObject_Model
{
    public $map = array('user_count' => 'user_count');
    public $modelSkip = array();

    public $userCount;

    public function getUserCount()
    {
        return $this->userCount;
    }

    public function setUserCount($value)
    {
        $this->userCount = $value;
    }

    public static function getByField($object, $field)
    {
        return parent::getByField($object, $field);
    }

    public static function setByField($object, $field, $value)
    {
        return parent::setByField($object, $field, $value);
    }

    public static function getCamelField($field)
    {
        return parent::getCamelField($field);
    }

}

class MockPageObject extends PHPUnit_Extensions_SeleniumPageObject
{

    public $map = array();
    public $preConditionsCalled = false;
    public $mapConditionsCalled = false;

    public function assertPreConditions()
    {
        $this->preConditionsCalled = true;

        parent::assertPreConditions();
    }

    public function assertMapConditions()
    {
        $this->mapConditionsCalled = true;

        parent::assertMapConditions();
    }

    public function getLocator($map)
    {
        return parent::getLocator($map);
    }

}

class MockGetterSetter
{
    public $userCount;

    public function getUserCount()
    {
        return $this->userCount;
    }

    public function setUserCount($value)
    {
        $this->userCount = $value;
    }
}

class MockSeleniumTestCase extends PHPUnit_Extensions_SeleniumTestCase
{

    public $elements = array();
    public $elementsChecked = array();

    public function isElementPresent($element)
    {
        $this->elementsChecked[] = $element;

        if (in_array($element, $this->elements)) {
            return true;
        }

        return false;
    }

}