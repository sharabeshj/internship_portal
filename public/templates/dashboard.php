<?php 
    global $user;
    if(!$user->cookie_login())
    {
        header('HTTP/1.0 403 Unauthorized');
        renderA('/login', null, function() { echo 'Click here to login';});
    }
    else{
        renderDiv("container",function()
        {
            renderDiv("row",function()
            {
                renderDiv('col-md-8',function()
                {
                    renderH1("my-8",function(){
                        echo '{% total %} total internships';
                    });
                });
            });
        });
    }
?>