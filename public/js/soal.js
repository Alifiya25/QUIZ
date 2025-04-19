document.addEventListener('DOMContentLoaded', function () {
    // === Isi Modal Edit ===
    const editButtons = document.querySelectorAll('.btn-edit-soal');
    const modalEdit = document.getElementById('modalEditSoal');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const soal = this.getAttribute('data-soal');
            const a = this.getAttribute('data-a');
            const b = this.getAttribute('data-b');
            const c = this.getAttribute('data-c');
            const d = this.getAttribute('data-d');
            const jawaban = this.getAttribute('data-jawaban');

            modalEdit.querySelector('form').setAttribute('action', `/soal/update/${id}`);
            modalEdit.querySelector('[name="soal"]').value = soal;
            modalEdit.querySelector('[name="pilihan_a"]').value = a;
            modalEdit.querySelector('[name="pilihan_b"]').value = b;
            modalEdit.querySelector('[name="pilihan_c"]').value = c;
            modalEdit.querySelector('[name="pilihan_d"]').value = d;
            modalEdit.querySelector('[name="jawaban_benar"]').value = jawaban;
        });
    });

    // === Hapus Soal dengan Konfirmasi ===
    const deleteButtons = document.querySelectorAll('.btn-delete-soal');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Soal akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request hapus via form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/soal/hapus/${id}`;

                    // CSRF token (jika aktif di project)
                    const csrf = document.querySelector('meta[name="csrf-token"]');
                    if (csrf) {
                        const inputCsrf = document.createElement('input');
                        inputCsrf.type = 'hidden';
                        inputCsrf.name = csrf.getAttribute('name');
                        inputCsrf.value = csrf.getAttribute('content');
                        form.appendChild(inputCsrf);
                    }

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // === Form buat Quiz ===
    document.getElementById('buatQuizForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Hindari reload halaman
    
        let formData = new FormData(this);
    
        fetch('/buatquiz/create', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.kode_akses) {
                // Tutup modal form
                let modalForm = bootstrap.Modal.getInstance(document.getElementById('formQuizModal'));
                modalForm.hide();
    
                // Isi dan tampilkan modal hasil
                document.getElementById('kodeAkses').textContent = data.kode_akses;
                let modalResult = new bootstrap.Modal(document.getElementById('buatQuizModal'));
                modalResult.show();
            } else {
                alert('Terjadi kesalahan, silakan coba lagi.');
            }
        })
        .catch(error => {
            console.error('ERROR:', error);
            alert('Terjadi kesalahan, silakan coba lagi.');
        });
    });
    
    // Tombol salin kode
    document.getElementById('copyKode').addEventListener('click', function() {
        const kode = document.getElementById('kodeAkses').textContent;
        navigator.clipboard.writeText(kode).then(() => {
            alert('Kode quiz telah disalin ke clipboard!');
        }).catch(err => {
            alert('Gagal menyalin kode akses: ' + err);
        });
    });
});