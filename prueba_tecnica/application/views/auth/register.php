<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
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
        .register-container {
            max-width: 600px;
            padding: 50px;
            border: 1px solid #ccc;
            border-radius: 20px;
            background-color: #fff;
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.2);  
        }

        .register-container::after {
            content: '';
            position: fixed;
            top: 10vh;
            right: 40vh;
            width: 100%;
            height: 100%;
            background-color: #2874A6;
            transform: translateY(-50%) rotate(145deg); 
            z-index: -1; 
        }
        .btn-border{
            border-radius: 20px;
            box-shadow: 0 20px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="mb-4">Registrarse</h2>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= html_escape($error) ?></div>
        <?php endif; ?>
        <form action="<?= site_url('auth/add_user'); ?>" method="post">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirmar Contraseña:</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-border"><i class="fa fa-user-plus" aria-hidden="true"></i> Registrarse</button>
        </form>
        <div class="mt-3 text-center">
            <p><a href="<?= site_url('auth/login'); ?>">Volver a Login</a></p>
        </div>
    </div>
</body>
</html>
