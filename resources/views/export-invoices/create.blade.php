@extends('layouts.app')

@section('title', 'Buat Invoice Ekspor')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Buat Invoice Ekspor</h3>
                <p class="text-subtitle text-muted">Silakan input data rincian invoice dan item sesuai dokumen</p>
            </div>
        </div>
    </div>

    <section id="basic-horizontal-layouts">
        <form action="{{ route('export-invoices.store') }}" method="POST">
            @csrf
            <input type="hidden" name="shipping_plan_id" value="{{ $plan->id }}">
            
            <div class="row match-height">
                <!-- Info Rencana & Form Invoice -->
                <div class="col-12 col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Informasi Invoice</h5>
                        </div>
                        <div class="card-body pt-3">
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Nomor PO (PPC)</label>
                                <div class="fs-5 font-bold text-primary">{{ $plan->po_number }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold text-muted small">Tanggal Rencana Kirim</label>
                                <div class="fs-6 font-bold">{{ \Carbon\Carbon::parse($plan->shipping_date)->format('d M Y') }}</div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="invoice_number" class="fw-bold text-muted small">Nomor Invoice</label>
                                <input type="text" id="invoice_number" class="form-control mt-1 @error('invoice_number') is-invalid @enderror" name="invoice_number" placeholder="Contoh: 189/MTC/EX/II/26" value="{{ old('invoice_number') }}" required>
                                @error('invoice_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="invoice_date" class="fw-bold text-muted small">Tanggal Invoice</label>
                                <input type="date" id="invoice_date" class="form-control mt-1 @error('invoice_date') is-invalid @enderror" name="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                @error('invoice_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="fw-bold text-muted small d-block">Import dari Excel / CSV</label>
                                <a href="/templates/invoice_template.csv" class="btn btn-sm btn-outline-success w-100 mb-2" download>
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
                            <h5 class="mb-0">Daftar Item Invoice</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="btn-add-item">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Baris
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="items-table" style="min-width: 1000px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="15%">PO No.</th>
                                            <th width="13%">PO Dated</th>
                                            <th width="8%">Quantity</th>
                                            <th width="26%">Description</th>
                                            <th width="11%">Basic Price</th>
                                            <th width="12%">Mat'l Surcharge (/Pc)</th>
                                            <th width="11%">Amount</th>
                                            <th width="4%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="items-container">
                                        <!-- Row Template -->
                                        <tr class="item-row">
                                            <td>
                                                <input type="text" name="items[0][po_no]" class="form-control form-control-sm" placeholder="e.g. 4500924996 (POS 7)" value="{{ $plan->po_number }}" required>
                                            </td>
                                            <td>
                                                <input type="date" name="items[0][po_dated]" class="form-control form-control-sm" value="{{ $plan->shipping_date }}" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]" class="form-control form-control-sm qty-input" placeholder="Qty" min="1" value="1" required>
                                            </td>
                                            <td>
                                                <textarea name="items[0][description]" class="form-control form-control-sm" rows="2" placeholder="e.g. Side Channel casing FZ431.327.130 (20213747)" required></textarea>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][basic_price]" class="form-control form-control-sm price-input" placeholder="0.00" step="0.01" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][material_surcharge]" class="form-control form-control-sm surcharge-input" placeholder="0.00" step="0.01" min="0" value="0">
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][amount]" class="form-control form-control-sm amount-input" placeholder="0.00" step="0.01" readonly required>
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
                        <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-muted me-2">Total Invoice:</span>
                                <span class="fs-5 fw-bold text-dark" id="grand-total">0.00</span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('export-invoices.index') }}" class="btn btn-light-secondary">Batal</a>
                                <button type="submit" class="btn btn-success">Simpan Invoice</button>
                            </div>
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
        const defaultPoNo = "{{ $plan->po_number }}";
        const defaultPoDate = "{{ $plan->shipping_date }}";

        // Add dynamic row
        btnAdd.addEventListener('click', function() {
            addRow();
        });

        function addRow(data = {}) {
            const tr = document.createElement('tr');
            tr.className = 'item-row';
            tr.innerHTML = `
                <td>
                    <input type="text" name="items[${rowIdx}][po_no]" class="form-control form-control-sm" placeholder="e.g. 4500924996 (POS 7)" value="${data.po_no || defaultPoNo}" required>
                </td>
                <td>
                    <input type="date" name="items[${rowIdx}][po_dated]" class="form-control form-control-sm" value="${data.po_dated || defaultPoDate}" required>
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][quantity]" class="form-control form-control-sm qty-input" placeholder="Qty" min="1" value="${data.quantity || '1'}" required>
                </td>
                <td>
                    <textarea name="items[${rowIdx}][description]" class="form-control form-control-sm" rows="2" placeholder="e.g. Side Channel casing FZ431.327.130 (20213747)" required>${data.description || ''}</textarea>
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][basic_price]" class="form-control form-control-sm price-input" placeholder="0.00" step="0.01" min="0" value="${data.basic_price || ''}" required>
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][material_surcharge]" class="form-control form-control-sm surcharge-input" placeholder="0.00" step="0.01" min="0" value="${data.material_surcharge || '0'}">
                </td>
                <td>
                    <input type="number" name="items[${rowIdx}][amount]" class="form-control form-control-sm amount-input" placeholder="0.00" step="0.01" value="${data.amount || ''}" readonly required>
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
            calculateRowAmounts();
        }

        // Calculate and update amounts
        function calculateRowAmounts() {
            const rows = container.querySelectorAll('.item-row');
            let grandTotal = 0;

            rows.forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                const priceInput = row.querySelector('.price-input');
                const surchargeInput = row.querySelector('.surcharge-input');
                const amountInput = row.querySelector('.amount-input');

                const qty = parseInt(qtyInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                const surcharge = parseFloat(surchargeInput.value) || 0;

                const amount = qty * (price + surcharge);
                amountInput.value = amount.toFixed(2);
                grandTotal += amount;
            });

            document.getElementById('grand-total').textContent = grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Event delegation for input calculations
        container.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty-input') || 
                e.target.classList.contains('price-input') || 
                e.target.classList.contains('surcharge-input')) {
                calculateRowAmounts();
            }
        });

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
                            if (!cols || cols.length < 3 || !cols[0]) return;

                            // Formats date nicely if parsed as Excel Serial Date or standard string
                            let poDate = String(cols[1] || '').trim();
                            if (typeof cols[1] === 'number') {
                                // Simple conversion of Excel serial date
                                const dateObj = new Date((cols[1] - 25569) * 86400 * 1000);
                                const y = dateObj.getFullYear();
                                const m = String(dateObj.getMonth() + 1).padStart(2, '0');
                                const d = String(dateObj.getDate()).padStart(2, '0');
                                poDate = `${y}-${m}-${d}`;
                            }

                            const qty = parseInt(cols[2]) || 1;
                            const bPrice = parseFloat(cols[4]) || 0;
                            const surcharge = parseFloat(cols[5]) || 0;
                            const amt = qty * (bPrice + surcharge);

                            addRow({
                                po_no: String(cols[0] || '').trim(),
                                po_dated: poDate,
                                quantity: qty,
                                description: String(cols[3] || '').trim(),
                                basic_price: bPrice,
                                material_surcharge: surcharge,
                                amount: amt
                            });
                        });
                        
                        if (container.querySelectorAll('.item-row').length === 0) {
                            rowIdx = 0;
                            addRow();
                        } else {
                            calculateRowAmounts();
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
                    calculateRowAmounts();
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
