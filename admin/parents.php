<?php include "includes/header.php"; ?>

<?php 

                    
                    if(isset($_GET ['source'])) {

                        $source = $_GET ['source'];
                    } else {
                        $source = ' ';
                    }

                    switch($source) {

                        case 'add_parent';
                        include "includes/add_parent.php";
                        break;

                        case 'edit_parent';
                        include "includes/edit_parent.php";
                        break;

                        default:
                        include "includes/all_parents.php";
                        break;
                    }
                    
                    ?>
<?php include "includes/footer.php" ?>