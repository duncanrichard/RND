<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | PT. Mahaputa Teknologi Indonesia</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen text-yellow-400">
    <div class="bg-gray-800 p-10 rounded-lg border-2 border-yellow-400 max-w-lg w-full">
        <h2 class="text-center text-2xl font-bold mb-6">Registrasi Akun</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="username" placeholder="Username" required class="form-control bg-gray-700 text-yellow-400 border border-yellow-400 w-full py-3 px-4 mb-4">
            <input type="email" name="email" placeholder="Email" required class="form-control bg-gray-700 text-yellow-400 border border-yellow-400 w-full py-3 px-4 mb-4">
            <input type="password" name="password" placeholder="Password" required class="form-control bg-gray-700 text-yellow-400 border border-yellow-400 w-full py-3 px-4 mb-4">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="form-control bg-gray-700 text-yellow-400 border border-yellow-400 w-full py-3 px-4 mb-4">
            
            <button type="submit" class="w-full bg-yellow-400 py-3 text-gray-900 font-bold rounded-md">Registrasi</button>
        </form>

        <p class="text-center mt-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-400">Login di sini</a>
        </p>
    </div>
</body>
</html>
