<?php 
include "auth/session_check.php";

include "auth/lang_config.php";
include "_partials/header.php";
include "_partials/sidebar.php";
?>
 
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><b><?php echo $txt_order_ticket; ?></b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $txt_order_ticket; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
 
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $txt_ticket_list; ?>
                            
                        </div>
                        <div class="card-body">
                            <?php
                            if (!empty($_GET["kode"])) {
								$date = date("Y-m-d H:i:s");
								
								//$mysqli berasal dari file dbconfig
								$result = mysqli_query($mysqli, "INSERT INTO tiket_dibeli(username,tanggal) VALUES
								('".$_SESSION['username']."', '$date');");
								$result2 = mysqli_query($mysqli, "INSERT INTO detail_tiket(id_jadwal) VALUES
								('".$_GET['kode']."');");
								if ($result) {
									//Jika berhasil
								} else {
									echo "Error: "  . "<br>" .  mysqli_error($mysqli);
								}
							?>
                            <div class="alert alert-success">
                                <?php echo $txt_success_order; ?>
                            </div>
                            <?php } ?>
 
                            <div class="table-responsive">
                                <table class="table table-bordered table-hovered">
                                    <thead>
                                        <tr>
                                            <th width="10px" class="text-center">No</th>
                                            <th><?php echo $txt_train; ?></th>
                                            <th><?php echo $txt_from; ?></th>
                                            <th><?php echo $txt_to; ?></th>
                                            <th><?php echo $txt_duration; ?></th>
                                            <th><?php echo $txt_price; ?></th>
                                            <th class="text-center"><?php echo $txt_action; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$query_jadwal = mysqli_query($mysqli,"SELECT id_jadwal,nama_kereta,berangkat,waktu_berangkat,tujuan,perkiraan_tiba,TIMEDIFF(perkiraan_tiba,waktu_berangkat) AS durasi,harga FROM jadwal JOIN kereta ON jadwal.no_kereta=kereta.no_kereta");
											$row = mysqli_num_rows($query_jadwal);
											
											if($row > 0){
												$n=1;
												//
												while ($res = mysqli_fetch_assoc($query_jadwal))
												{
													$durasi = $res['durasi'];
													$arr_durasi = explode(":",$durasi);
													echo "<tr><td>$n
														<td>".$res['nama_kereta']."
														<td>".$res['waktu_berangkat']."<br><small>".$res['berangkat']."</small>
														<td>".$res['perkiraan_tiba']."<br><small>".$res['tujuan']."</small>
														<td>$arr_durasi[0]<sub>$txt_hour</sub> $arr_durasi[1]<sub>m</sub> 
														<td>Rp. ".$res['harga']."
														<td class='text-center'><a onclick=\"javascript: return confirm('Yakin pesan?');\" href='?kode=".$res['id_jadwal']."' class='btn bg-success '>$txt_buy</a>";
													$n=$n+1;
												}
											}else {
													echo "<tr><td colspan=7> <center> $txt_no_data";
												}


										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>
    </div>
</div>
<?php include "_partials/footer.php"; ?>