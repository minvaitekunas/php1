<?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "php202105";
    $update = false;

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    if(isset($_GET['action']) and $_GET['action'] == 'delete'){
        $sql = 'DELETE FROM Projects WHERE id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $res = $stmt->execute();

        $stmt->close();
        mysqli_close($conn);

        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        die();
        
    }
    if(isset($_GET['action']) and $_GET['action'] == 'update'){
        $sql = 'UPDATE Projects WHERE id = ?';
        $id= $_GET['id'];
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $res = $stmt->execute();

        $stmt->close();
        mysqli_close($conn);

        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        die();
        
    }
    if(isset($_POST['create_empl'])){
        $stmt = $conn->prepare("INSERT INTO Projects (Name) VALUES (?)");
        $stmt->bind_param('s',$name);
        $name = $_POST['fname'];
        $surname = $_POST['lname'];
        $stmt->execute();
        $stmt->close();
        header('Location: ' . $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        die;
    }

	
	
    $sql = "SELECT * FROM Projects";
    $result = $conn->query($sql);

    
    


?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>
<header>
    <div></div>
        <a href="index.php" <button>Employees</button></a>
        <a href="projects.php" <button>Projects</button></a>
    </div>
 </header>

<body>
<div class="table-responsive">
        <table class="table">
    <?php
        $sql = 'SELECT * FROM Projects';
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            print('<div class="table-responsive');
            print('<table class="table">');
            print('<thead>');
            print('<tr><th>Id</th><th>Name</th><th>Employee</th><th>Actions</th></tr>');
            print('</thead>');
            print('<tbody>');
            while($row = mysqli_fetch_assoc($result)) {
                print('<tr>' 
                    . '<td>' . $row['id'] . '</td>' 
                    . '<td>' . $row['name'] . '</td>' 
                    . '<td>' . $row['employees'] . '</td>'
                    . '<td>' . '<a href="?action=delete&id='  . $row['id'] . '"><button>DELETE</button></a>'
                             . '<a href="?action=update&id='  . $row['id'] . '"><button>UPDATE</button></a>' . '</td>'
                    . '</tr>');
            }
            print('</tbody>');
            print('</table>');
            print('</div>');
        } else {
            echo '0 results';
        }
        mysqli_close($conn);
    ?>
         <br>
        <form action="" method="POST">
            <div>
            <label for="fname">Project:</label><br>
            <input type="text" id="fname" name="fname" value="Project title"><br>
            <input type="submit" name="create_empl" value="Submit">
        </form>
        <br>
      
</body>
</html>
