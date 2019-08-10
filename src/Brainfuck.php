<?php

namespace App;

class Brainfuck
{

    const DATA_ARRAY_SIZE = 30000;

    protected $ip = 0; //Instruction Pointer

    protected $dp = 0;

    protected $data = null; //an array of data

    /** @var array */
    protected $program = [];

    protected $matchingBrackets = [];

    public function __construct($program)
    {
        $this->program = str_split($program);
        $this->data = array_fill(0, self::DATA_ARRAY_SIZE, 0);
        $this->determineMatchingBrackets();
    }

    public function getProgram()
    {
        return $this->program;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getState()
    {
        return [
          'ip' => $this->ip,
          'dp' => $this->dp,
          'program' => (new \ArrayObject($this->program))->getArrayCopy(),
          'data' => (new \ArrayObject($this->data))->getArrayCopy(),
        ];
    }

    public function run()
    {
        $running = true;
        while ($running) {
            $currentInstruction = $this->program[$this->ip];

            switch ($currentInstruction) {
                case('>'):
                    $this->dp++;
                    break;
                case('<'):
                    $this->dp--;
                    break;
                case('+'):
                    $this->data[$this->dp]++;
                    break;
                case('-'):
                    $this->data[$this->dp]--;
                    break;
                case('['):
                    if ($this->data[$this->dp] == 0) {
                        $this->ip = $this->matchingBrackets[$this->ip];
                    }
                    break;
                case(']'):
                    if ($this->data[$this->dp] != 0) {
                        $this->ip = $this->matchingBrackets[$this->ip];
                    }
                    break;
                case('.'): //output the byte at the data pointer
                    print(chr($this->data[$this->dp]));
                    break;
                case(','): //accept one byte of input, store at dp location
                    $this->data[$this->dp] = ord(fgetc(STDIN));
                    break;
            }

            $this->ip++;
            if (!isset($this->program[$this->ip])) {
                $running = false;
            }
        }
    }

    public function getMatchingBracketList()
    {
        $this->determineMatchingBrackets();
        return $this->matchingBrackets;
    }

    protected function determineMatchingBrackets()
    {
        $stack = [];
        foreach ($this->program as $i => $v) {
            switch ($v) {
                case('['):
                    array_push($stack, $i);
                    break;
                case(']'):
                    $matchingIndex = array_pop($stack);
                    if (is_null($matchingIndex)) {
                        throw new SyntaxException("Unbalanced Brackets");
                    }
                    $this->matchingBrackets[$matchingIndex] = $i;
                    $this->matchingBrackets[$i] = $matchingIndex;
                    break;
            }
        }
    }

}
