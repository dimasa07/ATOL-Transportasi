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
                    <h1 class="m-0 text-dark"><b><?php echo $txt_order_history; ?></b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $txt_order_history; ?></li>
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
                            <?php echo $txt_history_list; ?>
                            
                        </div>
                        <div class="card-body">
                            <?php
							if (!empty($_GET["kode_hapus"])) { 
								$query = "DELETE FROM `tiket_dibeli` WHERE kode_booking ='".$_GET['kode_hapus']."'";
								$query2 = "DELETE FROM `detail_tiket` WHERE kode_booking ='".$_GET['kode_hapus']."'";
								$result = mysqli_query($mysqli,$query);
								$result2 = mysqli_query($mysqli,$query2);
							?>
                            <div class="alert alert-warning">
                                <?php echo $txt_success_delete_history; ?>
                            </div>
                            <?php } ?>
 
                            <div class="table-responsive">
                                <table class="table table-bordered table-hovered">
                                    <thead>
                                        <tr>
                                            <th width="10px" class="text-center">No</th>
                                            <th><?php echo $txt_booking_kode; ?></th>
                                            <th><?php echo $txt_buyer_name; ?></th>
                                            <th><?php echo $txt_date; ?></th>
                                            <th><?php echo $txt_price; ?></th>
                                            <th class="text-center"><?php echo $txt_action; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
											$query_tiket = mysqli_query($mysqli,"SELECT * FROM tiket_dibeli JOIN user ON tiket_dibeli.username=user.username JOIN detail_tiket ON tiket_dibeli.kode_booking=detail_tiket.kode_booking JOIN jadwal ON detail_tiket.id_jadwal=jadwal.id_jadwal WHERE tiket_dibeli.username='".$_SESSION['username']."'");
											$row = mysqli_num_rows($query_tiket);
											
											if($row > 0){
												$n=1;
												//
												while ($res = mysqli_fetch_assoc($query_tiket))
												{
													echo "<tr><td>$n
														<td>".$res['Kode_Booking']."
														<td>".$res['fullname']."
														<td>".$res['Tanggal']."
														<td>Rp. ".$res['Harga']."
														<td class='text-center'>
															<div class='btn-group'>
																<a href='history_info.php?kode_booking=".$res['Kode_Booking']."' class='btn btn-sm btn-success'>
																	<i class='fa fa-info'></i>
																</a>
																<a onclick=\"javascript: return confirm('$txt_sure_delete');\" href='?kode_hapus=".$res['Kode_Booking']."' class='btn btn-sm btn-danger'>
																	<i class='fa fa-trash-alt'></i>
																</a>
															</div>";
													$n=$n+1;
												}
											}else {
													echo "<tr><td colspan=7><center> $txt_no_data";
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