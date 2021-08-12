<?php 
    session_start();
    require_once  'PDO.php';

    if(!isset($_SESSION['name'])){
        die("Not Logged in");

    }
    
$stmt = $pdo->query("SELECT * FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Fredy Alberto Orozco Loaiza  Login Page</title>
    <?php  require_once 'bootrap.php'?>
</head>
<body>
    <div class="container">
        <h1> Tracking Autos for <?php echo($_SESSION['name'])?></h1>
        <?php 
        if ( isset($_SESSION['success']) ){
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
        ?>
        </form>
        <h2>Automobiles</h2>
        <ul>
            <?php 
                foreach($rows as $row){
                    echo'<li>';
                    echo htmlentities($row['make']).' '.$row['year'].' '.$row['mileage'];
                    echo '</li><br/>';
                }
            ?>
        </ul>
        <p><a href="add.php">Add New</a>|<a href="logout.php">logout</a></p>
        </div>
</body>
</html>