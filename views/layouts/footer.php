<?php 
        // Cek lagi role untuk penutup div
        $role = $_SESSION['role'] ?? '';
        if (in_array($role, ['admin', 'kades'])): ?>
            </div> </div> <?php endif; ?>

    </main>

    <?php if (!in_array($role, ['admin', 'kades'])): ?>
    <footer>
        <p>&copy; <?= date('Y'); ?> Sistem Informasi Pelayanan Masyarakat Desa Simpang Sungai Duren</p>
    </footer>
    <?php endif; ?>

    <div id="custom-modal" class="hidden">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Konfirmasi</h3>
                <span class="close-btn" onclick="document.getElementById('custom-modal').classList.add('hidden')">&times;</span>
            </div>
            <div class="modal-body">
                <p id="modal-text-content">Masukkan keterangan:</p>
                <textarea id="modal-alasan" rows="3" placeholder="Tuliskan alasan..." style="width: 100%; margin-top: 10px; padding: 10px; border:1px solid #ddd; border-radius:5px;"></textarea>
            </div>
            <div class="modal-footer">
                <button id="modal-cancel-btn" class="cancel-btn" onclick="document.getElementById('custom-modal').classList.add('hidden')">Batal</button>
                <button id="modal-submit-btn" class="submit-btn">Konfirmasi</button>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>

</body>
</html>