<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HIMATIKA UNUJA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1A0A0F 0%, #711C35 100%); min-height: 100vh; display: flex; align-items: center; }
        .login-card { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); overflow: hidden; }
        .login-left { background: linear-gradient(135deg, #1A0A0F 0%, #711C35 100%); color: #fff; padding: 3rem; display: flex; flex-direction: column; justify-content: center; }
        .login-right { padding: 3rem; }
        .form-control:focus { border-color: #A33B59; box-shadow: 0 0 0 0.2rem rgba(163, 59, 89, 0.25); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="login-card row g-0">
                    <div class="col-lg-5 login-left d-none d-lg-flex">
                        @php
                            $loginLogo = null;
                            $loginAlt = $siteSettings['logo_admin_login_alt'] ?? 'Logo HIMATIKA';
                            if (($siteSettings['logo_admin_login_custom'] ?? '0') === '1' && !empty($siteSettings['logo_admin_login_file'])) {
                                $loginLogo = asset('storage/' . $siteSettings['logo_admin_login_file']);
                            } elseif (!empty($siteSettings['main_logo'])) {
                                $loginLogo = asset('storage/' . $siteSettings['main_logo']);
                            } elseif ($globalProfile && $globalProfile->logo) {
                                $loginLogo = asset('storage/' . $globalProfile->logo);
                            }
                        @endphp
                        <div>
                            @if($loginLogo)
                                <div class="mb-3">
                                    <img src="{{ $loginLogo }}" alt="{{ $loginAlt }}" style="max-height: 54px; max-width: 100%; object-fit: contain;">
                                </div>
                            @endif
                            <h2><i class="fas fa-laptop-code me-2"></i>{{ $siteSettings['site_short_title'] ?? 'HIMATIKA' }} UNUJA</h2>
                            <p class="mt-3 opacity-75">Himpunan Mahasiswa Matematika</p>
                            <p class="small opacity-50">Silakan login untuk mengelola konten website.</p>
                        </div>
                    </div>
                    <div class="col-lg-7 login-right">
                        <h4 class="fw-bold mb-4">Login Admin</h4>
                        @if(session('error'))
                        <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                        <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
                        @endif
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="admin@himatika.test" required autofocus>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" class="text-muted text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Kembali ke website</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
