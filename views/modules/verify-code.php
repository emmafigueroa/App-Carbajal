<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Obtener el código de la sesión. */
$code = $_SESSION['code'];

if (isset($_POST['verify-code'])) {
    $code = $mysqli->real_escape_string($_POST['code']);

    if (isset($code)) {
        if (empty($code)) {
            $caution_code[] = " Código olvidado.";
        } else if ($code == $_SESSION['code']) {
            header("Location: ../../views/modules/reset-password.php");
        } else {
            $caution_code[] = " Código incorrecto.";
        }
    }
}

/* Si el código está configurado, repita el código. */
function show_code()
{
    if (isset($_POST['code'])) {
        echo $_POST['code'];
    }
}

/* Esta es una declaración condicional que verifica si la variable `['code']` y
`['email']` están configuradas. Si están configurados, se redirigirá a la página
`verify-email.php`. */
if (!isset($_SESSION['code'], $_SESSION['email'])) {
    header("Location: ../../views/modules/verify-email.php");
} else {

?>

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

                    <p>Ingrese su código que acabamos de enviar a su
                        correo electrónico. Si no lo encuentra verifique
                        la carpeta de spam.</p>
                    <label for="correo">Código</label>
                    <div class="component-code">
                        <i class="fa-solid fa-key"></i>
                        <input type="text" name="code" id="code" placeholder="tucódigo" value="<?php show_code(); ?>">
                    </div>

                    <?php
                    /* Esta es una declaración condicional que verifica si la variable ``
                    está configurada. Si está configurado, recorrerá la variable `` y
                    mostrará el mensaje de error. */
                    if (isset($caution_code)) {
                        foreach ($caution_code as $c) {
                            echo '<div class="cautionCode"><p>' . $c . '</p></div>';
                        }
                    }
                    ?>


                    <div class="component-buttons">
                        <a href="../modules/verify-user.php">Cancelar</a>
                        <button type="submit" name="verify-code">Enviar código</button>
                    </div>
                </form>
            </section>
        </div>
        <script src="../scripts/input-caution-code.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } ?>