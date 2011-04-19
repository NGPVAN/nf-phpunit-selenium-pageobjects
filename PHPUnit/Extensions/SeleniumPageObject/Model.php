<?php

abstract class PHPUnit_Extensions_SeleniumPageObject_Model extends PHPUnit_Extensions_SeleniumPageObject
{

    /**
     * An array of mappings that do not directly translate to the model with
     * getter and setters. These should be implemented manually in setFromModel
     * and assertEqualsModel
     * 
     * @var array
     */
    protected $modelSkip = array();

    /**
     * Import a model's data into the PageObject.
     *
     * Uses $object->getCamelMapKey() and $this->setCamelMapKey() to make the
     * translation. If specific map keys do not match this get/set method, list
     * them in $this->modelSkip and make sure to implement
     * the setting in your class's setFromModel() method.
     *
     * 
     * @param object $object The object you want to pass
     * @return self
     */
    public function setFromModel($object)
    {
        foreach ($this->map as $field => $locator) {
            if (!in_array($field, $this->modelSkip)) {
                $value = self::getByField($object, $field);
                self::setByField($this, $field, $value);
            }
        }

        return $this;
    }

    /**
     * Test to ensure that the current PageObject represents a model's values
     *
     * Uses $object->getCamelMapKey() and $this->setCamelMapKey() to make the
     * translation. If specific map keys do not match this get/set pattern, list
     * them in $this->modelSkip and make sure to implement
     * the comparison in your class's assertEqualsModel() method.
     * 
     *
     * @param object $object
     * @param string $message
     */
    public function assertEqualsModel($object, $message = '')
    {
        foreach ($this->map as $field => $locator) {
            if (!in_array($field, $this->modelSkip)) {
                // Get the value from the PageObject
                $value = self::getByField($this, $field);

                // Get the value from the model $object
                $expect = self::getByField($object, $field);

                // If what is passed is an object, convert to a string using
                // __toString
                if (is_object($expect)) {
                    $expect = (string) $expect;
                }

                $this->se->assertEquals($expect, $value, $message . ' (' . $field . ')');
            }
        }
    }

    /**
     * Using a getter in the pattern of getCamelCase, convert the $field name
     * to camel case and get the value from $object.
     *
     * @example For getByField($obj, 'user_count') this will call
     * $obj->getUserCount()
     *
     * @param object $object
     * @param string $field
     * @return mixed
     */
    protected static function getByField($object, $field)
    {
        $get = 'get' . self::getCamelField($field);
        return $object->$get();
    }

    /**
     * Using a setter in the pattern of getCamelCase, convert the $field name
     * to camel case and set the value from $object.
     *
     * @example For setByField($obj, 'user_count', 123) this will call
     * $obj->setUserCount(123)
     *
     * @param object $object
     * @param string $field
     * @param mixed $value
     * @return mixed
     */
    protected static function setByField($object, $field, $value)
    {
        $set = 'set' . self::getCamelField($field);
        return $object->$set($value);
    }

    /**
     * Convert a field name to camel case for usage in the getter and setter.
     *
     * @param string $field
     * @return string
     */
    protected static function getCamelField($field)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
    }

}