<div class="table-responsive">
    <table id="w0" class="table table-striped table-bordered detail-view"><tbody>
        <tr>
            <th class="text-center">STT</th>
            <th class="text-center">Ngày</th>
            <th class="text-center">Hệ điều hành</th>
            <th class="text-center">Thiết bị</th>
            <th class="text-center">Trình duyệt</th>
            <th class="text-center">Phiên bản</th>
            <th class="text-center">Địa chỉ IP</th>
        </tr>
        <?php
            if( !empty($resultLogin) ){
                $i = 0;
                foreach($resultLogin as $row){
                    $i++;
        ?>
            <tr>
                <td class="text-center"><?= $i ?></td>
                <td class="text-center"><?= date('H:i:s d/m/Y',strtotime($row['time_login'])) ?></td>
                <td class="text-center"><?= $row['os'] ?></td>
                <td class="text-center"><?= $row['device'] ?></td>
                <td class="text-center"><?= $row['browser'] ?></td>
                <td class="text-center"><?= $row['version'] ?></td>
                <td class="text-center"><?= $row['ip_address'] ?></td>
            </tr>
        <?php
                }
            }else{
                echo '<tr><td class="text-center" colspan="7">Không có dữ liệu</td></tr>';
            }
        ?>
    </table>
</div>    