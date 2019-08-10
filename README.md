# brainfuck_php

I wanted to see what [Brainfuck](https://en.wikipedia.org/wiki/Brainfuck) is about so I wrote up a PHP BF interpreter.
Couple things I think would be good TODO:

* Inject the read/write streams into the Brainfuck class - it's 23:10 now and I want to go to bed (and after seeing the "hello world" program running, interest has flagged).
* Once we have the above working, actually write tests for the input/output commands.
* Maybe write a couple more tests of failure - BF is a pretty forgiving language though ...
* Chage up the dodgy(ish) bracket matching functionality. It works, I suppose, but there's probably a much more elegant way of doing (basically all of) it.

Importantly, though, I think this would be a great pair-programming/code-retreat exercise. Will try expand this to be a TDD task/kata.

Fun project though!
