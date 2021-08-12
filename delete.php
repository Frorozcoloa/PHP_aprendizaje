<?php 
    require_once "PDO.php";
    session_start();
    if( isset($_POST['delete']) && isset($_POST['auto_id']) ){
        $sql = "DELETE FROM autos WHERE auto_id = :zip";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':zip' => $_POST['auto_id']));
        $_SESSION['success'] = 'Record deleted';
        header('Location:index.php');
        return;
    }

    $smt = $pdo->prepare("SELECT  auto_id, make FROM autos where auto_id = :xyz");
    $smt->execute(array(":xyz" => $_GET['auto_id']));
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
    <meta charset="UTF-8">
    <title>Fredy Orozco (2aad4937)'s Delet</title>
</head>
<body>
    <p>Confirm: Deleting <?php echo htmlentities($row['make']) ?></p>
    <form method="post">
    <input type="hidden" name="auto_id" value="<?php echo $row['auto_id']?>">
    <input type="submit" name="delete" value="Delete" />
    <a href="index.php">Cancel</a>
    </form>
</body>
</html>
