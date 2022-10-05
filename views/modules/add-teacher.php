<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['user-is'])) {
    if (isset($_POST['add-teacher'])) {
        $id_personal = $mysqli->real_escape_string($_POST['id-personal']);
        $grade = $mysqli->real_escape_string($_POST['grade']);
        $group = $mysqli->real_escape_string($_POST['group']);

        if (isset($id_personal, $grade, $group)) {
            if ($id_personal == "") {
                $caution_id_personal[] = "Personal olvidado.";
            }
            if ($grade == "") {
                $caution_grade[] = "Grado olvidado.";
            }
            if ($group == "") {
                $caution_group[] = "Grupo olvidado.";
            }

            if ($id_personal != "" && $grade != "" && $group != "") {
                $query_add_teacher = $mysqli->query("INSERT INTO docente(id_personal,grado,grupo) VALUES('$id_personal','$grade','$group')");

                if (isset($query_add_teacher)) {
                    header("Location: teacher.php");
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

        <title>Docente - Carbajal</title>

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>

        <header>
            <div class="logotype">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h2>Asignar docente</h2>
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
        <section class="add-teacher">
            <form action="" method="post">
                <div class="input-teacher">
                    <div class="classroom">
                        <h3>Salón de clases</h3>
                        <div class="id-personal">
                            <label for="id-personal">Nombre del personal</label>
                            <select name="id-personal">
                                <option value="<?php if (isset($_POST['id-personal'])) {
                                                    echo $_POST['id-personal'];
                                                } ?>"><?php
                                                        if (isset($_POST['id-personal'])) {
                                                            if ($_POST['id-personal'] != "") {
                                                                $id_personal = $_POST['id-personal'];
                                                                $query_name_personal = $mysqli->query("SELECT*FROM personal WHERE id_personal ='$id_personal'");
                                                                if (isset($query_name_personal)) {
                                                                    $fetch_name_personal = $query_name_personal->fetch_assoc();

                                                                    echo $fetch_name_personal['nombre_completo'];
                                                                }
                                                            }

                                                            if ($_POST['id-personal'] == "") {
                                                                echo "Seleccione un personal";
                                                            }
                                                        } else {
                                                            echo "Seleccione un personal";
                                                        }
                                                        ?></option>
                                <?php
                                $query_show_personal = $mysqli->query("SELECT*FROM personal WHERE funcion = 'Docente'");
                                if (isset($query_show_personal)) {
                                    while ($fetch_personal = $query_show_personal->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $fetch_personal['id_personal']; ?>"><?php echo $fetch_personal['nombre_completo']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                            <?php
                            if (isset($caution_id_personal)) {
                                foreach ($caution_id_personal as $c) {
                                    echo '<div class="caution-id-personal"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
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
                <a href="teacher.php"><i class="fa-solid fa-arrow-left"></i></a>
                <button type="submit" name="add-teacher">Asignar docente</button>
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