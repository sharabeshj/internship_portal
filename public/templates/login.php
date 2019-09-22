<?php
    session_start();

    global $user;
    if($user->cookie_login()){
        header('Location: /');
        exit;
    }
    
    $username = $password = '';
    $username_err = $password_err = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(empty(trim($_POST['username']))){
            $username_err = 'Please enter username.';
        }
        else{
            $username = trim($_POST['username']);
        }

        if(empty(trim($_POST['password']))){
            $password_err = 'Please enter your password.';
        }
        else{
            $password = trim($_POST['password']);
        }

        if(empty($username_err) && empty($password_err)){
            if($user->login($username,$password)){
                session_start();
                header('Location: /');
            }
            else {
                global $username, $username_err, $password,$password_err;
                $username = $password = '';
                $username_err = $password_err = 'Invalid Credentials';
            }
        }
    }

    renderDiv('container',function(){
        renderDiv('wrapper', function(){
            renderH2(null, function(){
                echo 'Login';
            });
            renderP(null, function(){
                echo 'Please fill in your credentials to login.';
            });
            renderForm('/login','POST',function(){
                renderDiv('form-group row',function(){
                    global $username_err;
                    renderLabel('inputUsername',(!empty($username_err)) ? 'col-sm-2 col-form-label text-danger' : 'col-sm-2 col-form-label text-success',function(){
                        echo 'Username';
                    });
                    renderDiv('col-sm-7', function(){
                        global $username,$username_err;
                        renderInput('text','username','inputUsername',(!empty($username_err)) ? 'form-control is-invalid' : 'form-control', $username);
                    });
                });
                renderDiv('form-group row',function(){
                    global $password_err;
                    renderLabel('inputPassword',(!empty($password_err)) ? 'col-sm-2 col-form-label text-danger' : 'col-sm-2 col-form-label text-success',function(){
                        echo 'password';
                    });
                    renderDiv('col-sm-7', function(){
                        global $password,$password_err;
                        renderInput('password','password','inputPassword',(!empty($password_err)) ? 'form-control is-invalid' : 'form-control', $password);
                    });
                });
                renderDiv('form-group',function(){
                    renderInput('submit',null,null,'btn btn-primary', 'Login');
                });
                renderP(null, function(){
                    echo "Don't have an account? ",
                    renderA('/register',null,function(){
                        echo 'Sign up';
                    }),
                    '.'; 
                });
            });
        });
    });
?>