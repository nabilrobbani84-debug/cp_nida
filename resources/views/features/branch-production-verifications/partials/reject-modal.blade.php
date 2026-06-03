<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="rejectForm" method="post">
                @csrf
                @method('patch')
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Data Produksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Produk: <strong id="rejectProductName">—</strong><br>
                        Cabang: <strong id="rejectBranchName">—</strong>
                    </p>
                    <div class="form-group">
                        <label for="rejectNotes" class="form-label fw-bold">
                            Alasan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea id="rejectNotes" name="notes" rows="4" class="form-control" required
                            placeholder="Jelaskan alasan penolakan agar operator cabang dapat melakukan koreksi…"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
