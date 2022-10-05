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
            <h2>Editar calificación</h2>
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
        if (isset($_POST['id-qualification'])) {
            if (!empty($_POST['id-qualification'])) {
                $_SESSION['id-qualification'] = $_POST['id-qualification'];
            }
        }

        /* Comprobando si la variable de sesión 'id-qualification' está configurada. Si lo es, está asignando el
valor de la variable de sesión a la variable . */
        if (isset($_SESSION['id-qualification'])) {
            $id_qualification = $_SESSION['id-qualification'];
        }

        if (isset($_POST['update-qualification'])) {
            if (isset($_POST['id-matter'], $_POST['first-partial'], $_POST['second-partial'], $_POST['third-partial'])) {
                $id_matter = $mysqli->real_escape_string($_POST['id-matter']);
                $first_partial = $mysqli->real_escape_string($_POST['first-partial']);
                $second_partial = $mysqli->real_escape_string($_POST['second-partial']);
                $third_partial = $mysqli->real_escape_string($_POST['third-partial']);

                if(($first_partial >= "1" && ($second_partial == "0") && ($third_partial == "0"))) {
                    $average = $first_partial;
                    $average = round($average / 1);
                }
                
                if(($first_partial >= "1" && ($second_partial >= "1") && ($third_partial == "0"))){
                    $average = $first_partial + $second_partial;
                    $average = round($average / 2);
                }

                if(($first_partial >= "1" && ($second_partial >= "1") && ($third_partial >= "1"))){
                    $average = $first_partial + $second_partial + $third_partial;
                    $average = round($average / 3);
                }

                if ($average == "0") {
                    $description = "Cero";
                }
                if ($average == "1") {
                    $description = "Uno";
                }
                if ($average == "2") {
                    $description = "Dos";
                }
                if ($average == "3") {
                    $description = "Tres";
                }
                if ($average == "4") {
                    $description = "Cuatro";
                }
                if ($average == "5") {
                    $description = "Cinco";
                }
                if ($average == "6") {
                    $description = "Seis";
                }
                if ($average == "7") {
                    $description = "Siete";
                }
                if ($average == "8") {
                    $description = "Ocho";
                }
                if ($average == "9") {
                    $description = "Nueve";
                }
                if ($average == "10") {
                    $description = "Diez";
                }

                $query_edit_qualification = $mysqli->query("UPDATE calificacion SET id_materia ='$id_matter', primer_parcial ='$first_partial', segundo_parcial ='$second_partial', tercer_parcial ='$third_partial', promedio ='$average', descripcion ='$description' WHERE id_calificacion ='$id_qualification'");
                if (isset($query_edit_qualification)) {
                    header('Location: qualification.php');
                }
            }
        }

        $query_show_qualification = $mysqli->query("SELECT*FROM calificacion WHERE id_calificacion = '$id_qualification'");
        if (isset($query_show_qualification)) {
            $row_show_qualification = $query_show_qualification->num_rows;
            if ($row_show_qualification == 1) {
                $fetch_show_qualification = $query_show_qualification->fetch_assoc();

                $id_student = $fetch_show_qualification['id_alumno'];
                $query_name_student = $mysqli->query("SELECT*FROM alumno WHERE id_alumno ='$id_student'");
                if (isset($query_name_student)) {
                    $fetch_name_student = $query_name_student->fetch_assoc();

                    $grade = $fetch_name_student['grado'];
                }

                $id_matter = $fetch_show_qualification['id_materia'];

                $query_name_matter = $mysqli->query("SELECT*FROM materia WHERE id_materia ='$id_matter'");
                if (isset($query_name_matter)) {
                    $fetch_name_matter = $query_name_matter->fetch_assoc();
                }
        ?>
                <section class="edit-qualification">
                    <form action="" method="post">
                        <div class="input-qualification">
                            <div class="general-information">
                                <h3>Datos generales</h3>
                                <div class="student">
                                    <label for="student">Alumno</label>
                                    <input type="text" name="student" disabled value="<?php echo $fetch_name_student['nombre_completo']; ?>">
                                </div>
                                <div class="grade">
                                    <label for="grade">Grado</label>
                                    <input type="text" name="grade" disabled value="<?php echo $fetch_name_student['grado']; ?>">
                                </div>
                                <div class="group">
                                    <label for="group">Grupo</label>
                                    <input type="text" name="group" disabled value="<?php echo $fetch_name_student['grupo']; ?>">
                                </div>
                                <div class="id-matter">
                                    <label for="id-matter">Materia</label>
                                    <select name="id-matter">
                                        <option value="<?php
                                                        echo $fetch_name_matter['id_materia'];
                                                        ?>">
                                            <?php
                                            echo $fetch_name_matter['nombre'];
                                            ?>
                                        </option>
                                        <?php
                                        $query_show_matter = $mysqli->query("SELECT*FROM materia WHERE grado ='$grade'");

                                        if (isset($query_show_matter)) {
                                            while ($fetch_show_matter = $query_show_matter->fetch_assoc()) {
                                        ?>
                                                <option value="<?php echo $fetch_show_matter['id_materia']; ?>"><?php echo $fetch_show_matter['nombre']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if (isset($caution_id_matter)) {
                                        foreach ($caution_id_matter as $c) {
                                            echo '<div class="caution-id-matter"><p>' . $c . '</p></div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="partials">
                                <h3>Parciales</h3>
                                <div class="first-partial">
                                    <label for="first-partial">Primer</label>
                                    <input type="text" name="first-partial" value="<?php if (isset($fetch_show_qualification['primer_parcial'])) {
                                                                                        echo $fetch_show_qualification['primer_parcial'];
                                                                                    }  ?>">
                                    <?php
                                    if (isset($caution_first_partial)) {
                                        foreach ($caution_first_partial as $c) {
                                            echo '<div class="caution-first-partial"><p>' . $c . '</p></div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="second-partial">
                                    <label for="second-partial">Segundo</label>
                                    <input type="text" placeholder="0" name="second-partial" value="<?php if (isset($fetch_show_qualification['segundo_parcial'])) {
                                                                                        echo $fetch_show_qualification['segundo_parcial'];
                                                                                    }  ?>">
                                    <?php
                                    if (isset($caution_second_partial)) {
                                        foreach ($caution_second_partial as $c) {
                                            echo '<div class="caution-second-partial"><p>' . $c . '</p></div>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="third-partial">
                                    <label for="third-partial">Tercer</label>
                                    <input type="text" placeholder="0" name="third-partial" value="<?php if (isset($fetch_show_qualification['tercer_parcial'])) {
                                                                                        echo $fetch_show_qualification['tercer_parcial'];
                                                                                    }  ?>">
                                    <?php
                                    if (isset($caution_third_partial)) {
                                        foreach ($caution_third_partial as $c) {
                                            echo '<div class="caution-third-partial"><p>' . $c . '</p></div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <a href="qualification.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <button type="submit" name="update-qualification">Editar calificación</button>
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