<?php
require_once "inc/functions.php";
$info = "";
$task = $_GET['task'] ?? 'report';
$error = $_GET['error'] ?? '0';

if ('delete' == $task) {

    // $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $id = htmlspecialchars($_GET['id']);
    if ($id > 0) {
        deleteStudent($id);
        header('location: /php_crud/index.php?task=report');
    }
}

if ('seed' == $task) {
    seed();
    $info = "Seeding is completed";
}

$fname = '';
$lname = '';
$roll  = '';


if (isset($_POST['submit'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $roll = htmlspecialchars($_POST['roll']);
    $id = $_POST['id'];


    if ($id) {
        //update the existing student
        if ($fname != '' && $lname != '' && $roll != '') {
            $result = updateStudent($id, $fname, $lname, $roll);
            if ($result) {
                header('location: /php_crud/index.php?task=report');
            } else {
                $error = 1;
            }
        }
    } else {
        //add a new student
        if ($fname != '' && $lname != '' && $roll != '') {
            $result = addStudent($fname, $lname, $roll);
            if ($result) {
                header('location: /php_crud/index.php?task=report');
            } else {
                $error = 1;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <title>My Crud</title>
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20">
                <h2>MY Simple CRUD Project</h2>
                <p>A sample project to perform CRUD operations using plain files and PHP</p>
                <?php include_once "./inc/templates/nav.php"; ?>
                <hr />
                <?php
                if ($info != "") {
                    echo "<p>{$info}</p>";
                }

                ?>
            </div>
        </div>

        <?php if ('1' == $error) : ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <blockquote>
                        Duplicate Roll Number
                    </blockquote>
                </div>
            </div>
        <?php endif; ?>

        <?php if ('report' == $task) : ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <?php generateReport(); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ('add' == $task) : ?>
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <form action="/php_crud/index.php?task=add" method="POST">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" id="fname" value="<?= $fname; ?>">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname" value="<?= $lname; ?>">
                        <label for="roll">Roll</label>
                        <input type="number" name="roll" id="roll" value="<?= $roll; ?>">
                        <button type="submit" class="button-primary" name="submit">Save</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ('edit' == $task) :
            // $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
            $id = htmlspecialchars($_GET['id']);
            $student = getStudent($id);
            if ($student) :
        ?>
                <div class="row">
                    <div class="column column-60 column-offset-20">
                        <form method="POST">
                            <input type="hidden" value="<?= $id ?>" name="id">
                            <label for="fname">First Name</label>
                            <input type="text" name="fname" id="fname" value="<?= $student['fname']; ?>">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" id="lname" value="<?= $student['lname']; ?>">
                            <label for="roll">Roll</label>
                            <input type="number" name="roll" id="roll" value="<?= $student['roll']; ?>">
                            <button type="submit" class="button-primary" name="submit">Update</button>
                        </form>
                    </div>
                </div>
        <?php
            endif;
        endif;
        ?>

    </div>




    
</body>

</html>