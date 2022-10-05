<?php

/* Incluyendo el archivo connection.php. */

include '../../connection.php';

session_start();

/* Al verificar si las variables de sesión están configuradas, si lo están, las desactivará. */
if (isset($_SESSION['code']) || isset($_SESSION['email'])) {
    unset($_SESSION['code']);
    unset($_SESSION['email']);
}

/* Redirigir al usuario a la página verificar-usuario.php si la cuenta de sesión creada está
configurada. */
if (isset($_SESSION['account-created'])) {
    header("Location: verify-user.php");
}


/* Al verificar si el formulario ha sido enviado, si es así, verificará si el nombre de usuario, el
correo electrónico y la contraseña están configurados, si lo están, verificará si están vacíos, si
lo están, mostrará un mensaje, si lo están. no, codificará la contraseña e insertará los datos en la
base de datos. */

if (isset($_POST['create-account'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);

    if (isset($email, $password)) {
        if (empty($email) && empty($password)) {
            $caution_email[] = "Correo electrónico olvidado.";
            $caution_password[] = "Contraseña olvidada.";
        } else if (empty($email)) {
            $caution_email[] = "Correo electrónico olvidado.";
        } else if (empty($password)) {
            $caution_password[] = "Contraseña olvidada.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $query_create_account = $mysqli->query("INSERT INTO usuario(usuario,correo,contraseña) VALUES('root','$email','$password_hash')");
            if (isset($query_create_account)) {
                $_SESSION['account-created'] = 1;
                header("Location: ../../index.php");
            }
        }
    }
}

/* Si el campo de correo electrónico está configurado, repita el campo de correo electrónico. */
function show_email()
{
    if (isset($_POST['email'])) {
        echo $_POST['email'];
    }
}

/* Si el campo de contraseña está configurado, repita la contraseña. */
function show_password()
{
    if (isset($_POST['password'])) {
        echo $_POST['password'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - Carbajal</title>

    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/css/index.css">
</head>

<body>
    <div class="container">
        <header>
            <img src="../images/carbajal.png">
            <h1>Carbajal</h1>
        </header>
        <section>
            <form action="" method="post">
                <h1>Registrarse</h1>

                <label for="correo">Correo electrónico</label>
                <div class="component-email">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="tucorreoelectrónico@gmail.com" autocomplete="email" value="<?php show_email(); ?>">
                </div>

                <?php
                /* Esta es una declaración condicional que verifica si la variable ``
                está configurada. Si está configurado, recorrerá la variable `` y
                mostrará el mensaje de error. */
                if (isset($caution_email)) {
                    foreach ($caution_email as $c) {
                        echo '<div class="cautionEmail"><p>' . $c . '</p></div>';
                    }
                }
                ?>

                <label for="correo">Contraseña</label>
                <div class="component-password">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" class="password" placeholder="tucontraseña" autocomplete="current-password" value="<?php show_password(); ?>">
                    <i class="fa-solid fa-eye" id="eye"></i>
                </div>

                <?php
                /* Esta es una declaración condicional que verifica si la variable ``
                está configurada. Si está configurado, recorrerá la variable `` y
                mostrará el mensaje de error. */
                if (isset($caution_password)) {
                    foreach ($caution_password as $c) {
                        echo '<div class="cautionPassword"><p>' . $c . '</p></div>';
                    }
                }
                ?>

                <button type="submit" name="create-account">Crear cuenta</button>
            </form>
        </section>
    </div>
    <script src="../scripts/toggle-password-user.js"></script>
    <script src="../scripts/input-caution-user.js"></script>
    <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
</body>

</html>