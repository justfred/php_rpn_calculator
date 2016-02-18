<?php
/** rpn.php
 * controller for paylease code challnge rpn calculator
 * examples: 
 * http://hp15c.org/RPNHowTo.php
 * http://www.lehigh.edu/~sgb2/rpnTutor.html
 *
 * 
 */

//because of the way number entry is handled, use a state machine
define('STATE_ERROR',-1);
define('STATE_CLEAN',0);
define('STATE_NUMBER',1);
define('STATE_DECIMAL',2);
define('STATE_OPERATION',3);

//decimal places to display
define('DEFAULT_DECIMAL',2);

class rpn
{

	var $stack = array();
	var $state = 0;

	/**
	 * debugger
	 * debug method
	 * usage:
	 * debugger(__FILE__.'#'.__LINE__,'$_REQUEST',$_REQUEST);
	*/
	function debugger($line, $string, $var) {
		echo '<pre>@ '. $line . ' ' . $string . ' : ' . print_r($var,true) . "</pre>";
	}

	/** push
	 * push the stack up
	*/
	function push() {
		//throw away stack z
		$this->stack['t'] = $this->stack['z'];
		$this->stack['z'] = $this->stack['y'];
		$this->stack['y'] = $this->stack['x'];
	}

	/** push
	 * pull the stack down
	*/
	function pop() {
		$this->stack['y'] = $this->stack['z'];
		$this->stack['z'] = $this->stack['t'];
		#don't zero out the top		
		#$this->stack['t'] = 0;
	}

	/** outDisplay
	 * format output for display
	*/
	function outDisplay() {
		echo '<input type=hidden name="state" value="' . $this->state . '" />';
		switch ($this->state) {
			case STATE_ERROR:
				//divide by zero error
				echo 'Error 0';
				break;
			case STATE_DECIMAL:
				//format the integer "top", show the string "bottom"
				//1,234.
				//1,234.56789
				//1,234.0
				//1,234.01
				$integerPart = intval($this->stack['x']);
				$decimalPart = substr($this->stack['x'], strlen($integerPart) + 1);
				echo number_format($integerPart) . '.' . $decimalPart;

				break;
			case STATE_NUMBER:
				//1,234. with trailing dot
				echo number_format($this->stack['x']) . '.';
				break;
			default:
				//1,234.56
				echo number_format($this->stack['x'],DEFAULT_DECIMAL);
				break;
		}
	}

	/** outStack
	 * show the stack
	*/
	function outStack() {
		$stack = $this->stack;

		foreach ($stack as $index=>$value) {
			echo '<input type=hidden name="stack' . $index. '" value="' . $value . '" />';
#formatted
#			echo $index . ' : ' . sprintf('%.4f', $value) . '<br/>';
			echo $index . ' : ' . $value . '<br/>';
		}
	}

	/** __construct
	 * initialise from $_REQUEST
	*/
	function __construct() {

		$this->stack['t'] = isset($_REQUEST['stackt']) ? $_REQUEST['stackt'] : 0;
		$this->stack['z'] = isset($_REQUEST['stackz']) ? $_REQUEST['stackz'] : 0;
		$this->stack['y'] = isset($_REQUEST['stacky']) ? $_REQUEST['stacky'] : 0;
		$this->stack['x'] = isset($_REQUEST['stackx']) ? $_REQUEST['stackx'] : 0;
		$this->state = isset($_REQUEST['state']) ? $_REQUEST['state'] : STATE_CLEAN;

	}

	/** process
	 * handle keypress
	*/
	function process() {
		if (isset($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {
				case 'Enter':
					$this->push();
					$this->state = STATE_CLEAN;
					break;

				case 'Clx':
					$this->stack['x'] = 0;
					$this->state = STATE_CLEAN;
					break;

				case '+':
					$this->stack['x'] += $this->stack['y'];
					$this->pop();
					$this->state = STATE_OPERATION;
					break;

				case '-':
					$this->stack['x'] = $this->stack['y'] - $this->stack['x'];
					$this->pop();
					$this->state = STATE_OPERATION;
					break;

				case 'x':
					$this->stack['x'] *= $this->stack['y'];
					$this->pop();
					$this->state = STATE_OPERATION;
					break;

				case '/':
					//handle divided by zero
					if ($this->stack['x'] == 0) {
						$this->state = STATE_ERROR;
						//not sure what to do with the stack - leave it as is?
					} else {
						$this->stack['x'] = $this->stack['y'] / $this->stack['x'];
						$this->pop();
						$this->state = STATE_OPERATION;
					}
					break;

				default:
					//everything else should be numbers
					switch($this->state) {
						case STATE_CLEAN:
							//start, enter, or clear
							//set to number typed
							$this->stack['x'] = $_REQUEST['action'];
							$this->state = STATE_NUMBER;
							break;
						case STATE_NUMBER:
							//partial number
							//append to number typed
							$this->stack['x'] .= $_REQUEST['action'];
							if ($_REQUEST['action'] == '.') {
								$this->state = STATE_DECIMAL;
							}
							break;
						case STATE_DECIMAL:
							if ($_REQUEST['action'] != '.') {
								$this->stack['x'] .= $_REQUEST['action'];
							}
							break;
						case STATE_OPERATION:
							//after operation
							//push, then set to number typed
							$this->push();
							$this->stack['x'] = $_REQUEST['action'];
							$this->state = STATE_NUMBER;
							break;
					}

					break;
			}
		}

#$this->debugger(__FILE__.'#'.__LINE__,'$this',$this);

	}

}
