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
    {{-- Nama --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name" class="form-label fw-bold">
                Nama Lengkap <span class="text-danger">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $user?->name) }}"
                class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required
                autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Email --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="email" class="form-label fw-bold">
                Email <span class="text-danger">*</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email', $user?->email) }}"
                class="form-control @error('email') is-invalid @enderror" placeholder="contoh@email.com" required
                autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Role --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="id_role" class="form-label fw-bold">
                Role <span class="text-danger">*</span>
            </label>
            <select id="id_role" name="id_role"
                class="form-select @error('id_role') is-invalid @enderror" required>
                <option value="" disabled {{ old('id_role', $user?->id_role) ? '' : 'selected' }}>
                    Pilih role
                </option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id_role }}"
                        {{ (string) old('id_role', $user?->id_role) === (string) $role->id_role ? 'selected' : '' }}>
                        {{ $role->role_name }}
                    </option>
                @endforeach
            </select>
            @error('id_role')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Password --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="password" class="form-label fw-bold">
                Password
                @if (!isset($user))
                    <span class="text-danger">*</span>
                @else
                    <span class="text-muted fw-normal small">(Kosongkan jika tidak ingin diubah)</span>
                @endif
            </label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password"
                {{ !isset($user) ? 'required' : '' }} autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Konfirmasi Password --}}
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="password_confirmation" class="form-label fw-bold">
                Konfirmasi Password
                @if (!isset($user))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Konfirmasi password" {{ !isset($user) ? 'required' : '' }} autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
