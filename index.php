<?php
    include('route.php');

    Route::add('/', function(){
        echo 'welcome!!';
    });

    Route::run('/');
?>