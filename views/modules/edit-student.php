<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['user-is'])) {
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

        <title>Alumno - Carbajal</title>

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>

        <header>
            <div class="logotype">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h2>Editar alumno</h2>
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
        <?php
        /* Comprobando si el id-personal está configurado y si no está vacío. Si no está vacío, está
configurando la sesión id-personal al valor de la publicación id-personal. */
        if (isset($_POST['id-student'])) {
            if (!empty($_POST['id-student'])) {
                $_SESSION['id-student'] = $_POST['id-student'];
            }
        }

        /* Comprobando si la variable de sesión 'id-student' está configurada. Si lo es, está asignando el
valor de la variable de sesión a la variable . */
        if (isset($_SESSION['id-student'])) {
            $id_student = $_SESSION['id-student'];
        }

        if (isset($_POST['update-student'])) {
            $full_name = $mysqli->real_escape_string($_POST['full-name']);
            $grade = $mysqli->real_escape_string($_POST['grade']);
            $group = $mysqli->real_escape_string($_POST['group']);
            $gender = $mysqli->real_escape_string($_POST['gender']);
            $birthday_date = $mysqli->real_escape_string($_POST['birthday-date']);

            if (isset($full_name, $group, $grade, $gender, $birthday_date)) {
                if (
                    empty($full_name) || empty($gender) || empty($group) || empty($grade) || empty($birthday_date)
                ) {
                    if (empty($full_name)) {
                        $caution_full_name[] = "Nombre completo olvidado";
                    }
                    if (empty($grade)) {
                        $caution_grade[] = "Grado olvidado";
                    }
                    if (empty($group)) {
                        $caution_group[] = "Grupo olvidado";
                    }
                    if (empty($gender)) {
                        $caution_gender[] = "Genero olvidado";
                    }
                    if (empty($birthday_date)) {
                        $caution_birthday_date[] = "Fecha de cumpleaños olvidada";
                    }
                } else {

                    $birth_date = new DateTime($birthday_date, new DateTimeZone('America/Mexico_City'));

                    $year_birth = $birth_date->format('y');
                    $month_birth = $birth_date->format('m');
                    $day_birth = $birth_date->format('d');

                    $current_date = new DateTime('2022-01-07');
                    $current_date = $current_date->setTimezone(new DateTimeZone('America/Mexico_City'));

                    $year_current = $current_date->format('y');
                    $hour_current = $current_date->format('H');
                    $minuts_current = $current_date->format('i');
                    $seconds_current = $current_date->format('s');

                    $start_date = $year_current . "-09-02";
                    $end_date = $year_current . "-12-31";

                    $start_date = new DateTime($start_date, new DateTimeZone('America/Mexico_City'));
                    $end_date =  new DateTime($end_date, new DateTimeZone('America/Mexico_City'));

                    $fullfilled_date = $year_current . "-" . $month_birth . "-" . $day_birth . " " . $hour_current . ":" . $minuts_current . ":" . $seconds_current;
                    $fullfilled_date = new DateTime($fullfilled_date, new DateTimeZone('America/Mexico_City'));

                    if (($fullfilled_date >= $start_date) && ($fullfilled_date <= $end_date)) {
                        $current_age = $birth_date->diff($fullfilled_date);
                    } else {
                        $current_age = $birth_date->diff($current_date);
                    }




                    $current_age = $current_age->format('%y%');

                    $query_edit_student = $mysqli->query("UPDATE alumno SET nombre_completo ='$full_name', grado ='$grade', grupo ='$group', genero ='$gender', fecha_nacimiento ='$birthday_date', edad ='$current_age' WHERE id_alumno ='$id_student'");
                    if (isset($query_edit_student)) {
                        header("Location: student.php");
                    }
                }
            }
        }

        $query_show_student = $mysqli->query("SELECT*FROM alumno WHERE id_alumno = '$id_student'");
        if (isset($query_show_student)) {
            $row_show_student = $query_show_student->num_rows;
            if ($row_show_student == 1) {
                $fetch_show_student = $query_show_student->fetch_assoc();
        ?>
                <section class="edit-student">
                    <form action="" method="post">
                        <div class="input-student">
                            <div class="personal-information">
                                <h3>Datos personales</h3>
                                <div class="full-name">
                                    <label for="full-name">Nombre completo</label>
                                    <input type="text" placeholder="Alberto Men" name="full-name" id="full-name" value="<?php if (isset($fetch_show_student['nombre_completo'])) {
                                                                                                                            echo $fetch_show_student['nombre_completo'];
                                                                                                                        } ?>">
                                </div>
                                <div class="gender">
                                    <label for="gender">Genero</label>
                                    <select name="gender">
                                        <option value="<?php echo $fetch_show_student['genero']; ?>">
                                            <?php
                                            if ($fetch_show_student['genero'] == "M") {
                                                echo "Masculino";
                                            }
                                            if ($fetch_show_student['genero'] == "F") {
                                                echo "Femenino";
                                            }
                                            ?>
                                        </option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                                <div class="birthday-date">
                                    <label for="birthday-date">Fecha de nacimiento</label>
                                    <input type="date" name="birthday-date" id="birthday-date" value="<?php echo $fetch_show_student['fecha_nacimiento'];  ?>">
                                </div>
                            </div>
                            <div class="classroom">
                                <h3>Salón de clases</h3>
                                <div class="grade">
                                    <label for="grade">Grado</label>
                                    <select name="grade">
                                        <option value="<?php echo $fetch_show_student['grado']; ?>">
                                            <?php
                                            if ($fetch_show_student['grado'] == "1") {
                                                echo "1ero";
                                            }
                                            if ($fetch_show_student['grado'] == "2") {
                                                echo "2do";
                                            }
                                            if ($fetch_show_student['grado'] == "3") {
                                                echo "3ero";
                                            }
                                            if ($fetch_show_student['grado'] == "4") {
                                                echo "4to";
                                            }
                                            if ($fetch_show_student['grado'] == "5") {
                                                echo "5to";
                                            }
                                            if ($fetch_show_student['grado'] == "6") {
                                                echo "6to";
                                            }
                                            ?>
                                        </option>
                                        <option value="1">1ero</option>
                                        <option value="2">2do</option>
                                        <option value="3">3ero</option>
                                        <option value="4">4to</option>
                                        <option value="5">5to</option>
                                        <option value="6">6to</option>

                                    </select>
                                </div>
                                <div class="group">
                                    <label for="group">Grupo</label>
                                    <select name="group">
                                        <option value="<?php echo $fetch_show_student['grupo']; ?>">
                                            <?php echo $fetch_show_student['grupo']; ?>
                                        </option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <a href="student.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <button type="submit" name="update-student">Editar alumno</button>
                    </form>
                </section>
        <?php
            }
        }
        ?>

        <script src="../scripts/personal-warning.js"></script>
        <script src="../scripts/open-grid-and-profile.js"></script>
        <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>