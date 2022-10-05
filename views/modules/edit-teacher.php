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
            <h2>Editar docente</h2>
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
/* Comprobando si el id-teacher está configurado y si no está vacío. Si no está vacío, está
configurando el id-teacher para la sesión. */
        if (isset($_POST['id-teacher'])) {
            if (!empty($_POST['id-teacher'])) {
                $_SESSION['id-teacher'] = $_POST['id-teacher'];
            }
        }

/* Al verificar si la sesión id-teacher está configurada y si lo está, está configurando la variable
 en la sesión id-teacher. */
        if (isset($_SESSION['id-teacher'])) {
            $id_teacher = $_SESSION['id-teacher'];
        }

        if (isset($_POST['update-teacher'])) {
            $id_personal = $mysqli->real_escape_string($_POST['id-personal']);
            $grade = $mysqli->real_escape_string($_POST['grade']);
            $group = $mysqli->real_escape_string($_POST['group']);

            if (isset($id_personal, $grade, $group)) {
                if ($id_personal != ""  || $grade != "" || $group != "") {
                    $query_edit_teacher = $mysqli->query("UPDATE docente SET id_personal ='$id_personal', grado ='$grade', grupo ='$group' WHERE id_docente ='$id_teacher'");

                    if (isset($query_edit_teacher)) {
                        header("Location: teacher.php");
                    }
                }
            }
        }


        $query_show_teacher = $mysqli->query("SELECT*FROM docente WHERE id_docente = '$id_teacher'");
        if (isset($query_show_teacher)) {
            $row_show_teacher = $query_show_teacher->num_rows;
            if ($row_show_teacher == 1) {
                $fetch_show_teacher = $query_show_teacher->fetch_assoc();
                
                if (isset($fetch_show_teacher['id_personal'])) {
                    $id_personal = $fetch_show_teacher['id_personal'];
                    if (isset($id_personal)) {
                        $query_name_personal = $mysqli->query("SELECT*FROM personal WHERE id_personal ='$id_personal'");
                        if (isset($query_name_personal)) {
                            $fetch_name_personal = $query_name_personal->fetch_assoc();
                        }
                    }
                }

        ?>
                <section class="edit-teacher">
                    <form action="" method="post">
                        <div class="input-teacher">
                            <div class="classroom">
                                <h3>Salón de clases</h3>
                                <div class="id-personal">
                                    <label for="id-personal">Nombre del personal</label>
                                    <select name="id-personal">
                                        <option value="<?php echo $fetch_show_teacher['id_personal']; ?>"><?php echo $fetch_name_personal['nombre_completo']; ?></option>
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
                                        <option value="<?php echo $fetch_show_teacher['grado']; ?>">
                                            <?php
                                            if ($fetch_show_teacher['grado'] == "1") {
                                                echo "1ero";
                                            }
                                            if($fetch_show_teacher['grado'] == "2"){
                                                echo "2do";
                                            }
                                            if($fetch_show_teacher['grado'] == "3"){
                                                echo "3ero";
                                            }
                                            if($fetch_show_teacher['grado'] == "4"){
                                                echo "4to";
                                            }
                                            if($fetch_show_teacher['grado'] == "5"){
                                                echo "5to";
                                            }
                                            if($fetch_show_teacher['grado'] == "6"){
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
                                        <option value="<?php echo $fetch_show_teacher['grupo']; ?>">
                                            <?php echo $fetch_show_teacher['grupo']; ?>
                                        </option>
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
                        <button type="submit" name="update-teacher">Editar docente</button>
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