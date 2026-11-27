<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="Navigasi Halaman" class="flex items-center justify-end">
  <ul class="inline-flex items-center space-x-1 text-xs">
    
    <!-- Tombol Pertama -->
    <?php if ($pager->hasPrevious()) : ?>
      <li>
        <a href="<?= $pager->getFirst() ?>" aria-label="Halaman Pertama"
           class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-600 hover:text-academic-navy border border-slate-200 font-medium transition flex items-center space-x-1"
           title="Halaman Pertama">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
          <span class="hidden sm:inline">Awal</span>
        </a>
      </li>
      <li>
        <a href="<?= $pager->getPrevious() ?>" aria-label="Halaman Sebelumnya"
           class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-600 hover:text-academic-navy border border-slate-200 font-medium transition flex items-center space-x-1"
           title="Halaman Sebelumnya">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          <span class="hidden sm:inline">Sebelumnya</span>
        </a>
      </li>
    <?php endif ?>

    <!-- Angka Halaman (1, 2, 3...) -->
    <?php foreach ($pager->links() as $link) : ?>
      <li>
        <?php if ($link['active']) : ?>
          <span aria-current="page"
                class="px-3 py-1.5 rounded-lg bg-academic-navy text-academic-gold font-bold border border-academic-gold/60 shadow-sm inline-block">
            <?= $link['title'] ?>
          </span>
        <?php else : ?>
          <a href="<?= $link['uri'] ?>"
             class="px-3 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-700 hover:text-academic-navy border border-slate-200 font-semibold transition inline-block">
            <?= $link['title'] ?>
          </a>
        <?php endif ?>
      </li>
    <?php endforeach ?>

    <!-- Tombol Selanjutnya & Terakhir -->
    <?php if ($pager->hasNext()) : ?>
      <li>
        <a href="<?= $pager->getNext() ?>" aria-label="Halaman Selanjutnya"
           class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-600 hover:text-academic-navy border border-slate-200 font-medium transition flex items-center space-x-1"
           title="Halaman Selanjutnya">
          <span class="hidden sm:inline">Berikutnya</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </li>
      <li>
        <a href="<?= $pager->getLast() ?>" aria-label="Halaman Terakhir"
           class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-600 hover:text-academic-navy border border-slate-200 font-medium transition flex items-center space-x-1"
           title="Halaman Terakhir">
          <span class="hidden sm:inline">Akhir</span>
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
        </a>
      </li>
    <?php endif ?>

  </ul>
</nav>
