<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
    
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            position: relative;
            max-width: 400px;
            padding: 40px;
            border-radius: 20px;
            background-color: #fff;
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow: hidden; 
        }

        .login-container::after {
            content: '';
            position: fixed;
            top: 25vh;
            left: 55vh;
            width: 100%;
            height: 100%;
            background-color: #2874A6;
            transform: translateY(-50%) rotate(45deg); 
            z-index: -1;
        }

        .login-container h2{
            text-align: center;
        }
        .login-container img{
            width: 180px;
            display: block;
            margin: 0 auto;
        }
        .btn-border{
            border-radius: 20px;
            box-shadow: 0 20px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="https://www.shutterstock.com/image-vector/user-login-authenticate-icon-human-600nw-1365533969.jpg" alt="">
        <h2 class="mb-4">Iniciar Sesión</h2>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= html_escape($error) ?></div>
        <?php endif; ?>
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= html_escape($success) ?></div>
        <?php endif; ?>
        <form action="<?php echo site_url('auth/login'); ?>" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id="username" name="username" placeholder="username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-border">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Login</button>
        </form>
        <div class="mt-3 text-center">
            <p>¿No tienes una cuenta? <a href="<?= site_url('auth/register'); ?>">Registrarse</a></p>
        </div>
    </div>
</body>
</html>
