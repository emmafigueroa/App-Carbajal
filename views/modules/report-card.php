<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['id-student'])) {
    unset($_SESSION['id-student']);
}

if (isset($_SESSION['user-is'])) {
    if (isset($_POST['id-student'])) {
        if (!empty($_POST['id-student'])) {
            $_SESSION['id-student'] = $_POST['id-student'];
        }
    }

    if (isset($_SESSION['id-student'])) {
        $id_student = $_SESSION['id-student'];

        $query_name_school = $mysqli->query("SELECT*FROM escuela");
        if (isset($query_name_school)) {
            $fetch_name_school = $query_name_school->fetch_assoc();
        }

        $query_show_student = $mysqli->query("SELECT*FROM alumno WHERE id_alumno ='$id_student'");
        if (isset($query_show_student)) {
            $fetch_show_student = $query_show_student->fetch_assoc();

            if (isset($fetch_show_student['grado'])) $grade = $fetch_show_student['grado'];
            if (isset($fetch_show_student['grupo'])) $group = $fetch_show_student['grupo'];
        }

        $query_show_teacher = $mysqli->query("SELECT*FROM docente WHERE grado ='$grade' and grupo ='$group'");
        if (isset($query_show_teacher)) {
            $fetch_show_teacher = $query_show_teacher->fetch_assoc();

            if (isset($fetch_show_teacher['id_personal'])) {
                $id_personal = $fetch_show_teacher['id_personal'];

                $query_name_personal = $mysqli->query("SELECT*FROM personal WHERE id_personal ='$id_personal'");
                if (isset($query_name_personal)) {
                    $fetch_name_personal = $query_name_personal->fetch_assoc();
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
                <h2>Boleta</h2>
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
                    <a href="statistics.php"><i class="bx bxs-bar-chart-alt-2"></i>
                        <p>Estadisticas</p>
                    </a>
                    <a href="log-out.php" class="log-out"><i class='bx bxs-x-circle'></i>
                        <p>Cerrar sesión</p>
                    </a>
                </div>
            </section>

            <section class="show-report-card" id="show-report-card">
                <div class="data">
                    <div class="school">
                        <div class="name">
                            <label for="name">Escuela</label>
                            <span><?php echo $fetch_name_school['nombre']; ?></span>
                        </div>
                        <div class="director">
                            <label for="director">Director</label>
                            <span><?php echo $fetch_name_school['director']; ?></span>
                        </div>
                        <div class="period">
                            <label for="period">Periodo</label>
                            <span><?php echo $fetch_name_school['periodo']; ?></span>
                        </div>
                    </div>

                    <div class="teacher">
                        <div class="personal">
                            <label for="personal">Docente</label>
                            <span><?php echo $fetch_name_personal['nombre_completo']; ?></span>
                        </div>
                    </div>

                    <div class="student">
                        <div class="full-name">
                            <label for="student">Alumno</label>
                            <span id="name"><?php echo $fetch_show_student['nombre_completo']; ?></span>
                        </div>
                        <div class="grade">
                            <label for="garde">Grado</label>
                            <span><?php echo $fetch_show_student['grado']; ?></span>
                        </div>
                        <div class="group">
                            <label for="group">Grupo</label>
                            <span><?php echo $fetch_show_student['grupo']; ?></span>
                        </div>
                    </div>
                </div>

                <table class="min-width">
                    <tr>
                        <th>Materia</th>
                        <th>1er Parcial</th>
                        <th>2do Parcial</th>
                        <th>3er Parcial</th>
                        <th>Promedio</th>
                        <th>Descripción</th>
                    </tr>

                    <?php

                    $query_show_qualification = $mysqli->query("SELECT*FROM calificacion WHERE id_alumno ='$id_student'");
                    if (isset($query_show_qualification)) {
                        while ($fetch_show_qualification = $query_show_qualification->fetch_assoc()) {
                            if (isset($fetch_show_qualification['id_materia'])) $id_matter = $fetch_show_qualification['id_materia'];

                            $query_name_matter = $mysqli->query("SELECT*FROM materia WHERE id_materia ='$id_matter'");
                            $query_first_partial = $mysqli->query("SELECT SUM(primer_parcial), COUNT(primer_parcial)FROM calificacion WHERE id_alumno ='$id_student'");
                            if (isset($query_first_partial)) {


                                $fetch_first_partial = $query_first_partial->fetch_assoc();
                                if (isset($fetch_first_partial['COUNT(primer_parcial)'])) $coun_first_partial = $fetch_first_partial['COUNT(primer_parcial)'];

                                if (isset($fetch_first_partial['SUM(primer_parcial)'])) {
                                    $first_partial = $fetch_first_partial['SUM(primer_parcial)'];

                                    $first_partial = $first_partial / $coun_first_partial;
                                }
                            }

                            $query_second_partial = $mysqli->query("SELECT SUM(segundo_parcial), COUNT(segundo_parcial)FROM calificacion WHERE id_alumno ='$id_student'");
                            if (isset($query_second_partial)) {


                                $fetch_second_partial = $query_second_partial->fetch_assoc();
                                if (isset($fetch_second_partial['COUNT(segundo_parcial)'])) $coun_second_partial = $fetch_second_partial['COUNT(segundo_parcial)'];

                                if (isset($fetch_second_partial['SUM(segundo_parcial)'])) {
                                    $second_partial = $fetch_second_partial['SUM(segundo_parcial)'];

                                    $second_partial = $second_partial / $coun_second_partial;
                                }
                            }

                            $query_third_partial = $mysqli->query("SELECT SUM(tercer_parcial), COUNT(tercer_parcial)FROM calificacion WHERE id_alumno ='$id_student'");
                            if (isset($query_third_partial)) {


                                $fetch_third_partial = $query_third_partial->fetch_assoc();
                                if (isset($fetch_third_partial['COUNT(tercer_parcial)'])) $coun_third_partial = $fetch_third_partial['COUNT(tercer_parcial)'];

                                if (isset($fetch_third_partial['SUM(tercer_parcial)'])) {
                                    $third_partial = $fetch_third_partial['SUM(tercer_parcial)'];

                                    $third_partial = $third_partial / $coun_third_partial;
                                }
                            }

                            $query_average = $mysqli->query("SELECT SUM(promedio), COUNT(promedio)FROM calificacion WHERE id_alumno ='$id_student'");
                            if (isset($query_average)) {


                                $fetch_average = $query_average->fetch_assoc();
                                if (isset($fetch_average['COUNT(promedio)'])) $coun_average = $fetch_average['COUNT(promedio)'];

                                if (isset($fetch_average['SUM(promedio)'])) {
                                    $average = $fetch_average['SUM(promedio)'];

                                    $average = $average / $coun_average;
                                }
                            }
                    ?>
                            <tr>

                                <?php
                                if (isset($query_name_matter)) {
                                    while ($fetch_name_matter = $query_name_matter->fetch_assoc()) {
                                ?>
                                        <td><?php echo $fetch_name_matter['nombre']; ?></td>
                                <?php
                                    }
                                }
                                ?>
                                <td><?php echo $fetch_show_qualification['primer_parcial']; ?></td>
                                <td><?php echo $fetch_show_qualification['segundo_parcial']; ?></td>
                                <td><?php echo $fetch_show_qualification['tercer_parcial']; ?></td>
                                <td><?php echo $fetch_show_qualification['promedio']; ?></td>
                                <td><?php echo $fetch_show_qualification['descripcion']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    <tr>
                        <th>Total</th>
                        <th><?php if (isset($first_partial)) echo round($first_partial); ?></th>
                        <th><?php if (isset($second_partial)) echo round($second_partial); ?></th>
                        <th><?php if (isset($third_partial)) echo round($third_partial); ?></th>
                        <th><?php if (isset($average)) echo round($average); ?></th>
                    </tr>
                </table>

                <div class="buttons">
                    <a href="student.php" class="return"><i class='fa-solid fa-arrow-left'></i></a>
                    <a href="#" class="print" id="btn_print"><i class='bx bxs-printer'></i></a>
                </div>

            </section>
            <script src="../scripts/print-report.js"></script>
            <script src="../scripts/open-grid-and-profile.js"></script>
            <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
            <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
        </body>

        </html>
<?php
    }
}
?>