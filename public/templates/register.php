<?php 
    global $user;

    $username = $password = $confirmpassword = $role = '';
    $username_err = $password_err = $confirmpassword_err = $role_err = '';

    //handle post

    renderDiv('container',function(){
        renderH2(null, function(){
            echo 'Register';
        });
        renderP(null, function(){
            echo 'Please fill this form to create an account.';
        });
        renderForm('/register','POST',function(){
            renderDiv('form-group row', function(){
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
            renderDiv('form-group row',function(){
                global $confirmpassword_err;
                renderLabel('inputconfirmPassword',(!empty($confirmpassword_err)) ? 'col-sm-2 col-form-label text-danger' : 'col-sm-2 col-form-label text-success',function(){
                    echo 'confirm password';
                });
                renderDiv('col-sm-7', function(){
                    global $confirmpassword,$confirmpassword_err;
                    renderInput('confirmpassword','confirmpassword','inputconfirmPassword',(!empty($confirmpassword_err)) ? 'form-control is-invalid' : 'form-control', $confirmpassword);
                });
            });
            renderDiv('form-group row',function(){
                global $role_err;
                renderLabel('inputrole',(!empty($role_err)) ? 'col-sm-2 col-form-label text-danger' : 'col-sm-2 col-form-label text-success',function(){
                    echo 'role';
                });
                renderDiv('col-sm-7', function(){
                    global $role_err;
                    renderSelect('role','inputrole',(!empty($role_err)) ? 'form-control custom-select is-invalid' : 'form-control custom-select',array(
                        "student" => "Student",
                        "employer" => "Employer"
                    ),function(){
                        renderOption(null,null,true,function(){
                            echo 'Choose Role';
                        });
                    });
                });
            });
            renderDiv('form-group',function(){
                renderInput('submit',null,null,'btn btn-primary', 'Next');
            });
            renderP(null, function(){
                echo "Already have an account? ",
                renderA('/login',null,function(){
                    echo 'Login';
                }),
                '.'; 
            });
        });
    });
?>