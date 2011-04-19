<?php

class SeleniumPageObjectTest extends PHPUnit_Framework_TestCase
{

    public function testConstructorCallsMapAndPreConditions()
    {
        $se = new MockSeleniumTestCase;

        $page = new MockPageObject($se);

        $this->assertTrue($page->preConditionsCalled,
            'assertPreConditions should be called when instantiated.');
        
        $this->assertTrue($page->mapConditionsCalled,
            'assertMapConditions should be called when instantiated.');
    }

    public function testAssertMapConditionsChecksEachMapElement()
    {
        $se = new MockSeleniumTestCase();
        $se->elements[] = 'map_value';
        $se->elements[] = 'map_value2';

        $m = new MockPageObject($se);
        $m->map['map_key'] = 'map_value';
        $m->map['map_key2'] = 'map_value2';
        $m->assertMapConditions();

        $this->assertEquals(
            array('map_value', 'map_value2'),
            $se->elementsChecked,
            'Each map value passed should have been checked');
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertMissingMapElementFails()
    {
        $se = new MockSeleniumTestCase();
        $se->elements[] = 'map_value';

        $m = new MockPageObject($se);
        $m->map['map_key'] = 'map_value';
        $m->map['map_key2'] = 'map_value2';

        $m->assertMapConditions();
    }

    public function testCallsMadeByMapGetIntercepted()
    {
        $se = new MockSeleniumTestCase();
        $se->elements[] = 'map_value';

        $m = new MockPageObject($se);
        $m->map['map_key'] = 'map_value';

        $this->assertTrue($m->isElementPresentByMap('map_key'));

        $this->assertEquals(
            array('map_value'),
            $se->elementsChecked,
            'the __call method should translate the map key into the map value');
    }

    public function testCallsMadeWithoutByMapPassThrough()
    {
        $se = new MockSeleniumTestCase();
        $se->elements[] = 'map_value';

        $m = new MockPageObject($se);
        $m->map['map_key'] = 'map_value';

        $this->assertTrue($m->isElementPresent('map_value'));

        $this->assertEquals(
            array('map_value'),
            $se->elementsChecked,
            'the __call method should translate the map key into the map value');
    }

    public function testGetLocatorReturnsMapValue()
    {
        $se = new MockSeleniumTestCase();
        $m = new MockPageObject($se);
        $m->map['map_key'] = 'map_value';

        $this->assertEquals(
            'map_value',
            $m->getLocator('map_key'),
            'Retured map key should match exactly.');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetLocatorFailsIfMissing()
    {
        $se = new MockSeleniumTestCase();
        $m = new MockPageObject($se);
        $m->getLocator('this-key-does-not-exist');
    }

}