<!DOCTYPE html>
<?php
    include('route.php');
    include('public/templates/renderers.php');
    include('authentication.php');

    $user = new User();

    Route::add('/test.html',function(){
        echo 'Hello from test.html';
    });

    Route::add('/login',function(){
        include('public/templates/login.php');
    });

    Route::add('/login', function(){
        include('public/templates/login.php');
    },'post');

    Route::add('/register',function(){
        include('public/templates/register.php');
    });

    Route::add('/register', function(){
        include('public/templates/register.php');
    }, 'POST');

    Route::add('/', function(){
        include('public/templates/dashboard.php');
    });

    Route::pathNotFound(function()
    {
        renderA('/',null,function() { echo 'Redirect to home'; });
    });
    
    renderHTML(function()
    {
        renderHead(function()
        {
            renderTitle(function() 
            {
                echo 'Internships Portal';
            });
            renderLink('stylesheet','https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css','sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T','anonymous');
            renderScript('https://code.jquery.com/jquery-3.3.1.slim.min.js','sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo','anonymous');
            renderScript('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js','sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1', 'anonymous');
            renderScript('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js','sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM', 'anonymous');
        });
        renderBody(function()
        {
            Route::run('/');
        });
    });
?>