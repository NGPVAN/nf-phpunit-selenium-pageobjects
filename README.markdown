# PageObjects
PageObjects is the idea of representing a webpage's services through a model, abstracting away the guts of Selenium and the page's structure.

You can (and should) read all about PageObjects here: http://code.google.com/p/selenium/wiki/PageObjects

Additionally, this repository comes prepared with an example application and functional test: https://github.com/nationalfield/phpunit-selenium-pageobjects/tree/master/Example

## Why
**You should apply good programming practices to testing. Tests are code. Bad code can contribute considerably to your technical debt. Tests should be DRY.**

## Installation
1. `pear channel-discover nationalfield.github.com`
2. `pear install nf/PHPUnit_SeleniumPageObject`

# Behavior
## Getters and Setters
You should define a getter and setter for each field for usage outside of your functional test. Never manually access the map, locators, or map keys outside of the PageObject.

## Map
To remove hard-coded Selenium locators, a `protected $map` variable is defined on every PageObject. Define your map of elements that you reference here:

```php
<?php
protected $map = array(
    'first_name' = 'css=#account_fname',
    'last_name' = 'css=$account_lname',
);
```

When you instantiate a PageObject, it calls `assertMapConditions` which automatically loops through all `$map` elements and asserts their presence.

> **Note:** Another method exists, `assertPreConditions`, and is executed before `assertMapConditions`. Implementing this method allows you to execute methods like `waitForElementPresent`.

## Using The Map

To use a mapped element, simply append `ByMap` to the end of the method name you want to utilize. For example:

```php
<?php
$this->typeByMap('first_name', 'Graham');
$this->typeByMap('last_name', 'Christensen');
```

# Advanced: Model-Based PageObjects
Often, a form on a page directly represents a model class with standard getter and setters. A class has been provided to map a model to a PageObject's $map variable.

Writing aggregate getters and setters for each object would be a tedious:

```php
<?php
$this->setName($object->getName());
$this->setEmail($object->getEmail());
```
> Setting Fields

```php
<?php
$this->assertEquals($object->getName(),
    $this->getValueByMap('name'));
$this->assertEquals($object->getEmail(),
    $this->getValueByMap('email'));
```
> Asserting the page's content matches the model

To ease the process and allow development to be much faster, the class provides two methods:

- setFromModel($model);
- assertEqualsModel($model, $message = '');

Both of these methods iterate over your $map, converting the keys into camel-case: `first_name` becomes `FirstName`, and calls the appropriate getters and setters.

## setFromModel
This method takes the camel-case version of the map, and uses the Pageobject's setter methods to set the page's values to the values from the model.

For example, if you have the fields 	`first_name` and `last_name` in your map, `setFromModel` would effectively be:

```php
<?php
$this->setFirstName($model->getFirstName());
$this->setLastName($model->getLastName());
```

## assertFromModel
This method is very similar to setFromModel, however asserts the content on the page against a model.

For example, if you have the fields 	`first_name` and `last_name` in your map, `assertFromModel` would effectively be:

```php
<?php
$this->assertEquals($model->getFirstName(),
    $this->getFirstName(),
    'first_name on the page should match the model.');
$this->assertEquals($model->getLastName(),
    $this->getLastName(),
    'last_name on the page should match the model.');
```

## Getter and Setter Exceptions
Some of your $map locators aren't valid places to enter data, and even worse to assert its value. One prime example of this would be the locator of the submit button.

To indicate to the assert/setFromModel methods that these need to skip, place its $map key into the $modelSkip array.

For example:

```php
<?php
protected $map = array(
    'first_name' => 'css=#first_name',
    'last_name' => 'css=#last_name',
    'save' => 'css=#form_submit'
);

protected $modelSkip = array (
    'save'
);
```