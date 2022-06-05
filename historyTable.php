<div class="historydown">
    <!-- HISTORY -->
    <h5>History Booking</h5>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th class='tableId'>#ID</th>
                        <th class='tableHotel'>Hotel</th>
                        <th class='tableNama'>Nama</th>
                        <th class='tableRoom'>Type Room</th>
                        <th class='tableTamu'>Tamu</th>
                        <th class='tableArrived'>Arrived</th>
                        <th class='tableDeparture'>Departure</th>
                        <th class='tablePrice'>Price</th>
                        <th class='tableAction'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $record = mysqli_query($connect, "SELECT * FROM users, booking WHERE booking.id_login=users.id_login AND users.username='$_SESSION[username]' ORDER BY booking.id DESC");
                    $row = mysqli_fetch_array($record);
                    if ($row < 1) {
                        echo "
                                                        <td><div><center><img class='invisible' width='300px' src='./Assets/no-results.png' alt=''></center></div></td>
                                                        <td class='historyEmptyy'>
                                                            <div class='historyEmpty'>
                                                                <img class='' width='250px' src='./Assets/no-results.png' alt=''>
                                                                <p>Sorry! Data Empty</p>
                                                            </div>
                                                        </td>
                                                    ";
                    } else {
                    ?>
                        <tr>
                            <td class="tableId"><?= $result['id'] ?></td>
                            <td class="tableHotel"><?= $result['hotel'] ?></td>
                            <td class="tableNama"><?= $result['nama'] ?></td>
                            <td class="tableRoom"><?= $result['room_type'] ?></td>
                            <td class="tableTamu"><?= $result['tamu'] ?></td>
                            <td class="tableArrived"><?= $result['arrived'] ?></td>
                            <td class="tableDeparture"><?= $result['departure'] ?></td>
                            <td class="tablePrice">Rp. <?= $result['price'] ?></td>
                            <td class='tableAction'>
                                <a href='formBooking_delete.php?id=<?= $result['id'] ?>'><i class="uil uil-trash text-white p-1 mx-1 bg-danger rounded-3"> </i> </a>
                                <a href='formBooking_edit.php?id=<?= $result['id'] ?>'><i class="uil uil-pen text-white p-1 mx-1 bg-success rounded-3"> </i></a>
                                <a href='bookDetailAll.php?id=<?= $result['id'] ?>'><i class='uil uil-share text-white p-1 mx-1 bg-primary rounded-3'></i></a>
                            </td>
                        </tr>
                    <?php
                        while ($print = mysqli_fetch_array($record)) {
                            echo "<tr>";
                            echo "<td class='tableId'>" . $print['id'] . "</td>";
                            echo "<td class='tableHotel'>" . $print['hotel'] . "</td>";
                            echo "<td class='tableNama'>" . $print['nama'] . "</td>";
                            echo "<td class='tableRoom'>" . $print['room_type'] . "</td>";
                            echo "<td class='tableTamu'>" . $print['tamu'] . "</td>";
                            echo "<td class='tableArrived'>" . $print['arrived'] . "</td>";
                            echo "<td class='tableDeparture'>" . $print['departure'] . "</td>";
                            echo "<td class='tablePrice'>Rp. " . $print['price'] . "</td>";
                            echo "<td class='tableAction'><a href='formBooking_delete.php?id=" . $print['id'] . "'><i class='uil uil-trash text-white p-1 mx-1 bg-danger rounded-3'></i> </a>";
                            echo "<a href='formBooking_edit.php?id=" . $print['id'] . "'><i class='uil uil-pen text-white p-1 mx-1 bg-success rounded-3'></i> </a>";
                            echo "<a href='bookDetailAll.php?id=" . $print['id'] . "'><i class='uil uil-share text-white p-1 mx-1 bg-primary rounded-3'></i></a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- HISTORY PEMBAYARAN -->
<div class="historydown">
    <h5>History Transaksi</h5>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th class='tableId'>#ID</th>
                        <th class='tableHotel'>Status</th>
                        <th class='tableUser' style="justify-content:center;">Username</th>
                        <th class='tableCard'>ID Card</th>
                        <th class='tableBooking'>ID Book</th>
                        <th class='tableNamaHotel'>Nama Hotel</th>
                        <th class='tablePrice'>Nominal</th>
                        <th class='tableWaktu'>Waktu Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $showbayar = mysqli_query($connect, "SELECT * FROM log_transaksi WHERE namauser='$_SESSION[username]' ORDER BY id_transaksi DESC LIMIT 1");
                    $showtransaksi = mysqli_fetch_array($showbayar);
                    $tampilbayar = mysqli_query($connect, "SELECT * FROM log_transaksi WHERE namauser='$_SESSION[username]' ORDER BY id_transaksi DESC");
                    $tampiltransaksi = mysqli_fetch_array($tampilbayar);
                    if ($tampiltransaksi < 1) {
                        echo "
                                                    <td><div><center><img class='invisible' width='300px' src='./Assets/no-results.png' alt=''></center></div></td>
                                                    <td class='historyEmptyy'>
                                                        <div class='historyEmpty'>
                                                            <img class='' width='250px' src='./Assets/no-results.png' alt=''>
                                                            <p>Sorry! Data Empty</p>
                                                        </div>
                                                    </td>
                                                ";
                    } else {
                    ?>
                        <tr>
                            <td class="tableId"><?= $showtransaksi['id_transaksi'] ?></td>
                            <td class="tableHotel"><?= $showtransaksi['status'] ?></td>
                            <td class="tableUser" style='justify-content:center'><?= $showtransaksi['namauser'] ?></td>
                            <td class="tableCard"><?= $showtransaksi['nomorkartu'] ?></td>
                            <td class="tableBooking"><?= $showtransaksi['idbooking_transaksi'] ?></td>
                            <td class="tableNamaHotel"><?= $showtransaksi['namahotel_transaksi'] ?></td>
                            <td class="tablePrice">Rp. <?= $showtransaksi['nominal_transaksi'] ?></td>
                            <td class='tableWaktu'><?= $showtransaksi['waktu_transaksi'] ?></td>
                        </tr>
                    <?php
                        while ($tampilbayarr = mysqli_fetch_array($tampilbayar)) {
                            echo "<tr>";
                            echo "<td class='tableId'>" . $tampilbayarr['id_transaksi'] . "</td>";
                            echo "<td class='tableHotel'>" . $tampilbayarr['status'] . "</td>";
                            echo "<td class='tableUser' style='justify-content:center'>" . $tampilbayarr['namauser'] . "</td>";
                            echo "<td class='tableCard'>" . $tampilbayarr['nomorkartu'] . "</td>";
                            echo "<td class='tableBooking'>" . $tampilbayarr['idbooking_transaksi'] . "</td>";
                            echo "<td class='tableNamaHotel'>" . $tampilbayarr['namahotel_transaksi'] . "</td>";
                            echo "<td class='tablePrice'>Rp. " . $tampilbayarr['nominal_transaksi'] . "</td>";
                            echo "<td class='tableWaktu'>" . $tampilbayarr['waktu_transaksi'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>