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
        $testotherfacade = new TestOtherFacade;

        return $testotherfacade->testOtherFacade();
    }

    public function factory()
    {
        $message = new MessageMaker();

        $message->make('DirectMessage');
        var_dump($message->getMessageTypes());

        $message->make('MailMessage');
        var_dump($message->getMessageTypes());

        $message->make('BroadcastMessage');
        var_dump($message->getMessageTypes());

    }
}