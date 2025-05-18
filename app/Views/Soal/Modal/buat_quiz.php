<!-- Tombol Buat Quiz -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuatQuiz">
  Buat Quiz
</button>

<!-- Modal Form Buat Quiz -->
<div class="modal fade" id="modalBuatQuiz" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formBuatQuiz" class="modal-content" method="post" action="/buatquiz/create">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Buat Quiz Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Judul Quiz</label>
          <input type="text" class="form-control" name="judul" required>
        </div>
        <div class="mb-3">
          <label>Deskripsi</label>
          <textarea class="form-control" name="deskripsi"></textarea>
        </div>
        <div class="mb-3">
          <label>Mode</label>
          <select class="form-select" name="mode" id="modeSelect" required>
            <option value="">-- Pilih --</option>
            <option value="time">Ujian</option>
            <option value="practice">Latihan</option>
          </select>
        </div>
        <div class="mb-3" id="timerBox" style="display: none;">
          <label>Timer (menit)</label>
          <input type="number" class="form-control" name="timer" min="1">
        </div>
        <hr />
        <h6>Jumlah soal yang akan digunakan:</h6>
        <p id="jumlahSoal">Memuat...</p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Buat Quiz</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

<!-- Toast dengan tombol OK -->
<div class="position-fixed top-50 start-50 translate-middle p-3" style="z-index: 1100;">
  <div id="quizToast" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
    <div class="d-flex align-items-center">
      <div class="toast-body flex-grow-1" id="toastMsg">Quiz berhasil dibuat!</div>
      <button type="button" class="btn btn-light btn-sm ms-3 me-2" data-bs-dismiss="toast" aria-label="Close">OK</button>
    </div>
  </div>
</div>


<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('formBuatQuiz');
  const modeSelect = document.getElementById('modeSelect');
  const timerBox = document.getElementById('timerBox');
  const jumlahSoal = document.getElementById('jumlahSoal');

  // Tambahkan input hidden untuk id_soal jika belum ada
  let inputIdSoal = form.querySelector('input[name="id_soal"]');
  if (!inputIdSoal) {
    inputIdSoal = document.createElement('input');
    inputIdSoal.type = 'hidden';
    inputIdSoal.name = 'id_soal';
    form.appendChild(inputIdSoal);
  }

  // Toggle kolom timer jika mode "time" dipilih
  modeSelect.addEventListener('change', () => {
    timerBox.style.display = modeSelect.value === 'time' ? 'block' : 'none';
  });

  // Ambil soal saat modal dibuka
  document.getElementById('modalBuatQuiz').addEventListener('shown.bs.modal', async () => {
    jumlahSoal.textContent = 'Memuat...';
    try {
      const res = await fetch('/api/soal');
      if (!res.ok) throw new Error('Gagal menghubungi server.');
      const data = await res.json();
      const idList = data.map(item => item.id_soal ?? item.id); // fallback ke id
      inputIdSoal.value = idList.join(',');
      jumlahSoal.textContent = `${idList.length} soal akan digunakan.`;
    } catch (err) {
      jumlahSoal.textContent = 'Gagal memuat soal.';
      console.error(err);
    }
  });

  // Submit form AJAX
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        body: formData
      });
      const result = await res.json();

      if (res.ok && result.success) {
        // Salin kode akses ke clipboard
        await navigator.clipboard.writeText(result.kode_akses || '');

        // Tutup modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalBuatQuiz'));
        modal.hide();

        // Reset form dan text jumlah soal
        form.reset();
        jumlahSoal.textContent = 'Memuat...';

        // Tampilkan pesan toast dengan kode akses
        document.getElementById('toastMsg').textContent = `Kode akses: ${result.kode_akses} telah disalin ke clipboard.`;

        // Tampilkan toast
        const toastEl = document.getElementById('quizToast');
        const toast = new bootstrap.Toast(toastEl);
        toast.show();

      } else {
        alert(result.message || 'Gagal membuat quiz.');
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat membuat quiz.');
    }
  });
});
</script>
