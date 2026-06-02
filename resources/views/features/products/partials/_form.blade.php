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
            <label for="code" class="form-label fw-bold">
                Kode Produk <span class="text-danger">*</span>
            </label>
            <input type="text" id="code" name="code" value="{{ old('code', $product?->code) }}"
                class="form-control @error('code') is-invalid @enderror" placeholder="Contoh: PRD-001" required>
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name" class="form-label fw-bold">
                Nama Produk <span class="text-danger">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $product?->name) }}"
                class="form-control @error('name') is-invalid @enderror" placeholder="Nama produk" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="id_product_type" class="form-label fw-bold">
                Jenis Produk <span class="text-danger">*</span>
            </label>
            <select id="id_product_type" name="id_product_type"
                class="form-select @error('id_product_type') is-invalid @enderror" required>
                <option value="" disabled {{ old('id_product_type', $product?->id_product_type) ? '' : 'selected' }}>
                    Pilih jenis produk
                </option>
                @foreach ($productTypes as $productType)
                    <option value="{{ $productType->id_product_type }}"
                        {{ (string) old('id_product_type', $product?->id_product_type) === (string) $productType->id_product_type ? 'selected' : '' }}>
                        {{ $productType->name }}
                    </option>
                @endforeach
            </select>
            @error('id_product_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="id_unit" class="form-label fw-bold">
                Unit <span class="text-danger">*</span>
            </label>
            <select id="id_unit" name="id_unit" class="form-select @error('id_unit') is-invalid @enderror" required>
                <option value="" disabled {{ old('id_unit', $product?->id_unit) ? '' : 'selected' }}>
                    Pilih unit
                </option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id_unit }}"
                        {{ (string) old('id_unit', $product?->id_unit) === (string) $unit->id_unit ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
            @error('id_unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="hs_code" class="form-label fw-bold">HS Code</label>
            <input type="text" id="hs_code" name="hs_code" value="{{ old('hs_code', $product?->hs_code) }}"
                class="form-control @error('hs_code') is-invalid @enderror" placeholder="Contoh: 8481.80">
            @error('hs_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
