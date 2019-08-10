<?php
/**
 * Created by PhpStorm.
 * User: bomoko
 * Date: 10/08/19
 * Time: 7:17 PM
 */

use App\Brainfuck;
use PHPUnit\Framework\TestCase;

class BrainfuckTest extends TestCase
{

    public $testProgram = "++++++++[>++++[>++>+++>+++>+<<<<-]>+>+>->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<.+++.------.--------.>>+.>++.";

    /** @test */
    public function it_should_be_true()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_accept_a_program_as_its_first_argument()
    {
        $bf = new Brainfuck($this->testProgram);

        $this->assertEquals($this->testProgram, implode("", $bf->getProgram()));
    }

    /** @test */
    public function it_should_initialize_the_data_array_with_30k_0_elements()
    {
        $bf = new Brainfuck($this->testProgram);

        $this->assertCount(30000, $bf->getData());
    }



    /** @test */
    public function it_should_produce_a_list_of_matching_brackets() {
        $testProgram = "[>[>]>]"; //has matches at 0-6 and 2-4
        $bf = new Brainfuck($testProgram);
        $matches = $bf->getMatchingBracketList();
        $this->assertEquals(0, $matches[6]);
        $this->assertEquals(6, $matches[0]);
        $this->assertEquals(2, $matches[4]);
        $this->assertEquals(4, $matches[2]);
    }

    /**
     * @test
     */
    public function it_should_throw_a_syntax_error_if_there_arent_matching_brackets() {
        $testProgram = "][>[>]>]"; //has unbalanced braces
        $this->expectException(\App\SyntaxException::class);
        $bf = new Brainfuck($testProgram);
    }

    /**
     * @test
     */
    public function greater_that_should_move_the_data_pointer_one_to_the_right() {

        $bf = new Brainfuck('>');
        $state = $bf->getState();
        $this->assertTrue($state['dp'] == 0);
        $bf->run();
        $endState = $bf->getState();
        $this->assertTrue($endState['dp'] == 1);
    }

    /**
     * @test
     */
    public function less_that_should_move_the_data_pointer_one_to_the_left() {

        $bf = new Brainfuck('>>><');
        $state = $bf->getState();
        $this->assertTrue($state['dp'] == 0);
        $bf->run();
        $endState = $bf->getState();
        $this->assertTrue($endState['dp'] == 2); //since it has been
        //incremented three times and decremented once, we should end up dp=2
    }

    /**
     * @test
     */
    public function plus_should_increment_value_at_dp() {

        $bf = new Brainfuck('++');
        $bf->run();
        $endState = $bf->getState();
        $this->assertTrue($endState['data'][$endState['dp']] == 2);
    }

    /**
     * @test
     */
    public function minus_should_decrement_value_at_dp() {

        $bf = new Brainfuck('>>>>>++++--');
        $bf->run();
        $endState = $bf->getState();
        $this->assertTrue($endState['data'][$endState['dp']] == 2);
    }

    /**
     * @test
     */
    public function should_be_able_to_loop() {

        $bf = new Brainfuck('+++[>+<-]');
        //this program should loop three times, leaving 3 in the data[1] position
        $bf->run();
        $endState = $bf->getState();
        $this->assertTrue($endState['data'][1] == 3);
    }

}
