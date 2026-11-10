<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Dilempar di dalam transaksi checkout agar transaksi di-rollback
 * (misalnya stok tidak cukup atau varian tidak valid). Pesannya
 * ditampilkan ke pengguna sebagai flash error.
 */
class CheckoutException extends RuntimeException {}
