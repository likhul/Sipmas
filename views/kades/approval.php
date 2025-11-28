<h3>Permohonan Menunggu Tanda Tangan Digital</h3>
<table>
    <thead>
        <tr>
            <th>Tiket</th>
            <th>Sudah Diverifikasi Oleh</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($permohonanMenungguKades as $p): ?>
        <tr>
            <td><?= $p->nomor_tiket ?></td>
            <td><?= $p->nama_admin_verifikator ?></td> <td>
                <form action="index.php?action=approval_kades" method="POST">
                    <input type="hidden" name="id" value="<?= $p->id ?>">
                    <button type="submit" class="btn-success">Setujui Permohonan</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>