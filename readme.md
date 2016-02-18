readme.md

OVERVIEW

rpn calculator 

The challenge at hand is to create a 'Reverse Polish Notation' calculator in PHP. 
 
* http://en.wikipedia.org/wiki/Reverse_Polish_notation
* http://www.calculator.org/rpn.aspx
 
There is only one rule. It must function. 
 
Outside of the single rule that it needs to work, feel free to implement this in any way you see fit and have fun with it.

NOTES

examples, notes: 
http://hp15c.org/RPNHowTo.php
http://www.lehigh.edu/~sgb2/rpnTutor.html

Implemented in PHP, as specified.  This could be implemented in Javascript instead, and would be all client-side, faster and no submits.

Implemented input from clicking numbers, rather than from a text entry field.

Every keypress is a submit, including numbers.  This is mainly done to properly handle the display formatting.

Display is implemented to match HP12c.
	-trailing dot
	-thousands commas

Stack is implmented to match HP12c - 4 registers T, Z, Y, X

Divide by zero implemented as 'Error 0'.

Stack and display are shown below, for unit test purposes.

INSTALLATION

Drop all these in a folder on a webserver (or localhost).

-View is index.php

-Controller is rpn.php

To run unit tests:
(The simpletest folder is large, it's all the includes for unit testing.)
-cd to ./tests directory
-modify testrpn.php - put in your URL in the define.
-php testrpn.php

BACKLOG
These are the items I would like to do next.

-accept keypresses in addition to clicks (Javascript)

-number of characters (10 digits) and overflow

-Scientific display of large numbers

-function key (mainly to set decimals f1-f9)

-sqrt, y^x, x<>y, etc.
