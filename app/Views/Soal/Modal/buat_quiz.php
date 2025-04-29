<!-- Tombol untuk membuka modal Form -->
<button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#formQuizModal">
  <i class="bi bi-pencil-square me-2"></i> Buat Quiz
</button>

<!-- Modal untuk Form Buat Quiz -->
<div class="modal fade" id="formQuizModal" tabindex="-1" aria-labelledby="formQuizModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formQuizModalLabel">Buat Quiz Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form id="buatQuizForm" method="post" action="/buatquiz/create">
          <div class="mb-3">
            <label for="judul" class="form-label">Judul Quiz</label>
            <input type="text" class="form-control" id="judul" name="judul" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
          </div>
          <div class="mb-3">
            <label for="mode" class="form-label">Mode</label>
            <select class="form-select" id="mode" name="mode" required>
              <option value="time">Mode Latihan</option>
              <option value="practice">Mode Ujian</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="timer" class="form-label">Timer</label>
            <input type="number" class="form-control" id="timer" name="timer">
          </div>
          <button type="submit" class="btn btn-primary">Buat Quiz</button>
        </form>
      </div>
    </div>
  </div>
</div>
