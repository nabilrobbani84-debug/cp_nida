@extends('layouts.app')

@section('title', 'Input Packing List Gudang')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Input Packing List Gudang</h3>
                <p class="text-subtitle text-muted">Silakan input data rincian kemasan, berat, dan dimensi secara mendetail</p>
            </div>
        </div>
    </div>

    <section id="basic-horizontal-layouts">
        <form action="{{ route('packing-lists.store') }}" method="POST">
            @csrf
            @if($plan)
                <input type="hidden" name="shipping_plan_id" value="{{ $plan->id }}">
            @endif
            
            <div class="row match-height">
                <!-- Info Rencana Kirim -->
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Rencana PPC / PO</h5>
                        </div>
                        <div class="card-body pt-3">
                            @if($plan)
                                <div class="mb-3">
                                    <label class="fw-bold text-muted small">Nomor PO</label>
                                    <div class="fs-5 font-bold text-primary">{{ $plan->po_number }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold text-muted small">Rencana Tanggal Kirim</label>
                                    <div class="fs-6 font-bold">{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="po_number" class="fw-bold text-muted small">Nomor PO Baru</label>
                                    <input type="text" id="po_number" class="form-control mt-1 @error('po_number') is-invalid @enderror" name="po_number" placeholder="Masukkan Nomor PO Baru" value="{{ old('po_number') }}" required>
                                    @error('po_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="shipping_date" class="fw-bold text-muted small">Tanggal Rencana Kirim</label>
                                    <input type="date" id="shipping_date" class="form-control mt-1 @error('shipping_date') is-invalid @enderror" name="shipping_date" value="{{ old('shipping_date') }}" required>
                                    @error('shipping_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            <hr>
                            <div class="mb-3">
                                <label for="packing_list_number" class="fw-bold text-muted small">Nomor Packing List / Weight Note</label>
                                <input type="text" id="packing_list_number" class="form-control mt-1 @error('packing_list_number') is-invalid @enderror" name="packing_list_number" placeholder="Contoh: 189/MTC/EX/II/26" value="{{ old('packing_list_number') }}" required>
                                @error('packing_list_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="fw-bold text-muted small d-block">Import dari Excel / CSV</label>
                                <a href="/templates/packing_list_template.csv" class="btn btn-sm btn-outline-success w-100 mb-2" download>
                                    <i class="bi bi-download me-1"></i> Unduh Template Excel (CSV)
                                </a>
                                <input type="file" id="csv_file" class="form-control form-control-sm" accept=".csv, .xlsx">
                                <small class="text-muted" style="font-size: 0.75rem;">Unggah berkas CSV template yang telah diisi untuk memuat baris item otomatis.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rincian Item (Tabel Dinamis) -->
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h5 class="mb-0">Daftar Item / Rincian Kemasan</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="btn-add-item">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Baris
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="items-table" style="min-width: 900px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="15%">No. Order</th>
                                            <th width="25%">Deskripsi Barang</th>
                                            <th width="20%">Dimensi (PxLxT cm)</th>
                                            <th width="12%">Gross Wt (kg)</th>
                                            <th width="12%">Net Wt (kg)</th>
                                            <th width="10%">Qty (Pcs)</th>
                                            <th width="6%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-container">
                                        <!-- Row Template -->
                                        <tr class="item-row">
                                            <td>
                                                <input type="text" name="items[0][order_number]" class="form-control form-control-sm" placeholder="Order No" required>
                                            </td>
                                            <td>
                                                <textarea name="items[0][description]" class="form-control form-control-sm" rows="1" placeholder="Deskripsi barang" required></textarea>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="items[0][length]" class="form-control" placeholder="P" step="0.1">
                                                    <input type="number" name="items[0][width]" class="form-control" placeholder="L" step="0.1">
                                                    <input type="number" name="items[0][height]" class="form-control" placeholder="T" step="0.1">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][gross_weight]" class="form-control form-control-sm" placeholder="Gross" step="0.01" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][net_weight]" class="form-control form-control-sm" placeholder="Net" step="0.01" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]" class="form-control form-control-sm" placeholder="Qty" min="1" required>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-link text-danger btn-remove-row" disabled>
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-end gap-2">
                            <a href="{{ route('packing-lists.index') }}" class="btn btn-light-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">Simpan Packing List & Weight Note</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIdx = 1;
        const container = document.getElementById('items-container');
        const btnAdd = document.getElementById('btn-add-item');
        const fileInput = document.getElementById('csv_file');

        // Add dynamic row
        btnAdd.addEventListener('click', function() {
            addRow();
        });

        function addRow(data = {}) {
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td>
                    <input type="text" name="items[${rowIdx}][order_number]" class="form-control form-control-sm" placeholder="Order No" value="${data.order_number || ''}" required>
                </td>
                <td>
                    <textarea name="items[${rowIdx}][description]" class="form-control form-control-sm" rows="1" placeholder="Deskripsi barang" required>${data.description || ''}</textarea>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <input type="number" name="items[${rowIdx}][length]" class="form-control" placeholder="P" step="0.1" value="${data.length || ''}">
                        <input type="number" name="items[${rowIdx}][width]" class="form-control" placeholder="L" step="0.1" value="${data.width || ''}">
                        <input type="number" name="items[${rowIdx}][height]" class="form-control" placeholder="T" step="0.1" value="${data.height || ''}">
                    </div>
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][gross_weight]" class="form-control form-control-sm" placeholder="Gross" step="0.01" min="0" value="${data.gross_weight || ''}" required>
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][net_weight]" class="form-control form-control-sm" placeholder="Net" step="0.01" min="0" value="${data.net_weight || ''}" required>
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][quantity]" class="form-control form-control-sm" placeholder="Qty" min="1" value="${data.quantity || '1'}" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-link text-danger btn-remove-row">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                </td>
            `;
            container.appendChild(tr);
            rowIdx++;
            updateRemoveButtons();
        }

        // Excel & CSV Parser using SheetJS
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(evt) {
                    try {
                        const data = new Uint8Array(evt.target.result);
                        const workbook = XLSX.read(data, {type: 'array'});
                        const firstSheetName = workbook.SheetNames[0];
                        const worksheet = workbook.Sheets[firstSheetName];
                        
                        // Parse sheet to JSON array (2D array)
                        const jsonData = XLSX.utils.sheet_to_json(worksheet, {header: 1});
                        
                        // Remove header row
                        if (jsonData.length > 0) jsonData.shift();

                        container.innerHTML = '';
                        rowIdx = 0;

                        jsonData.forEach(cols => {
                            // Skip empty rows or header description
                            if (!cols || cols.length < 2 || !cols[0]) return;

                            addRow({
                                order_number: String(cols[0] || '').trim(),
                                description: String(cols[1] || '').trim(),
                                length: cols[2] ? parseFloat(cols[2]) : '',
                                width: cols[3] ? parseFloat(cols[3]) : '',
                                height: cols[4] ? parseFloat(cols[4]) : '',
                                gross_weight: cols[5] ? parseFloat(cols[5]) : '0',
                                net_weight: cols[6] ? parseFloat(cols[6]) : '0',
                                quantity: cols[7] ? parseInt(cols[7]) : '1'
                            });
                        });
                        
                        if (container.querySelectorAll('.item-row').length === 0) {
                            rowIdx = 0;
                            addRow();
                        }
                    } catch (error) {
                        alert('Gagal membaca file. Pastikan format file sesuai dengan template.');
                        console.error(error);
                    }
                };
                reader.readAsArrayBuffer(file);
            });
        }

        // Remove row event delegation
        container.addEventListener('click', function(e) {
            const btnRemove = e.target.closest('.btn-remove-row');
            if (btnRemove) {
                const row = btnRemove.closest('.item-row');
                if (row) {
                    row.remove();
                    updateRemoveButtons();
                }
            }
        });

        function updateRemoveButtons() {
            const rows = container.querySelectorAll('.item-row');
            rows.forEach((row, index) => {
                const btn = row.querySelector('.btn-remove-row');
                if (rows.length === 1) {
                    btn.setAttribute('disabled', 'disabled');
                } else {
                    btn.removeAttribute('disabled');
                }
            });
        }
    });
</script>
@endpush
