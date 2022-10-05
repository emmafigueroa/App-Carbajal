<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Al verificar si las variables de sesión están configuradas, si lo están, las desactivará. */
if (isset($_SESSION['code']) || isset($_SESSION['email'])) {
    unset($_SESSION['code']);
    unset($_SESSION['email']);
}

/* Importando la clase PHPMailer. */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['verify-email'])) {
    $email = $mysqli->real_escape_string($_POST['email']);

    if (isset($email)) {
        if (empty($email)) {
            $caution_email[] = " Correo electrónico olvidado.";
        } else if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query_email = $mysqli->query("SELECT * FROM usuario WHERE correo = '$email'");
            if (isset($query_email)) {
                $row_email = $query_email->num_rows;
                if ($row_email == 1) {
                    $user = explode('@', $email);
                    $generate_code = mt_rand(0, 1000000);

                    $message_mail = "    
                        <html>
                            <body style='display:grid; margin: 0 auto; background: transparent; width: 40vw;'>
                                <header style='display:flex; color: #5884ff;
                                border-bottom: 2px solid #282a3020;'>
                                    <h1 style='justify-content: center;   margin-left: 15px; padding: 10px; '>Proyecto Stats</h1>
                                </header>
                                <section style='display:grid; color: #13141795; padding: 40px 30px; font-size: .95rem;'> 

                                        <span style='margin-left: 25px;'>Hola, <b>" . $user[0] . "</b>:</span>
                                        <span style='margin-left: 25px;'>Ingresa el siguiente código para recuperar tu cuenta:</span>
                                        <span style='margin-left: 25px; margin-top: 15px; font-size: 1.125rem; color: #5884ff;'><b>" . $generate_code . "</b></span>     

                                </section>
                                <footer style='display:grid; color: #131417; padding: 20px 0; font-size: .95rem; border-top: 2px solid #282a3020;'>
                                    <p style='margin: 0 auto;'>from</p>
                                    <p style='margin: 0 auto;'>Proyecto<b>Stats</b></p>
                                </footer>
                        </body>
                    </html>";

                    require_once '../modules/phpmailer/Exception.php';
                    require_once '../modules/phpmailer/PHPMailer.php';
                    require_once '../modules/phpmailer/SMTP.php';

                    $mail = new PHPMailer();

                    try {
                        $mail->isSMTP();
                        $mail->CharSet = 'UTF-8';
                        $mail->Host = 'smtp.gmail.com';

                        $mail->SMTPAuth = true;
                        $mail->Username = 'proyectostats@gmail.com';
                        $mail->Password = 'veecykpevoumpqsl';

                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        $mail->setFrom('proyectostats@gmail.com', 'Proyecto Stats');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = $generate_code . ' es el código para recuperar tu cuenta';
                        $mail->Body = $message_mail;

                        $mail->send();
                    } catch (Exception $e) {
                        $mail->ErrorInfo;
                    }

                    $_SESSION['code'] = $generate_code;
                    $_SESSION['email'] = $email;

                    if (isset($_SESSION['code'])) {
                        header("Location: ../../views/modules/verify-code.php");
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

if (!isset($_SESSION['email'])) {
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

                    <p>Ingrese su correo electrónico para que
                        podamos restablecer su contraseña.</p>
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


                    <div class="component-buttons">
                        <a href="../modules/verify-user.php">Cancelar</a>
                        <button type="submit" name="verify-email">Enviar correo</button>
                    </div>

                </form>
            </section>
        </div>
        <script src="../scripts/input-caution-email.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>

<?php
}
?>