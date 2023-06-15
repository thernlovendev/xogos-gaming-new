<?php include "includes/header.php"; ?>

<?php 

                    
                    if(isset($_GET ['source'])) {

                        $source = $_GET ['source'];
                    } else {
                        $source = ' ';
                    }

                    switch($source) {

                        case 'add_class';
                        include "includes/add_class.php";
                        break;

                        case 'edit_class';
                        include "includes/edit_class.php";
                        break;

                        case 'class_students';
                        include "includes/class_students.php";
                        break;

                        default:
                        include "includes/all_my_classes.php";
                        break;
                    }
                    
                    ?>
<?php include "includes/footer.php" ?>