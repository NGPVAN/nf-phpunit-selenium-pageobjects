<?php

abstract class PHPUnit_Extensions_SeleniumPageObject
{

    /**
     * The testcase that is utilizing the page object.
     *
     * @var PHPUnit_Extensions_SeleniumTestCase
     */
    protected $se;
    /**
     * A mapping of unique keys to locator strings. Each one of these is
     * validated to ensure it exists on the page when the PageObject is
     * instantiated.
     *
     * @var array
     */
    protected $map = array();

    /**
     * Instantiate the PageObject and validate that the browser in a valid
     * state for this PageObject.
     *
     * @param PHPUnit_Extensions_SeleniumTestCase $driver
     */
    public function __construct(PHPUnit_Extensions_SeleniumTestCase $test)
    {
        $this->se = $test;

        $this->assertPreConditions();
        $this->assertMapConditions();
    }

    /**
     * Assert that all elements in $this->map are present on the page
     */
    protected function assertMapConditions()
    {
        foreach ($this->map as $field => $locator) {
            $this->se->assertTrue(
                $this->se->isElementPresent($locator),
                'Locator field "' . $field . '" is not present.');
        }
    }

    /**
     * You may want to assert a page's header or title. If all you are testing
     * is that a field is present on the page, add the locator to the $map.
     */
    protected function assertPreConditions()
    {
        // Placeholder
    }

    /**
     * Convert a *ByMap call to using the real locator string as stored in
     * $this->map
     *
     * @example
     * // In the class definition
     * protected $map = array('title' => '//div[@id="title"]')
     *
     * // In your PageObject
     * public function getTitle()
     * {
     *     return $this->getTextByMap('title');
     * }
     *
     * @param string $name Method name
     * @param array $arguments An array of arguments. The first one must be the
     * map locator.
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // Only intercept *ByMap calls
        if (substr($name, -5) == 'ByMap') {
            // trim off the ByMap
            $name = substr($name, 0, -5);

            // Replace the map key with the locator stored in $this->map
            $arguments[0] = $this->getLocator($arguments[0]);
        }

        return call_user_func_array(array($this->se, $name), $arguments);
    }

    /**
     * Get a map key's locator string
     *
     * @param string $map
     * @return string
     * @throws InvalidArgumentException If the $map does not exist.
     */
    protected function getLocator($map)
    {
        if (isset($this->map[$map])) {
            return $this->map[$map];
        }

        throw new InvalidArgumentException('Map ' . $map . ' is not a valid locator key.');
    }

}
