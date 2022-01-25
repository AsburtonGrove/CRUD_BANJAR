<?php
    // koneksi database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "crud_banjar";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
    // jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        if($_GET['hal'] == "edit")
        {
            $edit = mysqli_query($koneksi, "UPDATE tproject set project_nm = '$_POST[tproject]',
            client = '$_POST[tclient]', project_ld = '$_POST[tproject_ld]', start_dt = '$_POST[tstart_dt]', end_dt = '$_POST[tend_dt]', progress = '$_POST[tprogress]' WHERE project_nm ");
        if($edit) //jika simpan sukses
        {
            echo "<script>
                    alert('Edit data sukses!');
                    document.location='index.php';
            </script>";
        }else {
            echo "<script>
            alert('Edit data GAGAL!!');
            document.location='index.php';
    </script>";
        }
        }else {
            $simpan = mysqli_query($koneksi, "INSERT INTO tproject (project_nm,client, project_ld, start_dt, end_dt, progress)
                                          VALUES ('$_POST[project_nm]', '$_POST[client]', '$_POST[project_ld]', '$_POST[start_dt]', '$_POST[end_dt]', '$_POST[progress]')               
                                                    ");
        if($simpan) //jika simpan sukses
        {
            echo "<script>
                    alert('Simpan data sukses!');
                    document.location='index.php';
            </script>";
        }else {
            echo "<script>
            alert('Simpan data GAGAL!!');
            document.location='index.php';
    </script>";
        }
        }

        
    }

    // Pengujian jika tombol edit/hapus diklik
    if(isset($_GET['hal']))
    {
        // pengujian jika edit data
        if($_GET['hal'] == "edit")
        {
        // Tampilkan data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tproject WHERE project_nm");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
            // jika data ditemukan, maka data ditampung ke dalam variabel
            $vproject = $data['project_nm'];
            $vclient = $data['client'];
            $vprojectld = $data['project_ld'];
            $vstart = $data['start_dt'];
            $vend = $data['end_dt'];
            $vprogress = $data['progress'];
        }
        }else if ($_GET['hal'] == "hapus") {
            $hapus = mysqli_query($koneksi, "DELETE FROM tproject");
            if($hapus) {
                echo "<script>
            alert('Hapus data Sukses!!');
            document.location='index.php';
    </script>";
            }
        }
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- MY CSS -->
    <link rel="stylesheet" href="style.php">

    <title>CRUD Banjar</title>
  </head>

  <div class="container">
  <body>
    <h2>Project Monitoring</h2>


    <!-- Awal Form -->
    <div class="card mt-3">
  <h5 class="card-header bg-primary">Form input data project</h5>
  <div class="card-body">
   <form action="" method="post">
       <div class="form-group">
           <label>PROJECT NAME</label>
           <input type="text" name="project_nm" value="<?=@$vproject?>"  class="form-control" placeholder="Masukkan project anda" required>
       </div>
       <div class="form-group">
           <label>CLIENT</label>
           <input type="text" name="client" value="<?=@$vclient?>" id="" class="form-control" placeholder="Masukkan nama client" required>
       </div>
       <div class="form-group">
           <label>PROJECT LEADER</label>
           <input type="text" name="project_ld" value="<?=@$vprojectld?>" id="" class="form-control" placeholder="Masukkan project leader" required>
       </div>
       <div class="form-group">
           <label>START DATE</label>
           <input type="date" name="start_dt" value="<?=@$vstart?>" id="" class="form-control" placeholder="tanggal mulai" required>
       </div>
       <div class="form-group">
           <label>END DATE</label>
           <input type="date" name="end_dt" value="<?=@$vend?>" id="" class="form-control" placeholder="tanggal selesai" required>
       </div>
       <div class="form-group">
           <label>PROGRESS</label>
           <input type="text" name="progress" value="<?=@$vprogress?>" id="" class="form-control" placeholder="Masukkan progress" required>
       </div>

       <button type="submit" class="btn btn-success mt-3" name="bsimpan">Simpan</button>
       <button type="reset" class="btn btn-danger mt-3" name="breset">Kosongkan</button>
   </form>
  </div>
</div>
<!-- Akhir form -->

<!-- Awal tabel -->
<div class="card mt-3">
  <h5 class="card-header">Data Project</h5>
  <div class="card-body">
   <table class="table table-bordered table-striped">
       <tr>
       <th>PROJECT NAME</th>
       <th>CLIENT</th>
       <th>PROJECT LEADER</th>
       <th>START DATE</th>
       <th>END DATE</th>
       <th>PROGRESS</th>
       <th>ACTION</th>
       </tr>
        <?php
        $no = 1;
        $tampil = mysqli_query($koneksi, "SELECT * from tproject");
        while($data = mysqli_fetch_array($tampil)) : 
        ?>

       <tr>
           <td><?=$data['project_nm']?></td>
           <td><?=$data['client']?></td>
           <td><?=$data['project_ld']?></td>
           <td><?=$data['start_dt']?></td>
           <td><?=$data['end_dt']?></td>
           <td><?=$data['progress']?></td>
           <td>
               <a href="index.php?hal=hapus=<?=$data['project_nm']?>" onclick="return confirm('Apakah yaking ingin menghapus data ini')" class="btn btn-danger">Delete</a>
               <a href="index.php?hal=edit=<?=$data['project_nm']?>" class="btn btn-success" >Edit</a>
           </td>
       </tr>
       <?php endwhile; //penutup perulangan while ?>
   </table>
  </div>
</div>
<!-- Akhir tabel -->

</div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>