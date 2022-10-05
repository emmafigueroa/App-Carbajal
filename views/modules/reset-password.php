<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Desarmar el código de sesión. */
if (isset($_SESSION['code'])) {
    unset($_SESSION['code']);
}

/* Comprobando si el correo electrónico está configurado en la sesión. Si es así, establecerá la
variable de correo electrónico en el correo electrónico de la sesión. */
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

if (isset($_POST['reset-password'])) {
    $new_password = $mysqli->real_escape_string($_POST['new-password']);


    if (isset($email, $new_password)) {
        if (empty($new_password)) {
            $cautionPassword[] = "Contraseña olvidada.";
        } else {
            $query_password = $mysqli->query("SELECT*FROM user WHERE email = '$email'");
            if (isset($query_password)) {
                $row_password = $query_password->num_rows;
                if ($row_password == 1) {
                    $fetch_password = $query_password->fetch_assoc();
                    if (isset($fetch_password['password'])) {
                        $password = $fetch_password['password'];
                        if (password_verify($new_password, $password)) {
                            $cautionPassword[] = "Ingrese otra contraseña.";
                        } else {
                            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                            $query_change_password = $mysqli->query("UPDATE user SET password = '$new_password_hash' WHERE email = '$email'");

                            if (isset($query_change_password)) {
                                header('Location: ../../views/modules/verify-user.php');
                            }
                        }
                    }
                }
            }
        }
    }
}

/* Si el campo de contraseña está configurado, repita la contraseña. */
function show_password()
{
    if (isset($_POST['password'])) {
        echo $_POST['password'];
    }
}

/* Una declaración condicional que verifica si la variable `['email']` está configurada. Si
está configurado, redirigirá al usuario a la página `verify-email.php`. */
if (!isset($_SESSION['email'])) {
    header("Location: ../../views/modules/verify-email.php");
} else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restablecer su contraseña - toStats</title>

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
                    <h1 class="compressed">Restablecer su contraseña</h1>

                    <p>Ingrese su nueva contraseña para que
                        podamos continuar.</p>
                    <label for="password">Contraseña</label>
                    <div class="component-password">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="new-password" id="password" class="password" placeholder="tunuevacontraseña" autocomplete="current-password" value="<?php show_password(); ?>">
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


                    <div class="component-buttons">
                        <a href="../modules/verify-user.php">Cancelar</a>
                        <button type="submit" name="reset-password">Cambiar contraseña</button>
                    </div>
                </form>
            </section>
        </div>

        <script src="../scripts/toggle-password-user.js"></script>
        <script src="../scripts/input-caution-password.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>