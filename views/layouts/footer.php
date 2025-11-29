<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            </div> </div> <?php endif; ?>

    </main>

    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'): ?>
        <footer style="text-align:center; padding:20px; color:#999; font-size:12px; margin-top:auto;">
            &copy; <?= date('Y'); ?> Sistem Informasi Pelayanan Masyarakat Desa Simpang Sungai Duren.
        </footer>
    <?php endif; ?>

    <div id="globalModal" class="modal-overlay">
        <div class="modal-box">
            <div id="modalIcon" class="modal-icon">⚠️</div>
            <h3 id="modalTitle" class="modal-title">Konfirmasi</h3>
            <p id="modalText" class="modal-text">Apakah Anda yakin?</p>
            
            <div id="modalInputArea" class="modal-input-area">
                <label style="font-size:0.85rem; font-weight:bold; color:#333;">Alasan:</label>
                <textarea id="modalInputValue" rows="3" placeholder="Tuliskan alasannya disini..."></textarea>
            </div>

            <div class="modal-buttons">
                <button id="btnCancel" class="btn-modal btn-cancel">Batal</button>
                <button id="btnConfirm" class="btn-modal btn-confirm">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('globalModal');
        const btnCancel = document.getElementById('btnCancel');
        const btnConfirm = document.getElementById('btnConfirm');
        
        function closeModal() {
            modal.classList.remove('show');
        }

        btnCancel.onclick = closeModal;
        
        modal.onclick = function(e) {
            if (e.target === modal) closeModal();
        }

        function showPopup(type, title, text, callback) {
            document.getElementById('modalInputArea').style.display = 'none';
            document.getElementById('modalInputValue').value = '';
            
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalText').textContent = text;
            
            const icon = document.getElementById('modalIcon');
            const confirmBtn = document.getElementById('btnConfirm');

            if (type === 'delete') {
                icon.textContent = '';
                confirmBtn.className = 'btn-modal btn-danger-modal';
                confirmBtn.textContent = 'Hapus';
            } else if (type === 'logout') {
                icon.textContent = '';
                confirmBtn.className = 'btn-modal btn-danger-modal';
                confirmBtn.textContent = 'Keluar';
            } else if (type === 'input') { 
                icon.textContent = '📝';
                confirmBtn.className = 'btn-modal btn-danger-modal';
                confirmBtn.textContent = 'Kirim Penolakan';
                document.getElementById('modalInputArea').style.display = 'block';
            } else {
                icon.textContent = '';
                confirmBtn.className = 'btn-modal btn-confirm';
                confirmBtn.textContent = 'Ya, Lanjutkan';
            }

            modal.classList.add('show');
            confirmBtn.onclick = function() {
                const inputValue = document.getElementById('modalInputValue').value;
                if (type === 'input' && !inputValue.trim()) {
                    alert("Harap isi alasan terlebih dahulu!");
                    return;
                }
                callback(inputValue); // Jalankan aksi (Redirect atau Submit)
                closeModal();
            };
        }
    </script>

</body>
</html>