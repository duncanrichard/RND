<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PT. Mahaputa Teknologi Indonesia</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center h-screen text-yellow-400">
    <div class="flex flex-col items-center space-y-4">
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-2">RND</h1>
            <h1 class="text-xl mb-4">PT DWIJAYA COSMEDIKA</h1>
        </div>
        <div class="bg-gray-800 p-10 rounded-lg border-2 border-yellow-400 max-w-md w-full">
            <h1 class="text-center text-xl mb-6">LOGIN</h1>
        @if (session('success'))
            <div class="mb-6 bg-green-500 text-white text-center py-3 px-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-6">
                <input type="text" id="username" name="username" placeholder="Username" required
                    class="form-control bg-gray-700 text-yellow-400 border border-yellow-400 w-full py-3 px-4">
            </div>
            <div class="mb-6">
                <input type="password" id="password" name="password" placeholder="Password" required
                    class="form-control bg-gray-700 text-yellow-400 border border-yellow-400 w-full py-3 px-4">
            </div>
            @error('error')
                <p class="text-red-500 text-center">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full bg-yellow-400 py-3 text-gray-900 font-bold rounded-md">
                Login
            </button>
        </form>


        <p class="text-center mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-yellow-400">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
