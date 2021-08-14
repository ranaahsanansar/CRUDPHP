<?php

$inserted = FALSE;
// Conecting to Database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";


$conn = mysqli_connect($servername , $username , $password , $database);
if (!$conn){
  die("Sorry " . mysqli_connect_error());
}
// echo $_POST['snoEdit'];
// echo $_GET['update'];

if (isset($_GET['delete'])){
  $sno = $_GET['delete'];
  
  $sql = "DELETE FROM `note` WHERE `note`.`sr.` = $sno ";
  $result = mysqli_query($conn , $sql);

}

if ($_SERVER['REQUEST_METHOD']== 'POST'){
  if (isset($_POST['snoEdit'])){
    $sno = $_POST["snoEdit"];
    $title = $_POST['titleEdit'];
    $discription = $_POST['discEdit'];

    $sql = "UPDATE `note` SET `title` = '$title' , `detail` = '$discription' WHERE `note`.`sr.` = $sno";
    $result = mysqli_query($conn , $sql);
  }
  else
  {
    $title = $_POST['title'];
    $discription = $_POST['disc'];

    $sql = "INSERT INTO `note` (`title`, `detail`, `date`) VALUES ('$title', '$discription', current_timestamp())";
    $result = mysqli_query($conn , $sql);

    if ($result){
      $inserted = TRUE;
    }
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    

    <title>Ahsan Project</title>
  </head>
  <body >
    <div>

      <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editmodalLabel">Edit Note</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action = "index.php" method = "POST">
                <input type="hidden" name="snoEdit" id="snoEdit">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="disc">Discription</label>
                    <textarea class="form-control" id="discEdit" name="discEdit" rows="3"></textarea>
                  </div>
                <button type="submit" class="btn btn-primary">Update Note</button>
              </form>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
          </div>
        </div>
      </div>
          <!-- Navbar ------------------------------------------------------------------------------------------------------ -->
      
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
              <a class="navbar-brand" href="https://www.linkedin.com/in/asn-cs21/" target="_blanck">Rana Ahsan Ansar</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="https://github.com/ranaahsanansar/Forum" target="_blanck">Form</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="https://www.linkedin.com/in/asn-cs21/" target="_blanck">About</a>
                    </li>
                </ul>
              </div>
            </nav>
      
            <?php 
            if ($inserted){
              echo "
              <div class='alert alert-success alert-dismissible fade show' role='alert'>
              <strong>Inserted!</strong> Data is inserted.
              <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
              ";
            }
            ?>
      
            <!-- forms ----------------------------------------------------------------------------------------------------- -->
      
            <div class="container my-4"> <!--  yaha  my-4 margin add krny ky liya dala ha  -->
              <h1 style="margin-bottom: 10px;" >Welcome!</h1>
              <h2 style="margin-bottom: 10px;">This app is use to make Notes with Title</h2>
              <h4>Add a Note Here</h4>
              <form action = "index.php" method = "POST">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" placeholder="Title">
                  </div>
                  <div class="form-group">
                      <label for="disc">Discription</label>
                      <textarea class="form-control" id="disc" name="disc" rows="3"></textarea>
                    </div>
                  <button type="submit" class="btn btn-primary">Add Note</button>
                </form>
            </div>
      
      <!-- php script Display notes -------------------------------------------------------------------------------------------- -->
            <div class="container my-4">
                  <table class="table" id = "myTable">
                    <thead>
                      <tr>
                        <th scope="col">Sr.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Discription</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Selecting Database 
                      $sql = "SELECT * FROM `note`";
                      $result = mysqli_query($conn , $sql);
                      $sr = 0;
                      while ($row = mysqli_fetch_assoc($result)) {
                        $sr += 1;
                        echo "<tr>
                        <th scope='row'>" . $sr ."</th>
                        <td>" . $row['title'] ."</td>
                        <td>" . $row['detail'] ."</td>
                        <td> <button class='edit btn btn-sm btn-primary' id=".$row['sr.'].">Edit</button> <button class='del btn btn-sm btn-primary' id=d".$row['sr.'].">Delete</button> </td>
                      </tr>";
                      }
                      
      
                    ?>
                    </tbody>
                    
                  </table>
      
            </div>
            <hr>


    </div>
    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editmodal">
  Launch demo modal
</button> -->

<!-- Edit Modal -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   
    <script>
      $(document).ready( function () {
      $('#myTable').DataTable();
      } );
    </script>

<script>
  // updating the Title And discription 
  edits = document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click", (e)=>{
      console.log("edit" ,);
      tr = e.target.parentNode.parentNode;
      title = tr.getElementsByTagName("td")[0].innerText;
      description = tr.getElementsByTagName("td")[1].innerText;
      console.log(title , description);
      discEdit.value = description;
      titleEdit.value = title;
      snoEdit.value = e.target.id;
      $('#editmodal').modal('toggle');

    })
  })

  deletes = document.getElementsByClassName('del');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener("click", (e)=>{
      // console.log("edit" ,);
      sno = e.target.id.substr(1,);
      if (confirm("Do you Really want to Delete!")){
        console.log("yes");
        window.location = `index.php?delete=${sno}`;
      }
    })
  })


</script>

  </body>
</html>