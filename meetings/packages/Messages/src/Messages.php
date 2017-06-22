<?php
namespace Messages;

use Messages\MessageMaker;
use Messages\TestFacade;

class Messages
{
    public function test_facade()
    {
        $testfacade = new TestFacade;

        return $testfacade->testMessageFacade();
    }


    public function test_other_facade()
    {
        return 'blah';
        $testotherfacade = new TestOtherFacade;

        return $testotherfacade->testOtherFacade();
    }

    public static function factory($type)
    {
        $message = new MessageMaker();

        return $message->make($type);
    }
}