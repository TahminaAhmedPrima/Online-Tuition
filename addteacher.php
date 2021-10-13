<?php 
include_once "connectdb.php";
session_start();
if($_SESSION['userphone'] == "" OR $_SESSION['userrole'] == "user") {
    header("location: index.php");
}
if(isset($_POST['teacherregister'])) {
    $teachername = $_POST['teachername'];
    $teacherspeciality = $_POST['teacherspeciality'];
    $teacherjoindate = $_POST['teacherjoindate'];
    $teachersalaryrange = $_POST['teachersalaryrange'];
    $teacheruniversity = $_POST['teacheruniversity'];
    if(!empty($teachername AND $teacherspeciality AND $teacherjoindate AND $teachersalaryrange AND $teacheruniversity)){
        $sql = "insert into teacher(teachername, teacherspeciality, teacherjoindate, teachersalaryrange, teacheruniversity) values('$teachername', '$teacherspeciality', '$teacherjoindate', '$teachersalaryrange', '$teacheruniversity')";
        if(mysqli_query($conn, $sql)) {
            $_SESSION['teacherinput'] = "Registration Successful";
        } else {
            $_SESSION['teacherinput'] = "Registration Failed";
        }
    } else {
        $_SESSION['teacherinput'] = "One or many fields are empty!";
    }
}
if(isset($_POST['teacherupdate'])) {
    $teacherid = $_POST['teacherid'];
    $teachername = $_POST['teachername'];
    $teacherspeciality = $_POST['teacherspeciality'];
    $teacherjoindate = $_POST['teacherjoindate'];
    $teachersalaryrange = $_POST['teachersalaryrange'];
    $teacheruniversity = $_POST['teacheruniversity'];
    echo $teacherid." ".$teachername." ".$teacherspeciality." ".$teacherjoindate." ".$teachersalaryrange." ".$teacheruniversity;
    if(!empty($teachername AND $teacherspeciality AND $teacherjoindate AND $teachersalaryrange AND $teacheruniversity)){
        $sql = "update teacher set teachername='$teachername', teacherspeciality='$teacherspeciality', teacherjoindate='$teacherjoindate', teachersalaryrange='$teachersalaryrange', teacheruniversity='$teacheruniversity' where teacherid='$teacherid'";
        if(mysqli_query($conn, $sql)) {
            $_SESSION['teacherinput'] = "Update Successful";
        } else {
            $_SESSION['teacherinput'] = "Update Failed";
        }
    } else {
        $_SESSION['teacherinput'] = "One or many fields are empty!";
    }
}

if(isset($_POST['id'])){
    echo $_POST['id'];
    $sql = 'delete from teacher where teacherid='.$_POST['id'];
      if(mysqli_query($conn, $sql)) {
            $_SESSION['teacherinput'] = "Deleted Successfully ..";
        }else{
        
            $_SESSION['teacherinput'] = "Deletion Failed ..";
            }
}

include_once "header.php";
?>

<div class="row">
    <div class="col-md-6">
        <div class="header"><b> TEACHER INFORMATION </b> </div>
    </div>
    <div class="col-md-3">
        <div class="header2"><p> <?php echo $_SESSION['username'];?> </p>.</div>
    </div>
    <div class=" col-md-3">
        <a href="logout.php" class="btn btn-danger">Sign out</a>
    </div>
</div>
<div class="info">
    <form action="" method="post">
    <div class="row">
      <div class="col-md-3">
            <div class="header"><b id="teacherheader"> ADD NEW TEACHER </b></div>
            <div class="group">
                <?php if(isset($_SESSION['teacherinput'])) {
                ?>
                 <div class="success" style="background-color: #f7dd16; color: white; padding: 0.5rem; margin-bottom: 0.5rem; border-radius: 10px;">
                     <?php echo $_SESSION['teacherinput']; ?>
                 </div>
                 <?php }?>
                 <?php 
                    unset($_SESSION['teacherinput']);
                ?>
            </div>
            
       <?php 
        if(isset($_POST['edit'])) {
            echo $_POST['edit'];
            echo '
            <script>
                document.getElementById("teacherheader").innerHTML="Update Information";
            </script>
            ';
            $sql = "select * from teacher where teacherid=".$_POST['edit'];
            $select = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($select)) {
            echo '
            <div class="form-floating mb-3">
              <input type="hidden" name="teacherid" value="'.$row['teacherid'].'" placeholder="teacherid">
            </div>
             <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="teachername" value="'.$row['teachername'].'" placeholder="teachername" >
              <label for="floatingInput">Teacher Name</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select form-control" name="teacherspeciality" id="floatingInput">
              <option value="" disabled selected>Select Speciality</option>
              ';
            $sql = "select * from speciality";
            $select = mysqli_query($conn, $sql);
            while($row2 = mysqli_fetch_assoc($select)) {
                echo '
                    <option selected>'.$row['teacherspeciality'].'</option>
                    <option>'.$row2['specialityname'].'</option>
                ';
            }
                echo '
              </select>
              <label for="floatingInput">Speciality</label>
            </div>
             <div class="form-floating mb-3">
              <input type="date" class="form-control" id="floatingInput" name="teacherjoindate" value="'.$row['teacherjoindate'].'" placeholder="teacherjoindate">
              <label for="floatingInput">Joining Date</label>
            </div>
          <div class="form-floating mb-3">
            <select class="form-select form-control" name="teachersalaryrange" id="floatingInput">
              <option value="'.$row['teachersalaryrange'].'" selected>'.$row['teachersalaryrange'].'</option>
              <option value="1000-2000">1000-2000</option>
              <option value="2000-5000">2000-5000</option>
              <option value="5000-10000">5000-10000</option>
              <option value="10000-20000">10000-20000</option>
              </select>
              <label for="floatingInput">Salary Range</label>
            </div>
          <div class="form-floating mb-3">
            <select class="form-select form-control" name="teacheruniversity" id="floatingInput">
              <option value="'.$row['teacheruniversity'].'" selected>'.$row['teacheruniversity'].'</option>
              <option value="Dhaka University">Dhaka University</option>
              <option value="East West University">East West University</option>
              <option value="KUET">KUET</option>
              </select>
              <label for="floatingInput">Select University</label>
            </div>
            <div align="center">
                <input type="submit" value="Update" class="btn btn-success" name="teacherupdate">
            </div>
        </div>
            ';
            }}
     else {
            echo '
             <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="teachername" placeholder="teachername">
              <label for="floatingInput">Teacher Name</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select form-control" name="teacherspeciality" id="floatingInput">
              <option value="" disabled selected>Select Speciality</option>
              ';
            $sql = "select * from speciality";
            $select = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($select)) {
                echo '
                    <option>'.$row['specialityname'].'</option>
                ';
            }
            echo '
              </select>
              <label for="floatingInput">Speciality</label>
            </div>
             <div class="form-floating mb-3">
              <input type="date" class="form-control" id="floatingInput" name="teacherjoindate" placeholder="teacherjoindate">
              <label for="floatingInput">Joining Date</label>
            </div>
            <div class="form-floating mb-3">
                <select class="form-select form-control" name="teachersalaryrange" id="floatingInput">
              <option value="" disabled selected>Select Salary</option>
              <option value="1000-2000">1000-2000</option>
              <option value="2000-5000">2000-5000</option>
              <option value="5000-10000">5000-10000</option>
              <option value="10000-20000">10000-20000</option>
              </select>
              <label for="floatingInput">Salary Range</label>
            </div>
            <div class="form-floating mb-3">
            <select class="form-select form-control" name="teacheruniversity" id="floatingInput">
              <option value="" disabled selected>Select University</option>
              <option value="Dhaka University">Dhaka University</option>
              <option value="East West University">East West University</option>
              <option value="KUET">KUET</option>
              </select>
              <label for="floatingInput">University</label>
            </div>
            <div align="center">
                <input type="submit" value="Register" class="btn btn-success" name="teacherregister">
            </div>
        </div>
        ';
        }
        
        ?>
        <div class="col-md-9">
            <div class="header"><b> TEACHERS LIST </b> </div>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>TEACHER NAME</th>
                    <th>SPECIALITY</th>
                    <th>JOINING DATE</th>
                    <th>SAlARY RANGE</th>
                    <th>UNIVERSITY</th>
                    <th>UPDATE</th>
                    <th>DELETE</th>
                </thead>
                <tbody>
                    <?php 
                        $sql = "select * from teacher order by teacherid desc";
                        $select = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($select)) {
                            echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teacherjoindate'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="edit">UPDATE</button>
                                    </td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-danger" name="id">DELETE</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
        </div>
    </form>
</div>
<?php 
include_once "footer.php";
?>