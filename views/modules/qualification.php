<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['id-student'])) {
    unset($_SESSION['id-student']);
}

if(isset($_SESSION['id-qualification'])){
    unset($_SESSION['id-qualification']);
}

if (isset($_SESSION['user-is'])) {
    if (isset($_POST['delete-qualification'])) {

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
        $query_delete_qualification = $mysqli->query("DELETE FROM calificacion WHERE id_calificacion ='$id_qualification'");
        
        if (isset($query_delete_qualification)) {
           
            $query_qualification = $mysqli->query("SELECT*FROM calificacion");
            if(isset($query_qualification)){
                $row_qualification = $query_qualification->num_rows;
    
                if($row_qualification == 0){
                    header('Location: student.php');
                }else{
                    header('Location: qualification.php');
                }
            } 
        }
    }

    if (isset($_POST['search-qualification'])) {
        $search_qualification = $mysqli->real_escape_string($_POST['search-qualification']);


        if ($search_qualification == null) {
            $query_search_qualification = $mysqli->query("SELECT*FROM calificacion ORDER BY id_alumno");
        } else {
            if ($search_qualification == "1" || $search_qualification == "2" || $search_qualification == "3" || $search_qualification == "4" || $search_qualification == "5" || $search_qualification == "6") {
                $query_search_qualification = $mysqli->query("SELECT*FROM calificacion WHERE grado LIKE '%$search_qualification%' ORDER BY id_alumno");
            } else if ($search_qualification == "A" || $search_qualification == "a" || $search_qualification == "B" || $search_qualification == "b") {
                $query_search_qualification = $mysqli->query("SELECT*FROM calificacion WHERE grupo LIKE '%$search_qualification%' ORDER BY id_alumno");
            } else {
                $query_name_student = $mysqli->query("SELECT*FROM alumno WHERE nombre_completo LIKE '%$search_qualification%'");

                if (isset($query_name_student)) {
                    $fetch_name_student = $query_name_student->fetch_assoc();
                    if(isset($fetch_name_student['id_alumno'])){
                        $id_student = $fetch_name_student['id_alumno'];
                        $query_search_qualification = $mysqli->query("SELECT*FROM calificacion WHERE id_alumno ='$id_student' ORDER BY id_alumno");
                    }else{
                        $query_search_qualification = $mysqli->query("SELECT*FROM calificacion ORDER BY id_materia");
                    }
                }

            }
        }
    } else {
        $query_search_qualification = $mysqli->query("SELECT*FROM calificacion ORDER BY id_alumno");
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
            <h2>Calificación</h2>
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
        <section class="show-student">
            <form action="" method="post">
                <input type="search" placeholder="Buscar" name="search-qualification">
                <a href="student.php" class="add"><i class='fa-solid fa-arrow-left'></i></a>
            </form>

            <table>
                <tr class="thead">
                    <th>Alumno</th>
                    <th>Grado</th>
                    <th>Grupo</th>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Primer parcial</th>
                    <th>Segundo parcial</th>
                    <th>Tercer parcial</th>
                    <th>Promedio</th>
                    <th>Descripción</th>
                    <th></th>
                </tr>
                <?php
                while ($fetch_show_qualification = $query_search_qualification->fetch_assoc()) {
                    $id_student = $fetch_show_qualification['id_alumno'];
                    $id_matter = $fetch_show_qualification['id_materia'];

                    $query_name_student = $mysqli->query("SELECT*FROM alumno WHERE id_alumno ='$id_student'");
                    if (isset($query_name_student)) {
                        $fetch_name_student = $query_name_student->fetch_assoc();
                        $grade = $fetch_name_student['grado'];
                        $group = $fetch_name_student['grupo'];

                        $query_id_teacher = $mysqli->query("SELECT*FROM docente WHERE grado ='$grade' and grupo ='$group'");
                        if (isset($query_id_teacher)) {
                            $fetch_id_teacher = $query_id_teacher->fetch_assoc();

                            $id_personal = $fetch_id_teacher['id_personal'];

                            $query_name_personal = $mysqli->query("SELECT*FROM personal WHERE id_personal ='$id_personal'");
                            if (isset($query_name_personal)) {
                                $fetch_name_personal = $query_name_personal->fetch_assoc();
                            }
                        }
                    }

                    $query_name_matter = $mysqli->query("SELECT*FROM materia WHERE id_materia ='$id_matter'");
                    if (isset($query_name_matter)) {
                        $fetch_name_matter = $query_name_matter->fetch_assoc();
                    }
                ?>
                    <tr>
                        <td><?php if(isset($fetch_name_student['nombre_completo'])) echo $fetch_name_student['nombre_completo'];?></td>
                        <td><?php if(isset($fetch_show_qualification['grado'])) echo $fetch_show_qualification['grado']; ?></td>
                        <td><?php if(isset($fetch_show_qualification['grupo'])) echo $fetch_show_qualification['grupo']; ?></td>
                        <td><?php if(isset($fetch_name_matter['nombre'])) echo $fetch_name_matter['nombre']; ?></td>
                        <td><?php if(isset($fetch_name_personal['nombre_completo'])) echo $fetch_name_personal['nombre_completo']; ?></td>
                        <td><?php if(isset($fetch_show_qualification['primer_parcial'])) echo $fetch_show_qualification['primer_parcial']; ?></td>
                        <td><?php if(isset($fetch_show_qualification['segundo_parcial'])) echo $fetch_show_qualification['segundo_parcial']; ?></td>
                        <td><?php if(isset($fetch_show_qualification['tercer_parcial'])) echo $fetch_show_qualification['tercer_parcial']; ?></td>
                        <td><?php if(isset($fetch_show_qualification['promedio'])) echo $fetch_show_qualification['promedio']; ?></td>
                        <td><?php if(isset($fetch_show_qualification['descripcion'])) echo $fetch_show_qualification['descripcion']; ?></td>
                        <td>
                            <div class="actions two">
                                <form action="edit-qualification.php" method="post">
                                    <input type="hidden" name="id-qualification" value="<?php echo $fetch_show_qualification['id_calificacion']; ?>">
                                    <button type="submit" name="edit-qualification"><i class='bx bxs-pencil'></i></button>
                                </form>
                                <form action="" method="post">
                                    <input type="hidden" name="id-qualification" value="<?php echo $fetch_show_qualification['id_calificacion']; ?>">
                                    <button type="submit" name="delete-qualification"><i class='bx bxs-trash'></i></button>
                                </form>
                            </div>
                        </td>

                    </tr>
                <?php } ?>
            </table>
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