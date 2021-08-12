<?php
session_start();
    if(!isset($_SESSION['name'])){
        die('Not logged in');
    }

    require_once "PDO.php";

    if(isset($_POST['make']) && isset($_POST['mileage']) && isset($_POST['year'])){
        if(strlen($_POST['make'])<1){
            $_SESSION['error'] = 'Make is required';
            header('Location:add.php');
            return;
        }
        elseif(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
            $_SESSION['error'] = 'Mileage and year must be numeric';
            header('location:add.php');
            return;
        }
        else{
            $stmt = $pdo->prepare('UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage,');
            $stmt->execute(array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'])
            );
            $_SESSION['success'] = 'Record updated';
            header('Location: index.php');
            return;
        }
    }

    $smt = $pdo->prepare('SELECT * FROM autos WHERE auto_id=:xyz');
    $smt->execute(array(":xyz"=> $_GET['auto_id']));
    $row = $smt->fetch(PDO::FETCH_ASSOC);
    if($row === false) {
        $_SESSION['error'] = 'Bad value for auto_id';
        header("Location:index.php");
        return;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "bootrap.php"; ?>
    <title>Fredy Orozco (2aad4937)</title>
    
</head>
<body>
    <div class="container">
        <h1>Tracking Autos for <?php echo $_SESSION['name']; ?></h1>
        <?php
            if (isset($_SESSION['error'])) {
                echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
                unset($_SESSION['error']);
            }
        ?>
        <form method="post">
        <p>Make:
            <input type="text" name="make" size="60" value="<?php echo htmlentities($row['make']) ?>"/></p>
        <p>Year:
            <input type="text" name="year" value="<?php echo htmlentities($row['year']) ?>"/></p>
        <p>Mileage:
            <input type="text" name="mileage" value="<?php echo htmlentities($row['mileage']) ?>"/></p>
        <input type="submit" value="Update">
        <a href="index.php">Cancel</a>
    </form>
    </div>
</body>
</html>