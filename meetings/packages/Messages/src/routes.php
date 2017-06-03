<?php

namespace Messages;

use Route;

use Messages;

Route::get('message_singleton', function(){

    echo '<pre>
    $var = app(\'MessageLogger\');

    $var->value = \'test\';

    $var2 = app(\'MessageLogger\');

    $var2->value = \'test2\';

    echo "This proves there is only one instance". $var->value. = .$var2->value
    </pre>';

    $var = app('MessageLogger');

    $var->value = 'test';

    $var2 = app('MessageLogger');

    $var2->value = 'test2';

    echo "This proves there is only one instance..  ". $var->value. ' = ' .$var2->value;

    $var2->log('test log');

});

Route::get('message_factory', 'Messages\Messages@factory');