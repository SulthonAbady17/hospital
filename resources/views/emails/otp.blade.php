<!DOCTYPE html>
<html>

<head>
    <title>Kode OTP Reset Password</title>
</head>

<body>
    <p>Halo,</p>
    <p>Anda telah meminta kode OTP untuk mengatur ulang password Anda.</p>
    <p>Kode OTP Anda adalah:</p>
    <h2 style="color: #007bff;">{{ $otpCode }}</h2>
    <p>Kode ini berlaku hingga {{ $expiresAt->format('d M Y H:i:s') }} WIB.</p>
    <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
    <p>Terima kasih,<br>Tim {{ config('app.name') }}</p>
</body>

</html>
