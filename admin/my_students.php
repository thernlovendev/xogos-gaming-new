<?php include "includes/header.php"; ?>

<?php 

                    
                    if(isset($_GET ['source'])) {

                        $source = $_GET ['source'];
                    } else {
                        $source = ' ';
                    }

                    switch($source) {

                        case 'add_student';
                        include "includes/add_student.php";
                        break;

                        case 'edit_kid';
                        include "includes/edit_student.php";
                        break;

                        default:
                        include "includes/all_my_students.php";
                        break;
                    }
                    
                    ?>
<?php include "includes/footer.php" ?>