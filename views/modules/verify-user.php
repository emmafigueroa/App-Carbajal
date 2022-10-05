<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Al verificar si las variables de sesión están configuradas, si lo están, las desactivará. */
if (isset($_SESSION['code']) || isset($_SESSION['email'])) {
    unset($_SESSION['code']);
    unset($_SESSION['email']);
}

if(isset($_SESSION['user-is'])){
    header("Location: home-page.php");
}
/* Este es el código que verifica al usuario. */
if (isset($_POST['verify-user'])) {

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
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query_user = $mysqli->query("SELECT*FROM usuario WHERE correo = '$email'");
            if (isset($query_user)) {
                $row_user = $query_user->num_rows;
                if ($row_user == 1) {
                    $fetch_user = $query_user->fetch_assoc();
                    if (isset($fetch_user['contraseña'])) {
                        $_password = $fetch_user['contraseña'];
                        if ($password != "") {
                            if (password_verify($password, $_password)) {
                                $_SESSION['user-id'] = $fetch_user['id_usuario'];
                                $_SESSION['user-is'] = "yes";
                                
                                header('Location: home-page.php');
                            } else {
                                $caution_password[] = "Contraseña incorrecta.";
                            }
                        }
                    }
                } else {
                    $caution_email[] = "Correo electrónico incorrecto.";
                }
            }
        } else {
            $caution_email[] = "Correo electrónico invalido.";
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

$query_verify_user = $mysqli->query("SELECT*FROM usuario");
if (isset($query_verify_user)) {
    $row_verify_user = $query_verify_user->num_rows;

    if ($row_verify_user == 0) {
        unset($_SESSION['account-created']);
        header("Location: create-user.php");
    } else {
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Iniciar sesión - Carbajal</title>

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
                        <h1>Bienvenido</h1>

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

                        <label for="correo">Contraseña <a href="verify-email.php">Restablecer</a></label>
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

                        <button type="submit" name="verify-user">Iniciar sesión</button>
                    </form>
                </section>
            </div>
            <script src="../scripts/toggle-password-user.js"></script>
            <script src="../scripts/input-caution-user.js"></script>
            <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
        </body>

        </html>

<?php
    }
}

?>