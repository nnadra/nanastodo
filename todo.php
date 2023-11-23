<?php 
    include 'db.php';

    //proses insert data
    if(isset($_POST['add'])) {
        // $q_insert = "INSERT INTO task (task_label, task_status) VALUE (
        //     '".$_POST['task']."',
        //     'open'
        // )";

        $q_insert = "INSERT INTO task (task_label, task_status) VALUE (
            '".mysqli_real_escape_string($conn, $_POST['task'])."',
            'open'
        )";
        $run_q_insert = mysqli_query($conn, $q_insert);
        if($run_q_insert) {
            header('Refresh:0; url=todo.php');
        }
    }

    //show data

    $q_select = "SELECT * FROM task ORDER BY task_id DESC";
    $run_q_select = mysqli_query($conn, $q_select);

    //delete data
    if(isset($_GET['delete'])) {
        $q_delete = "DELETE FROM task WHERE task_id = '".$_GET['delete']."'";
        $run_q_delete = mysqli_query($conn, $q_delete);
        header('Refresh:0; url=todo.php');
    }

    //update status data (open/close)
    //done diambil di href done bawah
    if(isset($_GET['done'])) {
        $status = 'close' ;

        if($_GET['status']== 'open') {
            $status = 'close';
        }else {
            $status = 'open';
        }

        $q_update = "UPDATE task SET task_status = '".$status."'WHERE task_id = '".$_GET['done']."'";
        $run_q_update = mysqli_query($conn, $q_update);  
        header('Refresh:0; url=todo.php');
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>To Do List</title>
   
</head>
<body>
    <div class="container">
        <div class="container-2">

        <div class="header">
            <div class="title">
            <i class='bx bx-sun'></i>
            <span>TO DO <br> LIST</span>
            </div>
            <div class="description">
                <?= date("l,d M Y")
                ?>
            </div>
            
        </div>

        <!-- Bagian content -->
        <div class= "content">
            <div class="contentt">
                <div class="task-fiil">
            <div class="card">
                <div class="addtask">
                <form action="" method="post">
                    <input name ="task" type="text" class="input_control" placeholder="Add Task">

                    <div class="text-right">
                        <button class="button" type="submit" name="add">Add</button>
                    </div> 
                </form>
                </div>
            </div></div>
            </div>

            <!-- Bagian Tugas -->
            <div class="task-result">
            <?php 
            //memastikan data ada di database, minimal 1 data
                if(mysqli_num_rows($run_q_select) > 0) {
                    while($r = mysqli_fetch_array($run_q_select)) {

                
            ?>
            <div class="result">
            <div class="card-2">
                <!-- untuk coret mengunakan close, done -->
                <div class="task-item <?= $r['task_status'] == 'close'? 'done': ''?>" >
                    <div>
                        <!-- //ketika cheakbox di klik maka akan kasi url -->
                    <input type="checkbox" onclick="window.location.href = '?done=<?= $r['task_id']?>&status=<?= $r['task_status']?>'" <?= $r['task_status'] == 'close' ? 'checked': ''?>>
                    <span><?= $r['task_label']?></span>
                    </div>
                    <div>
                        <a href="edit.php?id=<?= $r['task_id']?>" class="edit-task" title="Edit"><i class='bx bxs-edit-alt' ></i></a>
                        <a href="?delete=<?= $r['task_id']?>" class="delete-task" title="Remove" onclick="return confirm('Are you sure?')"><i class='bx bxs-trash-alt bx-tada' ></i></a>
                    </div>
                    
                </div>
            </div>
            </div>
        <!-- kalau gaada data maka akan muncul "Belum ada data" -->
       <?php } }else {  ?> 
            <div>Belum ada data</div>
       <?php }?>
            </div>
            
            
        </div>
    </div>
    </div>
</body>
</html>