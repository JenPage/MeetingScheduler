<?php

return [

    'user_model' => App\User::class,

    'message_model' => Cmgmyr\Messenger\Models\Message::class,

    'participant_model' => Cmgmyr\Messenger\Models\Participant::class,

    'thread_model' => Cmgmyr\Messenger\Models\Thread::class,

    /**
     * Define custom database table names - without prefixes.
     */
    'messages_table' => 'cmgmessages',

    'participants_table' => 'cmgparticipants',

    'threads_table' => 'cmgthreads',
];
