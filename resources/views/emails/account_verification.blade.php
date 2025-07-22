<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun Anda</title>
</head>

<body>
    <p>Halo {{ $user->name }},</p>
    <p>Akun Anda telah dibuat di sistem kami dengan peran **{{ $user->role }}**.</p>
    <p>Untuk mengaktifkan akun Anda dan bisa login, silakan klik tautan di bawah ini:</p>
    <p><a href="{{ $verificationUrl }}">Verifikasi Akun Saya Sekarang</a></p>
    <p>Jika Anda tidak dapat mengklik tautan di atas, salin dan tempel URL berikut ke browser Anda:</p>
    <p>{{ $verificationUrl }}</p>
    <p>Tautan ini akan kedaluwarsa dalam waktu tertentu (jika Anda mengimplementasikan kedaluwarsa token).</p>
    <p>Terima kasih,</p>
    <p>Tim Aplikasi Anda</p>
</body>

</html>
