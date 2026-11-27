<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Masuk Panel Notula & Presensi - KOWPI') ?></title>
    
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kowpi: {
                            50: '#fdf9f7',
                            100: '#f9f0ec',
                            200: '#f2ded5',
                            300: '#e5c2b4',
                            400: '#ce8e78',
                            500: '#8c4835',
                            600: '#723a2a',
                            700: '#582a1d',
                            800: '#3e1b12',
                            900: '#2a110a',
                            950: '#150805',
                        },
                        gold: {
                            light: '#f5d77f',
                            DEFAULT: '#c99a3e',
                            dark: '#9a7024',
                        },
                        champagne: {
                            50: '#fdfcf9',
                            100: '#faf7f2',
                            200: '#f4ede1',
                            300: '#ebe0ce',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-[#faf7f2] flex items-center justify-center p-4 selection:bg-gold/20 selection:text-kowpi-900 relative overflow-hidden font-sans">

    <!-- Decorative Soft Ambient Glows (Light Luxury) -->
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-gold/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-kowpi-200/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Card Container (Light Premium) -->
        <div class="bg-white border border-champagne-200/90 rounded-3xl p-8 sm:p-10 shadow-xl">
            <!-- Header Brand -->
            <div class="text-center mb-8">
                <!-- High-contrast crisp logo badge -->
                <div class="inline-flex p-3 bg-white rounded-2xl border border-stone-200 shadow-sm mb-4">
                    <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI Logo" class="h-12 w-auto object-contain">
                </div>
                <h1 class="font-serif font-bold text-2xl text-kowpi-950 tracking-wide">
                    KOWPI.ID
                </h1>
                <p class="text-xs uppercase tracking-widest text-gold-dark font-bold mt-1">
                    Panel Administrasi Notula & Presensi
                </p>
                <p class="text-xs text-stone-500 mt-2 max-w-xs mx-auto">
                    <?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia') ?>
                </p>
            </div>

            <!-- Flash Error Message -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="mb-5 p-3.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs flex items-center gap-2.5">
                    <i data-lucide="info" class="w-4 h-4 text-blue-600 shrink-0"></i>
                    <span><?= session()->getFlashdata('info') ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('login/submit') ?>" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <input type="text" name="username" value="<?= old('username', 'admin') ?>" required autofocus
                               class="w-full pl-10 pr-4 py-2.5 bg-stone-50 border border-stone-300 rounded-xl text-stone-900 placeholder-stone-400 text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </div>
                        <input type="password" name="password" value="admin123" required
                               class="w-full pl-10 pr-4 py-2.5 bg-stone-50 border border-stone-300 rounded-xl text-stone-900 placeholder-stone-400 text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold rounded-xl text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group">
                        <span>Masuk ke Dashboard</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 text-gold-light group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>

            <!-- Quick Hint Info -->
            <div class="mt-6 pt-5 border-t border-champagne-200 text-center space-y-3">
                <p class="text-xs text-stone-500">
                    Kredensial Default: <span class="text-kowpi-800 font-mono font-bold">admin</span> / <span class="text-kowpi-800 font-mono font-bold">admin123</span>
                </p>
                <div>
                    <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-kowpi-700 hover:text-kowpi-900 transition-colors">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Kembali ke Halaman Utama Publik</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
