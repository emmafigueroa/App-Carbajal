<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();


/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['id-teacher'])) {
    unset($_SESSION['id-teacher']);
}

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
            <?php
            $query_teacher = $mysqli->query("SELECT*FROM docente");
            if (isset($query_teacher)) {
                $row_teacher = $query_teacher->num_rows;
                if ($row_teacher == 0) {
            ?>
                    <h2>Asignar docente</h2>
                <?php
                } else {
                ?>
                    <h2>Docente</h2>
            <?php
                }
            }
            ?>
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

        if (isset($query_teacher)) {
            $row_teacher = $query_teacher->num_rows;
            if ($row_teacher == 0) {
        ?>
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
                                        $query_show_only_teachers = $mysqli->query("SELECT*FROM personal WHERE funcion = 'Docente'");
                                        if (isset($query_show_only_teachers)) {
                                            while ($fetch_show_only_teachers = $query_show_only_teachers->fetch_assoc()) {
                                        ?>
                                                <option value="<?php echo $fetch_show_only_teachers['id_personal']; ?>"><?php echo $fetch_show_only_teachers['nombre_completo']; ?></option>
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
                        <a href="personal.php"><i class="fa-solid fa-arrow-left"></i></a>
                        <button type="submit" name="add-teacher">Asignar docente</button>
                    </form>
                </section>
            <?php
            } else {
                if (isset($_POST['delete-teacher'])) {

                    /* Comprobando si el id-teacher está configurado y si no está vacío. Si no está vacío, está
configurando el id-teacher para la sesión. */
                    if (isset($_POST['id-teacher'])) {
                        if (!empty($_POST['id-teacher'])) {
                            $_SESSION['id-teacher'] = $_POST['id-teacher'];
                        }
                    }

                    /* Comprobando si la variable de sesión 'id-teacher' está configurada. Si lo es, está asignando el
valor de la variable de sesión a la variable . */
                    if (isset($_SESSION['id-teacher'])) {
                        $id_teacher = $_SESSION['id-teacher'];
                    }

                    $query_delete_teacher = $mysqli->query("DELETE FROM docente WHERE id_docente ='$id_teacher'");
                    if (isset($query_delete_teacher)) {
                        header('Location: teacher.php');
                    }
                }

                if (isset($_POST['search-teacher'])) {
                    $search_teacher = $mysqli->real_escape_string($_POST['search-teacher']);


                    if ($search_teacher == null) {
                        $query_search_teacher = $mysqli->query("SELECT*FROM docente ORDER BY grado");
                    } else {
                        if ($search_teacher == "1" || $search_teacher == "2" || $search_teacher == "3" || $search_teacher == "4"  || $search_teacher == "5" || $search_teacher == "6") {
                            $query_search_teacher = $mysqli->query("SELECT*FROM docente WHERE grado LIKE '%$search_teacher%' ORDER BY grupo");
                        } else if ($search_teacher == "A" || $search_teacher == "a" || $search_teacher == "B" || $search_teacher == "b") {
                            $query_search_teacher = $mysqli->query("SELECT*FROM docente WHERE grupo LIKE '%$search_teacher%' ORDER BY grupo");
                        } else {
                            $query_id_personal = $mysqli->query("SELECT*FROM personal WHERE nombre_completo LIKE '%$search_teacher%'");
                            if(isset($query_id_personal)){
                                $fetch_id_personal = $query_id_personal->fetch_assoc();
                                $id_personal = $fetch_id_personal['id_personal'];

                                $query_search_teacher = $mysqli->query("SELECT*FROM docente WHERE id_personal ='$id_personal'");
                            }
                            
                        }
                    }
                } else {
                    $query_search_teacher = $mysqli->query("SELECT*FROM docente ORDER BY grado");
                }
            ?>
                <section class="show-teacher">
                    <form action="" method="post">
                        <input type="search" placeholder="Buscar" name="search-teacher">
                        <a href="add-teacher.php" class="add"><i class='bx bxs-plus-circle'></i></a>
                        <a href="personal.php" class="assign"><i class="bx bxs-user"></i>Personal</a>
                    </form>

                    <table>
                        <tr class="thead">
                            <th>Nombre completo</th>
                            <th>Grado</th>
                            <th>Grupo</th>
                            <th>Numero de alumnos</th>
                            <th></th>
                        </tr>
                        <?php
                        while ($fetch_teacher = $query_search_teacher->fetch_assoc()) {
                            $id_personal = $fetch_teacher['id_personal'];
                            $query_name_personal = $mysqli->query("SELECT*FROM personal WHERE id_personal ='$id_personal'");
                            if (isset($query_name_personal)) {
                                $fetch_name_personal  = $query_name_personal->fetch_assoc();
                            }
                        ?>
                            <tr>
                                <td><?php echo $fetch_name_personal['nombre_completo']; ?></td>
                                <td><?php echo $fetch_teacher['grado']; ?></td>
                                <td><?php echo $fetch_teacher['grupo']; ?></td>
                                <td>
                                    <?php 
                                    if(isset($fetch_teacher['numero_alumnos'])){
                                        $id_teacher = $fetch_teacher['id_docente'];
                                        $grade = $fetch_teacher['grado'];
                                        $group = $fetch_teacher['grupo'];
                                        $number_students = $fetch_teacher['numero_alumnos'];
                                        $query_count_student = $mysqli->query("SELECT*FROM alumno WHERE grado ='$grade' and grupo ='$group'");
                                        if(isset($query_count_student)){
                                            $row_count_student = $query_count_student->num_rows;
                                            $query_edit_student = $mysqli->query("UPDATE docente SET numero_alumnos ='$row_count_student' WHERE id_docente ='$id_teacher'");
                                        }

                                        echo $number_students;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="actions two">
                                        <form action="edit-teacher.php" method="post">
                                            <input type="hidden" name="id-teacher" value="<?php echo $fetch_teacher['id_docente']; ?>">
                                            <button type="submit" name="edit-teacher"><i class='bx bxs-pencil'></i></button>
                                        </form>
                                        <form action="" method="post">
                                            <input type="hidden" name="id-teacher" value="<?php echo $fetch_teacher['id_docente']; ?>">
                                            <button type="submit" name="delete-teacher"><i class='bx bxs-trash'></i></button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        <?php } ?>
                    </table>
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