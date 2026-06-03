@if ($errors->any())
    <div class="alert alert-light-danger color-danger alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-circle me-2"></i>
            <ul class="small mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="production_date" class="form-label fw-bold">
                Tanggal Produksi <span class="text-danger">*</span>
            </label>
            <input type="date" id="production_date" name="production_date"
                value="{{ old('production_date', now()->toDateString()) }}"
                class="form-control @error('production_date') is-invalid @enderror" required>
            @error('production_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="id_product" class="form-label fw-bold">
                Produk <span class="text-danger">*</span>
            </label>
            <select id="id_product" name="id_product"
                class="form-select @error('id_product') is-invalid @enderror" required>
                <option value="" disabled {{ old('id_product') ? '' : 'selected' }}>Pilih produk</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id_product }}"
                        {{ (string) old('id_product') === (string) $product->id_product ? 'selected' : '' }}>
                        {{ $product->code }} — {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('id_product')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="good_products" class="form-label fw-bold">
                Jumlah Lolos QC <span class="text-danger">*</span>
            </label>
            <input type="number" id="good_products" name="good_products" min="0"
                value="{{ old('good_products', 0) }}"
                class="form-control @error('good_products') is-invalid @enderror" required>
            @error('good_products')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="rejected_products" class="form-label fw-bold">
                Jumlah Cacat <span class="text-danger">*</span>
            </label>
            <input type="number" id="rejected_products" name="rejected_products" min="0"
                value="{{ old('rejected_products', 0) }}"
                class="form-control @error('rejected_products') is-invalid @enderror" required>
            @error('rejected_products')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <label for="notes" class="form-label fw-bold">Catatan</label>
            <textarea id="notes" name="notes" rows="3"
                class="form-control @error('notes') is-invalid @enderror"
                placeholder="Opsional">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
