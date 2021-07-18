<?php
require 'connect.php';
require 'keselamatan.php';
include('template/sidebar.php');
$idpengguna=$_SESSION['idpengguna'];

//Menerima pemboleh ubah dari halaman tambahkuiz.php
$jumlahsoalan=$_GET['jumlahsoalan'];

//Jika borang dihantar, masukkan data ke pangkalan data
if(isset($_POST["submit"])){
    if($jumlahsoalan!=0){
    //menerima nilai pemboleh ubah
    $ArraySoalan=$_POST['soal'];
    $ArrayPilihan=$_POST['plhjwp'];
    $ArrayJawapan=$_POST['jwp'];
    
    //ulangan soalan berdasarkan jumlahsoalan yang dimasukkan oleh pengguna
    for($i=0;$i<$jumlahsoalan;$i++){
        $soal=$ArraySoalan[$i];

        //simpan rekod dalam jadual soalan
        $soal = $_POST['soal'];
        $query = mysqli_query($conn, "SELECT idsoal FROM soal ORDER BY idsoal DESC LIMIT 1");
        $fetch = mysqli_fetch_assoc($query);
        $idsoalsebelum = $fetch['idsoal'];
        $pengubah = (int)substr($idsoalsebelum,-1);
        $pengubah ++;
        $idsoalbaharu = "S".$pengubah;

        $query2 = "SELECT * FROM soalan";
        $nosoal = mysqli_query($conn,$query2);
        $total = mysqli_num_rows($nosoal);
        $next = $total+1;

        $tambah = "INSERT INTO soalan (idsoal,nosoal,soal,idtopik) VALUES ('$idsoalbaharu','$next','$soal','$idtopikbaharu)";
    
        //ulangan 4 pilihan bagi setiap soalan
        for($j=0;$j<4;$j++){        
            //tentukan jawapan
            if($ArrayJawapan[$i]==$i.$j){
                $jawapan=1;
            }else{
                $jawapan=0;
            }
    
            $plhjwp=$ArrayPilihan[$i][$j];

            $idpilihan = $_POST['idpilihan'];
            $query3 = mysqli_query($conn, "SELECT idpilihan FROM pilihan ORDER BY idpilihan DESC LIMIT 1");
            $fetch3 = mysqli_fetch_assoc($query3);
            $idpilihansebelum = $fetch3['idpilihan'];
            $pengubah3 = (int)substr($idpilihansebelum,-1);
            $pengubah3 ++;
            $idpilihanbaharu = "S".$pengubah3;
        
            //simpan rekod baharu dalam jadual pilihan
            $sql = "INSERT INTO pilihan (idpilihan,plhjwp,jwp,idsoal) VALUES('$idpilihanbaharu','$plhjwp','$jawapan','$idsoalbaharu')";
            }
    }
    }
        $hasil=mysqli_query($conn,$tambah,$sql);
        if ($hasil){
            echo"<script>alert('Pendaftaran Soalan Berjaya.');window.location='tambahkuiz.php'</script>";
        }else{
            echo"<script>alert('Pendaftaran Kuiz Gagal.');window.location='tambahkuiz.php'</script>";
        }
}
?>

<head>
    <link rel="stylesheet" href="css/tambahsoalanstyle.css?v=<?php echo time(); ?>">
</head>
        <div class="space">
            <div class="header">
                <h2>Sistem Penilaian Kuiz Bahasa Melayu Tingkatan 4</h2>
                <div class="logoutbutton"><a href="logout.php">Log Keluar</a></div>
            </div>
            <div class="maincontent">
                <div class="title">PENAMBAHAN SOALAN BAHARU</div>
                <div class="balik"><a href="koleksikuizguru.php">Balik</a></div>
                <div class="separator"></div>
                <div class="detailbox">                   
                    <h3>
                    <!-- output borang pendaftaran -->
                    <form id="formsoalan" name="question" class="quizform" method="post" spellcheck="false">
                        <h5 nowrap="nowrap">Topik:
                        <?php
                            $sql="SELECT * FROM topik";
                            $result = mysqli_query($conn,$sql);
                            $row = mysqli_fetch_array($result);
                            $namatopik=$row['topik'];
                        ?>
                        <ins>
                            <?php echo $namatopik;?>
                        </ins>
                        </h5>

                        <!--Ulangan paparan soalan berdasarkan jumlahsoalan yang dimasukkan oleh pengguna-->
                        <?php
                            for($i=0;$i<$jumlahsoalan;$i++){
                        ?>
                        
                            <!--Masukkan butiran soalan ke sistem-->
                            <div id="forminputsoalan" class="forminputsoalan">
                                <input class="soalan" type="text" name="soal[]" placeholder="Soalan <?php echo ($i+1);?>"
                                onkeypress='return event.charCode>=32 && event.charCode<=125' required></input>
                            </div>

                            <!--Ulangan 4 pilihan bagi setiap soalan-->
                            <?php
                                for($j=0;$j<1;$j++){
                            ?>
                            <!--Pilihan-->
                                <div class="forminput">
                                    <input type="text" name="plhjwp[<?php echo $i;?>][<?php echo $j;?>]" placeholder="Pilihan 1"
                                    onkeypress='return event.charCode>=32 && event.charCode<=125' required>
                                    <p>A</p>
                                </div>

                                <div class="forminput2">
                                    <input type="text" name="plhjwp[<?php echo $i;?>][<?php echo $j;?>]" placeholder="Pilihan 2"
                                    onkeypress='return event.charCode>=32 && event.charCode<=125' required>
                                    <p>B</p>
                                </div>

                                <div class="forminput">
                                    <input type="text" name="plhjwp[<?php echo $i;?>][<?php echo $j;?>]" placeholder="Pilihan 3"
                                    onkeypress='return event.charCode>=32 && event.charCode<=125' required>
                                    <p>C</p>
                                </div>

                                <div class="forminput2">
                                    <input type="text" name="plhjwp[<?php echo $i;?>][<?php echo $j;?>]" placeholder="Pilihan 4"
                                    onkeypress='return event.charCode>=32 && event.charCode<=125' required>
                                    <p>D</p>
                                </div>

                                <div class="forminput">
                                    <select class="jawapan" name="jwp[<?php echo $i;?>]" value="<?php echo($i.$j);?>" required>
                                    <!-- using an empty value attribute on the "placeholder" option-->
                                    <!-- "disabled" option stops it from being selected with both mouse and keyboard-->
                                    <!-- When the "select" element is required, it allows use of the ":invalid" CSS pseudo-class which allows you to style the "select" element when in its "placeholder" state-->
                                    <!-- "hidden" element: the option is visible in dropdown, but it is not selectable-->
                                    <option value="" disabled selected hidden>Jawapan</option>
                                    <option value="A">Jawapan: A</option>
                                    <option value="B">Jawapan: B</option>
                                    <option value="C">Jawapan: C</option>
                                    <option value="D">Jawapan: D</option>
                                    </select>
                                </div>
                            <?php
                                }
                            ?>                           
                        <?php
                            }
                        ?>

                        <div class="button">
                            <button class="submit" type="submit">Daftar Soalan</button>
                            <button class="reset" type="reset">Reset</button>
                        </div>
                    </form>
                    </h3>
                </div>                 
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>