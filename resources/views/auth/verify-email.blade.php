<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email Anda</title>
</head>

<body>
    <h1>Verifikasi Alamat Email Anda</h1>

    @if (session('status') == 'verification-link-sent')
    <div style="color: green;">
        Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
    </div>
    @endif

    @if (session('warning'))
    <div style="color: orange;">
        {{ session('warning') }}
    </div>
    @endif

    <p>Sebelum melanjutkan, harap periksa email Anda untuk tautan verifikasi.</p>
    <p>Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang lain.</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>

</html>