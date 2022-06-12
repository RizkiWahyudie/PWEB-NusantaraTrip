<!-- MEMBUAT KARTU PAYMENT -->
<div class="detail-book bg-white" style="margin: 0 0 1rem 0">
    <form action="prosesAddCard.php" method="POST">
        <div class="detail-form">
            <div>
                <label class="mt-2">Nomor Rekening</label>
                <input required name="nomor_rekening" type="text" placeholder="Rekening harus berjumlah 5 angka">
            </div>
            <div class="mt-2">
                <label class="">Nama</label>
                <input required name="nama" type="text" placeholder="Nama harus sesuai dengan username">
            </div>
        </div>
        <div class="detail-form">
            <div class="mt-2">
                <label class="">Nomor Kartu</label>
                <input required name="nomor_kartu" type="text" placeholder="No Kartu harus berjumlah 5 angka">
            </div>
            <div class="mt-2">
                <label>Pin Kartu</label>
                <input required name="pin" type="text" placeholder="Input Password/Pin">
            </div>
        </div>
        <div class="mt-2">
            <label>Isi Saldo</label>
            <input required name="saldo" type="text" placeholder="Input Nominal">
        </div>
        <input class="submit mt-4" type="submit" value="Add Card Payment" name="addCard" />
    </form>
</div>

<!-- DATA YANG TERAKSES SEBAGAI ADMIN -->
<div class="historydown mb-3">
    <h5>Data User as Admin</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan User yang mempunyai akses admin</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 10%; justify-content:center;">ID Login</th>
                        <th style="width: 25%; justify-content:center;">Username</th>
                        <th style="width: 25%; justify-content:center;">Nama Admin</th>
                        <th style="width: 40%; justify-content:center;">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tampiladminn = mysqli_query($connect, "SELECT * FROM admindata LIMIT 1");
                    $tampiladmin = mysqli_fetch_array($tampiladminn);
                    $showadminn = mysqli_query($connect, "SELECT * FROM admindata");
                    $showwadmin = mysqli_fetch_array($showadminn);
                    if ($showwadmin < 1) {
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
                            <td style='width: 10%; justify-content:center;'><?= $tampiladmin['id_admin'] ?></td>
                            <td style='width: 25%; justify-content:center;'><?= $tampiladmin['username'] ?></td>
                            <td style='width: 25%; justify-content:center;'><?= $tampiladmin['name'] ?></td>
                            <td style='width: 40%; justify-content:center;'><?= $tampiladmin['email'] ?></td>
                        </tr>
                    <?php
                        while ($showadmin = mysqli_fetch_array($showadminn)) {
                            echo "<tr>";
                            echo "<td style='width: 10%; justify-content:center;'>" . $showadmin['id_admin'] . "</td>";
                            echo "<td style='width: 25%; justify-content:center;'>" . $showadmin['username'] . "</td>";
                            echo "<td style='width: 25%; justify-content:center;'>" . $showadmin['name'] . "</td>";
                            echo "<td style='width: 40%; justify-content:center;'>" . $showadmin['email'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DAFTAR BOOKING HOTEL SEMUA -->
<div class="historydown">
    <!-- HISTORY -->
    <?php
    $booked = mysqli_query($connect, "SELECT * FROM booking ORDER BY id DESC LIMIT 1");
    $result = mysqli_fetch_array($booked);
    ?>
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
                    $record = mysqli_query($connect, "SELECT * FROM booking ORDER BY id DESC");
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

<!-- USER TER ADDICT STAYCATION -->
<div class="historydown mb-3">
    <h5>History User</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan User Ter Addict Staycation</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 10%; justify-content:center;">ID Login</th>
                        <th style="width: 25%; justify-content:center;">Jumlah Booking</th>
                        <th style="width: 25%; justify-content:center;">Jumlah Malam</th>
                        <th style="width: 40%; justify-content:center;">Nominal Termahal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // $showbayar = mysqli_query($connect, "SELECT id_login, floor(sum(price)) AS nominal, sum(jml_malam) AS malam, count(id_login) AS user FROM booking GROUP BY id_login HAVING count(id_login) > 2 ORDER BY sum(price) DESC LIMIT 1");
                    // $showtransaksi = mysqli_fetch_array($showbayar);
                    $tampilbayar = mysqli_query($connect, "SELECT id_login, floor(sum(price)) AS nominal, sum(jml_malam) AS malam, count(id_login) AS user FROM booking GROUP BY id_login HAVING count(id_login) > 2 ORDER BY sum(price) DESC");
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
                        <!-- <tr>
                            <td style='width: 10%; justify-content:center;'><?= $showtransaksi['id_login'] ?></td>
                            <td style='width: 25%; justify-content:center;'><?= $showtransaksi['user'] ?>x Booking</td>
                            <td style='width: 25%; justify-content:center;'><?= $showtransaksi['malam'] ?>x Malam</td>
                            <td style='width: 40%; justify-content:center;'>Rp. <?= $showtransaksi['nominal'] ?></td>
                        </tr> -->
                    <?php
                        while ($tampilbayarr = mysqli_fetch_array($tampilbayar)) {
                            echo "<tr>";
                            echo "<td style='width: 10%; justify-content:center;'>" . $tampilbayarr['id_login'] . "</td>";
                            echo "<td style='width: 25%; justify-content:center;'>" . $tampilbayarr['user'] . "x Booking</td>";
                            echo "<td style='width: 25%; justify-content:center;'>" . $tampilbayarr['malam'] . "x Malam</td>";
                            echo "<td style='width: 40%; justify-content:center;'>Rp. " . $tampilbayarr['nominal'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DAFTAR BOOKING DENGAN PESANAN PALING BARU -->
<div class="historydown mb-3">
    <h5>Latest Booking</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan Booking yang terbaru</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 4%; justify-content:center;">#ID</th>
                        <th style="width: 20%; justify-content:center;">Hotel</th>
                        <th style="width: 20%; justify-content:center;">Nama</th>
                        <th style="width: 28%; justify-content:center;">Checkin</th>
                        <th style="width: 28%; justify-content:center;">Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $latestbookingg = mysqli_query($connect, "SELECT id, hotel, nama, date_format(arrived, '%W, ' '%D ' '%M ' '%Y') as 'checkin', date_format(departure, '%W, ' '%D ' '%M ' '%Y') as 'checkout' from booking order by arrived desc LIMIT 1");
                    $latestbooking = mysqli_fetch_array($latestbookingg);
                    $bookinglatestt = mysqli_query($connect, "SELECT id, hotel, nama, date_format(arrived, '%W, ' '%D ' '%M ' '%Y') as 'checkin', date_format(departure, '%W, ' '%D ' '%M ' '%Y') as 'checkout' from booking order by arrived desc");
                    $bookinglatest = mysqli_fetch_array($bookinglatestt);
                    if ($bookinglatest < 1) {
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
                            <td style='width: 4%; justify-content:center;'><?= $latestbooking['id'] ?></td>
                            <td style='width: 20%; justify-content:center;'><?= $latestbooking['hotel'] ?></td>
                            <td style='width: 20%; justify-content:center;'><?= $latestbooking['nama'] ?></td>
                            <td style='width: 28%; justify-content:center;'><?= $latestbooking['checkin'] ?></td>
                            <td style='width: 28%; justify-content:center;'><?= $latestbooking['checkout'] ?></td>
                        </tr>
                    <?php
                        while ($bookingglatest = mysqli_fetch_array($bookinglatestt)) {
                            echo "<tr>";
                            echo "<td style='width: 4%; justify-content:center;'>" . $bookingglatest['id'] . "</td>";
                            echo "<td style='width: 20%; justify-content:center;'>" . $bookingglatest['hotel'] . "</td>";
                            echo "<td style='width: 20%; justify-content:center;'>" . $bookingglatest['nama'] . "</td>";
                            echo "<td style='width: 28%; justify-content:center;'>" . $bookingglatest['checkin'] . "</td>";
                            echo "<td style='width: 28%; justify-content:center;'>" . $bookingglatest['checkout'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DAFTAR USER DENGAN BOOKING TERMAHAL -->
<div class="historydown mb-3">
    <h5>Rich User Booking</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan User dengan Booking Termahal</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 4%; justify-content:center;">#ID</th>
                        <th style="width: 30%; justify-content:center;">Hotel</th>
                        <th style="width: 30%; justify-content:center;">Nama</th>
                        <th style="width: 25%; justify-content:center;">Total Booking</th>
                        <th style="width: 6%; justify-content:center;">Ranking</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rankkbook = mysqli_query($connect, "SELECT id, hotel, nama, price, RANK() OVER (ORDER BY price DESC) AS booking_termahal FROM booking LIMIT 1");
                    $rankbook = mysqli_fetch_array($rankkbook);
                    $rankpesann = mysqli_query($connect, "SELECT id, hotel, nama, price, RANK() OVER (ORDER BY price DESC) AS booking_termahal FROM booking");
                    $rankpesan = mysqli_fetch_array($rankpesann);
                    if ($rankpesan < 1) {
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
                            <td style='width: 4%; justify-content:center;'><?= $rankbook['id'] ?></td>
                            <td style='width: 30%; justify-content:center;'><?= $rankbook['hotel'] ?></td>
                            <td style='width: 30%; justify-content:center;'><?= $rankbook['nama'] ?></td>
                            <td style='width: 25%; justify-content:center;'><?= $rankbook['price'] ?></td>
                            <td style='width: 6%; justify-content:center;'><?= $rankbook['booking_termahal'] ?></td>
                        </tr>
                    <?php
                        while ($rankingpesan = mysqli_fetch_array($rankpesann)) {
                            echo "<tr>";
                            echo "<td style='width: 4%; justify-content:center;'>" . $rankingpesan['id'] . "</td>";
                            echo "<td style='width: 30%; justify-content:center;'>" . $rankingpesan['hotel'] . "</td>";
                            echo "<td style='width: 30%; justify-content:center;'>" . $rankingpesan['nama'] . "</td>";
                            echo "<td style='width: 25%; justify-content:center;'>" . $rankingpesan['price'] . "</td>";
                            echo "<td style='width: 6%; justify-content:center;'>" . $rankingpesan['booking_termahal'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- USER YANG BELUM PERNAH BOOKING -->
<div class="historydown mb-3">
    <h5>New User</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan User yang belum pernah booking</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 100%; justify-content:center;">ID User</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $newwuser = mysqli_query($connect, "SELECT id_login FROM users EXCEPT SELECT id_login FROM booking LIMIT 1");
                    $newuser = mysqli_fetch_array($newwuser);
                    $userbaru = mysqli_query($connect, "SELECT id_login FROM users EXCEPT SELECT id_login FROM booking");
                    $userrbaru = mysqli_fetch_array($userbaru);
                    if ($userrbaru < 1) {
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
                            <td style='width: 100%; justify-content:center;'><?= $newuser['id_login'] ?></td>
                        </tr>
                    <?php
                        while ($userbaruu = mysqli_fetch_array($userbaru)) {
                            echo "<tr>";
                            echo "<td style='width: 100%; justify-content:center;'>" . $userbaruu['id_login'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DAFTAR AKTIVITAS TRANSAKSI USER -->
<div class="historydown mb-3">
    <h5>Aktivitas Transaksi</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan Log Transaksi User</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 5%; justify-content:center;">ID</th>
                        <th style="width: 18%; justify-content:center;">Time</th>
                        <th style="width: 18%; justify-content:start;">Status</th>
                        <th style="width: 13%; justify-content:center;">Nama</th>
                        <th style="width: 10%; justify-content:center;">ID Card</th>
                        <th style="width: 18%; justify-content:center;">Hotel</th>
                        <th style="width: 18%; justify-content:center;">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $showpaymentt = mysqli_query($connect, "SELECT * FROM log_transaksi ORDER BY id_transaksi DESC LIMIT 1");
                    $showpayment = mysqli_fetch_array($showpaymentt);
                    $showpayy = mysqli_query($connect, "SELECT * FROM log_transaksi ORDER BY id_transaksi DESC");
                    $showwpay = mysqli_fetch_array($showpayy);
                    if ($showwpay < 1) {
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
                            <td style='width: 5%; justify-content:center;'><?= $showpayment['idbooking_transaksi'] ?></td>
                            <td style='width: 18%; justify-content:center;'><?= $showpayment['waktu_transaksi'] ?></td>
                            <td style='width: 18%; justify-content:center;'><?= $showpayment['status'] ?></td>
                            <td style='width: 13%; justify-content:center;'><?= $showpayment['namauser'] ?></td>
                            <td style='width: 10%; justify-content:center;'><?= $showpayment['nomorkartu'] ?></td>
                            <td style='width: 18%; justify-content:center;'><?= $showpayment['namahotel_transaksi'] ?></td>
                            <td style='width: 18%; justify-content:center;'><?= $showpayment['nominal_transaksi'] ?></td>
                        </tr>
                    <?php
                        while ($showpay = mysqli_fetch_array($showpayy)) {
                            echo "<tr>";
                            echo "<td style='width: 5%; justify-content:center;'>" . $showpay['idbooking_transaksi'] . "</td>";
                            echo "<td style='width: 18%; justify-content:center;'>" . $showpay['waktu_transaksi'] . "</td>";
                            echo "<td style='width: 18%; justify-content:center;'>" . $showpay['status'] . "</td>";
                            echo "<td style='width: 13%; justify-content:center;'>" . $showpay['namauser'] . "</td>";
                            echo "<td style='width: 10%; justify-content:center;'>" . $showpay['nomorkartu'] . "</td>";
                            echo "<td style='width: 18%; justify-content:center;'>" . $showpay['namahotel_transaksi'] . "</td>";
                            echo "<td style='width: 18%; justify-content:center;'>" . $showpay['nominal_transaksi'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DAFTAR AKTIVITAS BOOKING HOTEL CREATE UPDATE DELETE -->
<div class="historydown mb-3">
    <h5>Aktivitas Booking</h5>
    <span style="display:block; margin: -3px 1.5rem 0 1.5rem; font-size: 12px">Menampilkan Create Update Delete yang dilakukan User</span>
    <div class="historyTable">
        <div class="table-responsive mt-3">
            <table class="table header-fixed">
                <thead class="historyHead">
                    <tr class="d-flex historyrow">
                        <th style="width: 4%; justify-content:center; align-items:center">ID</th>
                        <th style="width: 7%; justify-content:center; align-items:center">Activity</th>
                        <th style="width: 9%; justify-content:start; align-items:center">Status</th>
                        <th style="width: 9%; justify-content:start; align-items:center">Nama</th>
                        <th style="width: 10%; justify-content:start; align-items:center">Hotel</th>
                        <th style="width: 7%; justify-content:center; align-items:center">OLD Room</th>
                        <th style="width: 7%; justify-content:center; align-items:center">NEW Room</th>
                        <th style="width: 5%; justify-content:center; align-items:center">OLD Tamu</th>
                        <th style="width: 5%; justify-content:center; align-items:center">NEW Tamu</th>
                        <th style="width: 9%; justify-content:center; align-items:center">OLD Checkin</th>
                        <th style="width: 9%; justify-content:center; align-items:center">NEW Checkin</th>
                        <th style="width: 9%; justify-content:center; align-items:center">OLD Checkout</th>
                        <th style="width: 9%; justify-content:center; align-items:center">NEW Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $logbookingg = mysqli_query($connect, "SELECT * FROM log_booking ORDER BY id_log DESC LIMIT 1");
                    $logbooking = mysqli_fetch_array($logbookingg);
                    $logactivityy = mysqli_query($connect, "SELECT * FROM log_booking ORDER BY id_log DESC");
                    $logactivity = mysqli_fetch_array($logactivityy);
                    if ($logactivity < 1) {
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
                            <td style='width: 4%; justify-content:center;'><?= $logbooking['id_booking'] ?></td>
                            <td style='width: 7%; justify-content:center;'><?= $logbooking['time'] ?></td>
                            <td style='width: 9%; justify-content:center;'><?= $logbooking['status'] ?></td>
                            <td style='width: 9%; justify-content:center;'><?= $logbooking['nama_pemesan'] ?></td>
                            <td style='width: 10%; justify-content:center;'><?= $logbooking['hotel'] ?></td>
                            <td style='width: 7%; justify-content:center;'><?= $logbooking['roomtype_old'] ?></td>
                            <td style='width: 7%; justify-content:center;'><?= $logbooking['roomtype_new'] ?></td>
                            <td style='width: 5%; justify-content:center;'><?= $logbooking['guests_old'] ?></td>
                            <td style='width: 5%; justify-content:center;'><?= $logbooking['guests_new'] ?></td>
                            <td style='width: 9%; justify-content:center;'><?= $logbooking['arrived_old'] ?></td>
                            <td style='width: 9%; justify-content:center;'><?= $logbooking['arrived_new'] ?></td>
                            <td style='width: 9%; justify-content:center;'><?= $logbooking['departure_old'] ?></td>
                            <td style='width: 9%; justify-content:center;'><?= $logbooking['departure_new'] ?></td>
                        </tr>
                    <?php
                        while ($loggactivity = mysqli_fetch_array($logactivityy)) {
                            echo "<tr>";
                            echo "<td style='width: 4%; justify-content:center;'>" . $loggactivity['id_booking'] . "</td>";
                            echo "<td style='width: 7%; justify-content:center;'>" . $loggactivity['time'] . "</td>";
                            echo "<td style='width: 9%; justify-content:center;'>" . $loggactivity['status'] . "</td>";
                            echo "<td style='width: 9%; justify-content:center;'>" . $loggactivity['nama_pemesan'] . "</td>";
                            echo "<td style='width: 10%; justify-content:center;'>" . $loggactivity['hotel'] . "</td>";
                            echo "<td style='width: 7%; justify-content:center;'>" . $loggactivity['roomtype_old'] . "</td>";
                            echo "<td style='width: 7%; justify-content:center;'>" . $loggactivity['roomtype_new'] . "</td>";
                            echo "<td style='width: 5%; justify-content:center;'>" . $loggactivity['guests_old'] . "</td>";
                            echo "<td style='width: 5%; justify-content:center;'>" . $loggactivity['guests_new'] . "</td>";
                            echo "<td style='width: 9%; justify-content:center;'>" . $loggactivity['arrived_old'] . "</td>";
                            echo "<td style='width: 9%; justify-content:center;'>" . $loggactivity['arrived_new'] . "</td>";
                            echo "<td style='width: 9%; justify-content:center;'>" . $loggactivity['departure_old'] . "</td>";
                            echo "<td style='width: 9%; justify-content:center;'>" . $loggactivity['departure_new'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>