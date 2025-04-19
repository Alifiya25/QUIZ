<!-- Modal Edit Soal -->
<div class="modal fade" id="modalEditSoal" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="soalEdit" class="form-label">Pertanyaan</label>
                        <textarea name="soal" id="soalEdit" class="form-control" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pilihan_aEdit" class="form-label">Pilihan A</label>
                            <input type="text" name="pilihan_a" id="pilihan_aEdit" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pilihan_bEdit" class="form-label">Pilihan B</label>
                            <input type="text" name="pilihan_b" id="pilihan_bEdit" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pilihan_cEdit" class="form-label">Pilihan C</label>
                            <input type="text" name="pilihan_c" id="pilihan_cEdit" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pilihan_dEdit" class="form-label">Pilihan D</label>
                            <input type="text" name="pilihan_d" id="pilihan_dEdit" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jawaban_benarEdit" class="form-label">Jawaban Benar</label>
                        <select name="jawaban_benar" id="jawaban_benarEdit" class="form-select" required>
                            <option value="">-- Pilih Jawaban --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
