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