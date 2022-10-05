<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['user-is'])) {

    if (isset($_POST['add-personal'])) {
        $full_name = $mysqli->real_escape_string($_POST['full-name']);
        $rfc = $mysqli->real_escape_string($_POST['rfc']);
        $curp = $mysqli->real_escape_string($_POST['curp']);
        $gender = $mysqli->real_escape_string($_POST['gender']);
        $function = $mysqli->real_escape_string($_POST['function']);
        $school_key = $mysqli->real_escape_string($_POST['school-key']);
        $teacher_square = $mysqli->real_escape_string($_POST['teacher-square']);
        $career_level = $mysqli->real_escape_string($_POST['career-level']);
        $study_grade = $mysqli->real_escape_string($_POST['study-grade']);
        $study_status = $mysqli->real_escape_string($_POST['study-status']);
        $school_check = $mysqli->real_escape_string($_POST['school-check']);
        $register_secretary = $mysqli->real_escape_string($_POST['register-secretary']);
        $register_zone = $mysqli->real_escape_string($_POST['register-zone']);
        $register_school = $mysqli->real_escape_string($_POST['register-school']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $cellphone = $mysqli->real_escape_string($_POST['cellphone']);

        if (isset($full_name, $gender, $curp, $rfc, $email, $cellphone, $function, $school_key, $school_check, $teacher_square, $career_level, $study_grade, $study_status, $register_secretary, $register_zone, $register_school)) {
            if (
                empty($full_name) || empty($gender) || empty($curp) || empty($rfc) || empty($email) || empty($cellphone) || empty($function) || empty($school_key)
                || empty($school_check) || empty($teacher_square) || empty($career_level) || empty($study_grade) || empty($study_status)
            ) {
                if (empty($full_name)) {
                    $caution_full_name[] = "Nombre completo olvidado";
                }
                if (empty($rfc)) {
                    $caution_rfc[] = "Rfc olvidada";
                }
                if (empty($curp)) {
                    $caution_curp[] = "Curp olvidada";
                }
                if (empty($gender)) {
                    $caution_gender[] = "Genero olvidado";
                }
                if (empty($function)) {
                    $caution_function[] = "Función olvidada";
                }
                if (empty($school_key)) {
                    $caution_school_key[] = "Clave escolar olvidada";
                }
                if (empty($school_check)) {
                    $caution_school_check[] = "Cheque escolar olvidado";
                }
                if (empty($teacher_square)) {
                    $caution_teacher_square[] = "Plaza de maestro olvidada";
                }
                if (empty($career_level)) {
                    $caution_career_level[] = "Nivel de carrera olvidado";
                }
                if (empty($study_grade)) {
                    $caution_study_grade[] = "Grado de estudio olvidado";
                }
                if (empty($study_status)) {
                    $caution_study_status[] = "Estado de estudio olvidado";
                }
                if (empty($email)) {
                    $caution_email[] = "Correo electrónico olvidado";
                }
                if (empty($cellphone)) {
                    $caution_cellphone[] = "Celular olvidado";
                }
            } else {
                $query_add_personal = $mysqli->query("INSERT INTO personal(nombre_completo, rfc, curp, genero, funcion, clave_escolar, plaza, nivel_carrera, grado_estudio, estado_estudio, cheque_escolar, registro_secretaria, registro_zona, registro_escuela, correo, celular) VALUES('$full_name', '$rfc', '$curp', '$gender', '$function', '$school_key', '$teacher_square', '$career_level', '$study_grade', '$study_status', '$school_check', '$register_secretary', '$register_zone', '$register_school', '$email', '$cellphone')");
                if (isset($query_add_personal)) {
                    header("Location: personal.php");
                }
            }
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Emmanuel Paniagua Figueroa">
        <meta name="description" content="Control Carbajal es una aplicación desarrollada para la gestion del control escolar de la Primaria 
        Maria Gutierrez Carbajal mediante tecnologias como PHP, HTML, CSS y JS.">

        <title>Personal - Carbajal</title>

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>

        <header>
            <div class="logotype">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h2>Registrar personal</h2>
            <div class="navigation">
                <a href="home-page.php"><i class="bx bxs-home"></i> </a>
                <i class='bx bxs-grid-alt' id="bxs-grid-alt" tabindex="0"></i>
            </div>
        </header>

        <section class="menu" id="menu">
            <p>Menu</p>
            <div class="sub-menu">
                <a href="school.php"><i class="bx bxs-graduation"></i>
                    <p>Escuela</p>
                </a>
                <a href="personal.php"><i class="bx bxs-user"></i>
                    <p>Personal</p>
                </a>
                <a href="teacher.php"><i class="bx bxs-chalkboard"></i>
                    <p>Docente</p>
                </a>
                <a href="student.php"><i class="bx bxs-group"></i>
                    <p>Alumnos</p>
                </a>
                <a href="statistics.php"><i class="bx bxs-bar-chart-alt-2"></i>
                    <p>Estadisticas</p>
                </a>
                <a href="log-out.php" class="log-out"><i class='bx bxs-x-circle'></i>
                    <p>Cerrar sesión</p>
                </a>
            </div>
        </section>
        <section class="add-personal">
            <form action="" method="post">
                <div class="input-personal">
                    <div class="personal-data">
                        <h3>Datos personales</h3>
                        <div class="full-name">
                            <label for="full-name">Nombre completo</label>
                            <input type="text" placeholder="Alberto Men" name="full-name" id="full-name" value="<?php if (isset($_POST['full-name'])) {
                                                                                                                    echo $_POST['full-name'];
                                                                                                                } ?>">
                            <?php
                            if (isset($caution_full_name)) {
                                foreach ($caution_full_name as $c) {
                                    echo '<div class="caution-full-name"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="rfc">
                            <label for="rfc">RFC</label>
                            <input type="text" placeholder="AMRXXXXXXM" name="rfc" id="rfc" value="<?php if (isset($_POST['rfc'])) {
                                                                                                        echo $_POST['rfc'];
                                                                                                    } ?>">
                            <?php
                            if (isset($caution_rfc)) {
                                foreach ($caution_rfc as $c) {
                                    echo '<div class="caution-rfc"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="curp">
                            <label for="curp">CURP</label>
                            <input type="text" placeholder="AMRXXXXXXGNMX" name="curp" id="curp" value="<?php if (isset($_POST['curp'])) {
                                                                                                            echo $_POST['curp'];
                                                                                                        } ?>">
                            <?php
                            if (isset($caution_curp)) {
                                foreach ($caution_curp as $c) {
                                    echo '<div class="caution-curp"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="gender">
                            <label for="gender">Genero</label>
                            <select name="gender" id="gender">
                                <option value="<?php if (isset($_POST['gender'])) {
                                                    echo $_POST['gender'];
                                                } ?>">
                                    <?php
                                    if (isset($_POST['gender'])) {
                                        if ($_POST['gender'] == "M") {
                                            echo "Masculino";
                                        }

                                        if ($_POST['gender'] == "F") {
                                            echo "Femenino";
                                        }

                                        if ($_POST['gender'] == "") {
                                            echo "Seleccione un genero";
                                        }
                                    } else {
                                        echo "Seleccione un genero";
                                    }
                                    ?>
                                </option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                            <?php
                            if (isset($caution_gender)) {
                                foreach ($caution_gender as $c) {
                                    echo '<div class="caution-gender"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="labor-data">
                        <h3>Datos laborales</h3>
                        <div class="function">
                            <label for="function">Función</label>
                            <input type="text" placeholder="Docente" name="function" id="function" value="<?php if (isset($_POST['function'])) {
                                                                                                                echo $_POST['function'];
                                                                                                            } ?>">
                            <?php
                            if (isset($caution_function)) {
                                foreach ($caution_function as $c) {
                                    echo '<div class="caution-function"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="school-key">
                            <label for="school-key">Clave escolar</label>
                            <input type="text" placeholder="XXXXXXEXXXX" name="school-key" id="school-key" value="<?php if (isset($_POST['school-key'])) {
                                                                                                                        echo $_POST['school-key'];
                                                                                                                    } ?>">
                            <?php
                            if (isset($caution_school_key)) {
                                foreach ($caution_school_key as $c) {
                                    echo '<div class="caution-school-key"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="teacher-square">
                            <label for="teacher-square">Plaza</label>
                            <input type="text" placeholder="Base" name="teacher-square" id="teacher-square" value="<?php if (isset($_POST['teacher-square'])) {
                                                                                                                        echo $_POST['teacher-square'];
                                                                                                                    } ?>">
                            <?php
                            if (isset($caution_teacher_square)) {
                                foreach ($caution_teacher_square as $c) {
                                    echo '<div class="caution-teacher-square"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="career-level">
                            <label for="career-level">Nivel de carrera</label>
                            <input type="text" placeholder="A" name="career-level" id="career-level" value="<?php if (isset($_POST['career-level'])) {
                                                                                                                echo $_POST['career-level'];
                                                                                                            } ?>">
                            <?php
                            if (isset($caution_career_level)) {
                                foreach ($caution_career_level as $c) {
                                    echo '<div class="caution-career-level"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="study-grade">
                            <label for="study-grade">Grado de estudio</label>
                            <input type="text" placeholder="Licenciatura" name="study-grade" id="study-grade" value="<?php if (isset($_POST['study-grade'])) {
                                                                                                                            echo $_POST['study-grade'];
                                                                                                                        } ?>">
                            <?php
                            if (isset($caution_study_grade)) {
                                foreach ($caution_study_grade as $c) {
                                    echo '<div class="caution-study-grade"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="study-status">
                            <label for="study-status">Estado de estudio</label>
                            <input type="text" placeholder="Pasante" name="study-status" id="study-status" value="<?php if (isset($_POST['study-status'])) {
                                                                                                                        echo $_POST['study-status'];
                                                                                                                    } ?>">
                            <?php
                            if (isset($caution_study_status)) {
                                foreach ($caution_study_status as $c) {
                                    echo '<div class="caution-study-status"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="school-check">
                            <label for="school-check">Cheque escolar</label>
                            <input type="text" placeholder="XXDPRXXXXD" name="school-check" id="school-check" value="<?php if (isset($_POST['school-check'])) {
                                                                                                                            echo $_POST['school-check'];
                                                                                                                        } ?>">
                            <?php
                            if (isset($caution_school_check)) {
                                foreach ($caution_school_check as $c) {
                                    echo '<div class="caution-school-check"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="register-secretary">
                            <label for="register-secretary">Registro secretaria</label>
                            <input type="date" name="register-secretary" id="register-secretary" value="<?php if (isset($_POST['register-secretary'])) {
                                                                                                            echo $_POST['register-secretary'];
                                                                                                        } ?>">
                            <?php
                            if (isset($caution_register_secretary)) {
                                foreach ($caution_register_secretary as $c) {
                                    echo '<div class="caution-register-secretary"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="register-zone">
                            <label for="register-zone">Registro zona</label>
                            <input type="date" name="register-zone" id="register-zone" value="<?php if (isset($_POST['register-zone'])) {
                                                                                                    echo $_POST['register-zone'];
                                                                                                } ?>">
                            <?php
                            if (isset($caution_register_zone)) {
                                foreach ($caution_register_zone as $c) {
                                    echo '<div class="caution-register-zone"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="register-school">
                            <label for="register-school">Registro escuela</label>
                            <input type="date" name="register-school" id="register-school" value="<?php if (isset($_POST['register-school'])) {
                                                                                                        echo $_POST['register-school'];
                                                                                                    } ?>">
                            <?php
                            if (isset($caution_register_school)) {
                                foreach ($caution_register_school as $c) {
                                    echo '<div class="caution-register-school"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="communication">
                        <h3>Comunicación</h3>
                        <div class="email">
                            <label for="email">Correo electrónico</label>
                            <input type="text" placeholder="mail@gmail.com" name="email" id="email" value="<?php if (isset($_POST['email'])) {
                                                                                                                echo $_POST['email'];
                                                                                                            } ?>">
                            <?php
                            if (isset($caution_email)) {
                                foreach ($caution_email as $c) {
                                    echo '<div class="caution-email"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>

                        <div class="cellphone">
                            <label for="cellphone">Celular</label>
                            <input type="text" placeholder="961XXXXXXX" name="cellphone" id="cellphone" value="<?php if (isset($_POST['cellphone'])) {
                                                                                                                    echo $_POST['cellphone'];
                                                                                                                } ?>">
                            <?php
                            if (isset($caution_cellphone)) {
                                foreach ($caution_cellphone as $c) {
                                    echo '<div class="caution-cellphone"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <a href="personal.php"><i class="fa-solid fa-arrow-left"></i></a>
                <button type="submit" name="add-personal" id="add-personal">Agregar personal</button>
            </form>
        </section>
        <script src="../scripts/personal-warning.js"></script>
        <script src="../scripts/open-grid-and-profile.js"></script>
        <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} 
?>