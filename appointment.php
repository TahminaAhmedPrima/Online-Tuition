<?php 
include_once "connectdb.php";
session_start();
if($_SESSION['userphone'] == "") {
    header("location: index.php");
}
error_reporting(0);
if(isset($_POST['make'])) {
    $flag = $_SESSION['flag'];
    echo $flag;
    if($flag == 0) {
            $teacherid = $_POST['make'];
            $userid= $_SESSION['userid'];
            $sql0= "select * from user where userid='$userid'";
            $select0 = mysqli_query($conn, $sql0);
            $row0 = mysqli_fetch_assoc($select0);
            $username = $row0['username'];
            $sql = "select * from teacher where teacherid='$teacherid'";
            $select = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($select)) {
                $teachername = $row['teachername'];
                $teacherspeciality = $row['teacherspeciality'];
                $teachersalaryrange = $row['teachersalaryrange'];
                $teacheruniversity = $row['teacheruniversity'];
                $sql2 = "insert into appointment(userid, username, teacherid, teachername, teacherspeciality, teachersalaryrange, teacheruniversity) values('$userid','$username','$teacherid','$teachername', '$teacherspeciality', '$teachersalaryrange', '$teacheruniversity')";
                if(mysqli_query($conn, $sql2)) {
                    echo $_SESSION['flag'];
                    $_SESSION['teacherinput'] = "Selection Successful";
                    $_SESSION['flag'] =1;
                    echo $_SESSION['flag'];
                } else {
                    $_SESSION['teacherinput'] = "Selection Failed";
                }
                echo $_SESSION['flag'];
            } 
            } else {
                $_SESSION['teacherinput'] = "There is already a selection";
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

if($_SESSION['userrole'] == "admin") {
    include_once "header.php";
} else if($_SESSION['userrole'] == "user") {
    include_once "headeruser.php";
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="header"><b> TEACHERS INFORMATION </b> </div>
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
            <div class="header"><b id="doctorheader"> SEARCH TEACHER </b></div>
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
            echo '
             <div class="form-floating mb-3">
              <input type="text" class="form-control" id="floatingInput" name="teachername" placeholder="teachername">
              <label for="floatingInput">Teacher Name</label>
            </div>
            <div class="form-floating mb-3">
              <select class="form-select form-control" name="teacherspeciality">
              <option value="" disabled selected>Speciality</option>
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
                <input type="submit" value="Search" class="btn btn-success" name="teachersearch">
            </div>
        </div>
        ';
        
        ?>
        <div class="col-md-9">
            <div class="header"><b> TEACHERS LIST </b> </div>
            <table class="table">
                <thead>
                    <th>#</th>
                    <th>TEACHER NAME</th>
                    <th>SPECIALITY</th>
                    <th>SALARY RANGE</th>
                    <th>UNIVERSITY</th>
                    <th>SELECTION</th>
                </thead>
                <tbody>
            <?php 
    if(isset($_POST['teachersearch'])) {
    if(empty($_POST['teachername'])) {
        $teachername = "";
        $teacherspeciality = $_POST['teacherspeciality'];
        $teachersalaryrange = $_POST['teachersalaryrange'];
        $teacheruniversity = $_POST['teacheruniversity'];
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                            echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
        
    } else if(empty($_POST['teacherspeciality'])) {
        $teachername = $_POST['teachername'];
        $teacherspeciality = "";
        $teachersalaryrange = $_POST['teachersalaryrange'];
        $teacheruniversity = $_POST['teacheruniversity'];
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    } else if(empty($_POST['teachersalaryrange'])) {
        $teachername = $_POST['teachername'];
        $teacherspeciality = $_POST['teacherspeciality'];
        $teachersalaryrange = "";
        $teacheruniversity = $_POST['teacheruniversity'];
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    } else if(empty($_POST['teachersalary'] AND $_POST['teacherspeciality']AND $_POST['teacheruniversity'])) {
        $teachername = $_POST['teachername'];
        $teacherspeciality = "";
        $teachersalaryrange = "";
        $teacheruniversity = "";
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    } else if(empty($_POST['teachername'] AND $_POST['teachersalary'] AND $_POST['teacheruniversity'])) {
        $teachername = "";
        $teacherspeciality = $_POST['teacherspeciality'];
        $teachersalaryrange = "";
        $teacheruniversity = "";
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    } else if(empty($_POST['teachername'] AND $_POST['teacherspeciality'] AND $_POST['teacheruniversity'])) {
        $teachername = "";
        $teacherspeciality = "";
        $teachersalaryrange = $_POST['teachersalaryrange'];
        $teacheruniversity = "";
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    } else if(empty($_POST['teachername'] AND $_POST['teacherspeciality'] AND $_POST['teachersalary'])) {
        $teachername = "";
        $teacherspeciality = "";
        $teachersalaryrange = "";
        $teacheruniversity = $_POST['teacheruniversity'];
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    }
    else {
        $teachername = $_POST['teachername'];
        $teacherspeciality =$_POST['teacherspeciality'];
        $teachersalaryrange = $_POST['teachersalaryrange'];
        $teacheruniversity = $_POST['teacheruniversity'];
        $sql = "select * from teacher where teachername='$teachername' or teacherspeciality='$teacherspeciality' or teachersalaryrange='$teachersalaryrange' or teacheruniversity='$teacheruniversity'";
        $select=mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select)) {
                           echo '
                                <tr>
                                    <td>'.$row['teacherid'].'</td>
                                    <td>'.$row['teachername'].'</td>
                                    <td>'.$row['teacherspeciality'].'</td>
                                    <td>'.$row['teachersalaryrange'].'</td>
                                    <td>'.$row['teacheruniversity'].'</td>
                                    <td>
                                        <button type="submit" value="'.$row['teacherid'].'" class="btn btn-success" name="make">SELECT</button>
                                    </td>
                                
                                
                                </tr>
                            
                            
                            
                            ';
                        }
    }      
        
        
        
        
    
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