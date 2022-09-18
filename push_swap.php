<?php

class Pushswap
{
    public $la;
    public $lb = [];
    public $min;
    public $max;
    public $change = false;
    public $tableFunctions = [];
    public function __construct($argv)
    {
        array_shift($argv);
        $this->la = $argv;
        $this->min = min($argv);
        $this->max = max($argv);
    }

    function mainFunction()
    {
        if ($this->change == false) {   // Tableau [la]
            if (count($this->la) < 2) {
                return;
            } else if ($this->la[0] == $this->max) {
                $this->ra();
                return;
            }

            if ($this->la[0] > $this->la[1]) {
                $this->sa();
                return;
            }

            for ($x = 0; $x < count($this->la) - 1; $x++) {
                if ($this->la[$x] > $this->la[$x + 1]) {
                    $this->pb($x);
                    return;
                }
            }

            if (array_key_last($this->la) == $this->min) {
                $this->rra();
                return;
            }
        } else {  // Tableau [lb]
            if (count($this->lb) == 1) {
                $this->change = false;
                $this->pa(1);
                return;
            }

            if ($this->lb[0] == $this->min) {
                $this->rb();
                return;
            }

            if (count($this->lb) == 1) {
                $this->change = false;
                $this->pa(1);
                return;
            }

            if ($this->lb[0] < $this->lb[1]) {
                $this->sb();
                return;
            }

            for ($x = 0; $x < count($this->lb) - 1; $x++) {
                if ($this->lb[$x] > $this->lb[$x + 1]) {
                    $this->pa($x + 1);
                    return;
                }
            }

            if (array_key_last($this->lb) == $this->max) {
                echo "echo";
                $this->rrb();
                return;
            }
        }
        if (count($this->lb) > 1) {
            $this->change = true;
            $this->mainFunction();
            return;
        }
        echo implode(" ", $this->tableFunctions) . PHP_EOL;
    }

    function sa()  // mini functions
    {
        array_push($this->tableFunctions, "sa");
        $holdIt = $this->la[0];
        $this->la[0] = $this->la[1];
        $this->la[1] = $holdIt;
        $this->mainFunction();
    }

    function pb($x)
    {
        for ($i = 0; $i < $x; $i++) {
            array_push($this->tableFunctions, "pb");
            array_unshift($this->lb, $this->la[0]);
            array_shift($this->la);
        }
        $this->mainFunction();
    }

    function sb()
    {
        array_push($this->tableFunctions, "sb");
        $holdIt = $this->lb[0];
        $this->lb[0] = $this->lb[1];
        $this->lb[1] = $holdIt;
    }

    function pa($x)
    {
        for ($i = 0; $i < $x; $i++) {
            array_push($this->tableFunctions, "pa");
            array_unshift($this->la, $this->lb[0]);
            array_shift($this->lb);
        }
        $this->mainFunction();
    }

    function ra()
    {
        array_push($this->tableFunctions, "ra");
        $firstElement = array_shift($this->la);
        array_push($this->la, $firstElement);
        $this->mainFunction();
    }

    function rra()
    {
        array_push($this->tableFunctions, "rra");
        $lastElement = array_key_last($this->la);
        array_unshift($this->la, $lastElement);
        $this->mainFunction();
    }

    function rb()
    {
        array_push($this->tableFunctions, "rb");
        $firstElement = array_shift($this->lb);
        array_push($this->lb, $firstElement);
        $this->mainFunction();
    }

    function rrb()
    {
        array_push($this->tableFunctions, "rrb");
        $lastElement = array_key_last($this->lb);
        array_unshift($this->lb, $lastElement);
        $this->mainFunction();
    }
}
$myPush = new Pushswap($argv);
$myPush->mainFunction();
