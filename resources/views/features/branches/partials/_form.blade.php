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
            <label for="branch_name" class="form-label fw-bold">
                Nama Cabang <span class="text-danger">*</span>
            </label>
            <input type="text" id="branch_name" name="branch_name"
                value="{{ old('branch_name', $branch?->branch_name) }}"
                class="form-control @error('branch_name') is-invalid @enderror"
                placeholder="Contoh: Cabang 1" required>
            @error('branch_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="location" class="form-label fw-bold">
                Lokasi <span class="text-danger">*</span>
            </label>
            <input type="text" id="location" name="location"
                value="{{ old('location', $branch?->location) }}"
                class="form-control @error('location') is-invalid @enderror"
                placeholder="Contoh: Pabrik A" required>
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
