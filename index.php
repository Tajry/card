<?php
    session_start();
    $conn = mysqli_connect('localhost','root','','cart');

    if(!$conn){
        echo 'error'.mysqli_error($conn);
    }

    $result = mysqli_query($conn , "SELECT * FROM cartshoping");
   
    if(isset($_POST['addproduct'])){
       
       
        if(isset($_SESSION['cartshoping'])){
           
           
            $item_array_id = array_column($_SESSION['cartshoping'], "item_id");
            print_r($item_array_id);
            if(!in_array($_GET['id'],$item_array_id)){
                $count = count($_SESSION['cartshoping']);
                // echo $count;
                $item_array = array(
                    'item_id' => $_GET['id'],  
                    'item_name' => $_POST['hidden_name'],
                    'item_pice' => $_POST['hidden_pice'],
                    'item_num' => $_POST['num']
                    
                );
                $_SESSION['cartshoping'][$count] = $item_array;
            }else{
                echo "<script>alert('เพิ่มลงสินค้าแล้ว') </script>";
                echo "<script>window.location ='index.php' </script>";
            }
        }else{
            $item_array = array(
                'item_id' => $_GET['id'],  
                'item_name' => $_POST['hidden_name'],
                'item_pice' => $_POST['hidden_pice'],
                'item_num' => $_POST['num']
                
            );
            $_SESSION['cartshoping'][0] = $item_array;
        }
    }


    if(isset($_GET['arr_delete'])){
        $index =  $_GET['arr_delete'];
        unset($_SESSION['cartshoping'][$index]);
    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <style>
        h1{
            text-align:center;

        }
        .content{
            display: flex;
            justify-content:center;
            align-items:center;
            flex-wrap:wrap;
            
        }
        .content .card{
            margin:.5rem 1rem ;
        }
        table ,tr ,td {
            border:1px solid black;
        }

    </style>

    <h1>ระบบสินค้า</h1>

    <div class="content">

        <?php while($row = mysqli_fetch_array($result)) {?>
            <form action="?action=add&id=<?php echo $row['id']?>" method="post">
            <div class="card" style="width: 18rem;">
            <img src="<?php echo $row['images']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo  $row['nameproduct']?></h5>
                <p class="card-text"><?php echo $row['pice']?></p>
                <input type="hidden" name="hidden_name" value="<?php echo $row['nameproduct']?>">
                <input type="hidden" name="hidden_pice" value="<?php echo $row['pice']?>">
                <input type="number" name="num" min="1" value="1"> 
                <input type="submit" class="btn btn-primary my-2" name="addproduct" value="เพิ่มลงในตระกร้า">
            </div>
        </div>
            </form>
        <?php } ?>
        
    </div>
    
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>pice</th>
            <th>num</th>
            <th>all</th>
            <th>delete</th>
            
        </tr>
        <?php 
            $tatol = 0;

        if(isset($_SESSION['cartshoping'])) {?>

            <?php foreach($_SESSION['cartshoping'] as $key => $value) {?>
            <tr>
            
            <td><?php echo $value['item_id']?></td> 
            <td><?php echo $value['item_name']?></td>
            <td><?php echo $value['item_pice']?></td>
            <td><?php echo $value['item_num']?></td>
            <td><?php echo $value['item_num']*$value['item_pice']?></td>
            <td><form action="?arr_delete=<?php echo $key?>" method="post">
                <input type="submit" value="delete" class="btn btn-danger">
            </form></td>
            </tr>

                    <?php 
            
            $tatol = $tatol+($value['item_num']*$value['item_pice']);
                
            
            ?>
    
            <?php } ?>

        
        <?php } ?>

    </table>
                <?php echo  $tatol?>
        
    

        


</body>
</html>