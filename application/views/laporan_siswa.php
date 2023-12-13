<!DOCTYPE html>
<html lang="en"><head>
    <title>Document</title>
</head><body>
    <table>
        <tr>
            <th>No.</th>
            <th>Nama Siswa</th>
            <th>Kelas Siswa</th>
            <th>Alamat</th>
            <th>Nomor Telepon</th>
        </tr>
        <?php $no = 1;
        foreach ($siswa as $ssw) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $ssw->nama_siswa ?></td>
                <td><?= $ssw->kelas_siswa ?></td>
                <td><?= $ssw->alamat_siswa ?></td>
                <td><?= $ssw->nomor_telepon ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</body></html>