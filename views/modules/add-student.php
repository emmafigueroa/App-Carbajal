<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['user-is'])) {
    if (isset($_POST['add-student'])) {
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

                $month_birth = $birth_date->format('m');
                $day_birth = $birth_date->format('d');

                $current_date = new DateTime();
                $current_date = $current_date->setTimezone(new DateTimeZone('America/Mexico_City'));

                $year_current = $current_date->format('y');

                $start_date = $year_current . "-09-02";
                $end_date = $year_current . "-12-31";

                $start_date = new DateTime($start_date, new DateTimeZone('America/Mexico_City'));
                $end_date =  new DateTime($end_date, new DateTimeZone('America/Mexico_City'));

                $fullfilled_date = $year_current . "-" . $month_birth . "-" . $day_birth;
                $fullfilled_date = new DateTime($fullfilled_date, new DateTimeZone('America/Mexico_City'));

                if (($fullfilled_date >= $start_date) && ($fullfilled_date <= $end_date)) {
                    $intervale = $start_date->diff($current_date);
                    $intervale = $intervale->days;
                    $intervale = $intervale + 1;
                    $intervale = "-" . $intervale . " days";

                    $current_date = $current_date->modify($intervale);

                    $current_age = $birth_date->diff($current_date);
                } else {
                    $current_age = $birth_date->diff($current_date);
                }

                $current_age = $current_age->format('%y%');

                $query_add_student = $mysqli->query("INSERT INTO alumno(nombre_completo, grado, grupo, genero, fecha_nacimiento, edad) VALUES('$full_name', '$grade', '$group', '$gender', '$birthday_date', '$current_age')");
                if (isset($query_add_student)) {
                    $get_id_student = $mysqli->insert_id;

                    $query_add_alta = $mysqli->query("INSERT INTO alta(id_alumno,genero,grado,grupo) VALUES('$get_id_student','$gender','$grade','$group')");
                    if (isset($query_add_alta)) {
                        header("Location: student.php");
                    }
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
            <h2>Registrar alumno</h2>
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
                <a href="teacher.php"><i class="bx bxs-user"></i>
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
        <section class="add-student">
            <form action="" method="post">
                <div class="input-student">
                    <div class="personal-information">
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
                        <div class="gender">
                            <label for="gender">Genero</label>
                            <select name="gender">
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
                        <div class="birthday-date">
                            <label for="birthday-date">Fecha de nacimiento</label>
                            <input type="date" placeholder="01/07/2015" name="birthday-date" id="birthday-date" value="<?php if (isset($_POST['birthday-date'])) {
                                                                                                                            echo $_POST['birthday-date'];
                                                                                                                        } ?>">
                            <?php
                            if (isset($caution_birthday_date)) {
                                foreach ($caution_birthday_date as $c) {
                                    echo '<div class="caution-birthday-date"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="classroom">
                        <h3>Salón de clases</h3>
                        <div class="grade">
                            <label for="grade">Grado</label>
                            <select name="grade">
                                <option value="<?php if (isset($_POST['grade'])) {
                                                    echo $_POST['grade'];
                                                } ?>">
                                    <?php
                                    if (isset($_POST['grade'])) {
                                        if ($_POST['grade'] == "1") {
                                            echo "1ero";
                                        }
                                        if ($_POST['grade'] == "2") {
                                            echo "2do";
                                        }
                                        if ($_POST['grade'] == "3") {
                                            echo "3ero";
                                        }
                                        if ($_POST['grade'] == "4") {
                                            echo "4to";
                                        }
                                        if ($_POST['grade'] == "5") {
                                            echo "5to";
                                        }
                                        if ($_POST['grade'] == "6") {
                                            echo "6to";
                                        }
                                        if ($_POST['grade'] == "") {
                                            echo "Seleccione un grado";
                                        }
                                    } else {
                                        echo "Seleccione un grado";
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

                            <?php
                            if (isset($caution_grade)) {
                                foreach ($caution_grade as $c) {
                                    echo '<div class="caution-grade"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="group">
                            <label for="group">Grupo</label>
                            <select name="group">
                                <option value="<?php if (isset($_POST['group'])) {
                                                    echo $_POST['group'];
                                                } ?>">
                                    <?php
                                    if (isset($_POST['group'])) {
                                        if ($_POST['group'] != "") {
                                            echo $_POST['group'];
                                        }

                                        if ($_POST['group'] == "") {
                                            echo "Seleccione un grupo";
                                        }
                                    } else {
                                        echo "Seleccione un grupo";
                                    }
                                    ?></option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                            </select>

                            <?php
                            if (isset($caution_group)) {
                                foreach ($caution_group as $c) {
                                    echo '<div class="caution-group"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <a href="student.php"><i class="fa-solid fa-arrow-left"></i></a>
                <button type="submit" name="add-student">Agregar alumno</button>
            </form>
        </section>

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