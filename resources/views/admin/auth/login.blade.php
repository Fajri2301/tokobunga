<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - TokoBunga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-500 rounded-3xl shadow-xl shadow-blue-200 mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900">Admin Panel</h1>
            <p class="text-slate-500 mt-2 font-medium">Silakan masuk untuk mengelola toko Anda.</p>
        </div>

        <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl border border-slate-100">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all" placeholder="admin@example.com" required autofocus>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input type="password" name="password" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all" placeholder="••••••••" required>
                </div>

                @if($errors->any())
                    <div class="p-4 bg-red-50 rounded-2xl border border-red-100 text-red-600 text-sm font-bold">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-200 transition-all transform active:scale-95">
                    Masuk Sekarang
                </button>
            </form>
        </div>
        <p class="text-center mt-10 text-slate-400 text-sm font-bold">&copy; {{ date('Y') }} TokoBunga Official</p>
    </div>
</body>
</html>
