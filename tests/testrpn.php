<?php
require_once(dirname(__FILE__) . '/../simpletest/autorun.php');
require_once(dirname(__FILE__) . '/../simpletest/web_tester.php');
#require_once($root . 'rpn.php');

define(PAGE_URL,'http://paylease.vagrant/');
define(PAGE_H1,'RPN Calculator');

class TestRpn extends WebTestCase {

	//Does the page exist
    function testRpnPageExists() {
        $this->get(PAGE_URL);
        $this->assertText(PAGE_H1);
    }

    //Do the stacks start out at zero?
    function testRpnStacksZero() {
        $this->get(PAGE_URL);
        $this->assertText('t : 0');
        $this->assertText('z : 0');
        $this->assertText('y : 0');
        $this->assertText('x : 0');
        $this->assertText('d : 0.00');
    }
    //If I submit do I get back to the same page?
    function testRpnClickEnter() {
        $this->get(PAGE_URL);
        $this->clickSubmit('Enter');
        $this->assertText(PAGE_H1);
    }
    //if I enter a number does it show in x and y?
    function testRpnClickNumberEnter() {
        $this->get(PAGE_URL);
        $this->clickSubmit('2');
        $this->clickSubmit('Enter');
        $this->assertText('x : 2');
        $this->assertText('y : 2');
    }
    //load three numbers into the stack
    function testRpnFullStack() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('Enter');
        $this->clickSubmit('2');
        $this->clickSubmit('Enter');
        $this->clickSubmit('3');
        $this->clickSubmit('Enter');
        $this->assertText('t : 1');
        $this->assertText('z : 2');
        $this->assertText('y : 3');
        $this->assertText('x : 3');
        $this->assertText('d : 3.00');
    }
    //formatting with trailing dot
    function testRpnClickNumber123() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->assertText('x : 1');
        $this->assertText('d : 1.');
        $this->clickSubmit('2');
        $this->assertText('x : 12');
        $this->assertText('d : 12.');
        $this->clickSubmit('3');
        $this->assertText('x : 123');
        $this->assertText('d : 123.');
    }
    //Calculate: 5 2 -
    function testRpnSimpleCalculation() {
        $this->get(PAGE_URL);
        $this->clickSubmit('5');
        $this->clickSubmit('Enter');
        $this->clickSubmit('2');
        $this->clickSubmit('-');
        $this->assertText('x : 3');
    }
    //Calculate: 1 3 4 x 5 6 x + 7 / + = 7
    function testRpnChainCalculation() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('Enter');
        $this->clickSubmit('3');
        $this->clickSubmit('Enter');
        $this->clickSubmit('4');
        $this->clickSubmit('x');
        $this->clickSubmit('5');
        $this->clickSubmit('Enter');
        $this->clickSubmit('6');
        $this->clickSubmit('x');
        $this->clickSubmit('+');
        $this->clickSubmit('7');
        $this->clickSubmit('/');
        $this->clickSubmit('+');
        $this->assertText('x : 7');
        $this->assertText('d : 7.00');
    }
    /**
     * 1.
    */
    function testRpnFormat0() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->assertText('d : 1.');
	}
    /**
     * 12.
    */
    function testRpnFormat1() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('2');
        $this->assertText('d : 12.');
	}
    /**
     * 12.3
    */
    function testRpnFormat2() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('2');
        $this->clickSubmit('.');
        $this->clickSubmit('3');
        $this->assertText('d : 12.3');
	}
    /**
     * 12.03
    */
    function testRpnFormat3() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('2');
        $this->clickSubmit('.');
        $this->clickSubmit('0');
        $this->clickSubmit('3');
        $this->assertText('d : 12.03');
	}
    /**
     * 123.456
    */
    function testRpnFormat4() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('2');
        $this->clickSubmit('3');
        $this->clickSubmit('.');
        $this->clickSubmit('4');
        $this->clickSubmit('5');
        $this->clickSubmit('6');
        $this->assertText('d : 123.456');
	}
    /**
     * 1,234.56
    */
    function testRpnFormat5() {
        $this->get(PAGE_URL);
        $this->clickSubmit('1');
        $this->clickSubmit('2');
        $this->clickSubmit('3');
        $this->clickSubmit('4');
        $this->clickSubmit('.');
        $this->clickSubmit('5');
        $this->clickSubmit('6');
        $this->assertText('d : 1,234.56');
	}
}
?>