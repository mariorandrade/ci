<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Kyuubi</title>
    <link rel="stylesheet" href="<?php echo $this->assets->url('bootstrap.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo $this->assets->url('kyuubi.theme.css'); ?>"/>




</head>
<body>

<div class="container-fluid main-wrapper">
    <div class="row">
        <div class="col-xs-3 center-block">
            <?php echo form_open('admin/dashboard', array('class' => 'frmLogin', 'id' => 'frmLogin')); ?>
            <h2 class="text-center">Login</h2>
            <div class="form-group">
                <label for="email" class="sr-only">E-mail</label>
                <?php echo form_input(array('class' => 'form-control', 'name' => 'email', 'id' => 'email', 'placeholder' => 'E-mail')); ?>
            </div>

            <div class="form-group">
                <label for="email hidden" class="sr-only">Password</label>
                <?php echo form_password(array('name' => 'password', 'id' => 'password', 'placeholder' => 'Password', 'class' => 'form-control')); ?>
            </div>

            <div class="form-group">
                <div class="onoffswitch">

                    <input type="checkbox" name="saveLoginCreds" class="onoffswitch-checkbox" id="saveLoginCreds" checked="">
                    <label for="saveLoginCreds"><small>Guardar dados de login</small></label>
                </div>
            </div>

            <div class="form-group text-center">
                <?php echo form_button(array('type' => 'submit', 'name' => 'frmBtnSubmit', 'id' => 'frmBtnSubmit', 'content' => 'Login', 'class' => 'btn btn-primary btn-block')); ?>
            </div>


            <?php echo form_close(); ?>
        </div>
    </div>
</div>



</body>
</html>