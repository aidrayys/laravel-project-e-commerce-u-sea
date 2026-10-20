<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'address',
        'city',
        'subtotal',
        'shipping',
        'discount_total',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'shipping' => 'integer',
            'discount_total' => 'integer',
            'total' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function trackingEvents(): HasMany
    {
        return $this->hasMany(OrderTrackingEvent::class)->orderBy('event_at');
    }

    public function getOrderNumberAttribute(): string
    {
        return '#USEA-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Generate synthetic tracking events for the current order status.
     * This is used for demo/seed purposes and when no external courier API is available.
     *
     * @param  \Carbon\CarbonInterface|null  $baseTime
     */
    public function generateTrackingEvents($baseTime = null): void
    {
        $baseTime ??= $this->created_at ?? now();

        // Clear existing events to avoid duplicates
        $this->trackingEvents()->delete();

        $events = [
            [
                'status' => $this->status,
                'title' => 'Pesanan dibuat',
                'description' => 'Pesanan berhasil dibuat dan menunggu konfirmasi.',
                'offset' => 0,
            ],
            [
                'status' => $this->status,
                'title' => 'Pesanan dikonfirmasi',
                'description' => 'Pembayaran telah dikonfirmasi, pesanan akan diproses.',
                'offset' => 30,
            ],
            [
                'status' => $this->status,
                'title' => 'Pesanan diproses',
                'description' => 'Pesanan sedang diproses oleh penjual.',
                'offset' => 60,
            ],
            [
                'status' => $this->status,
                'title' => 'Pesanan dikemas',
                'description' => 'Pesanan sedang dikemas dan siap diserahkan ke kurir.',
                'offset' => 90,
            ],
        ];

        if (in_array($this->status, ['Shipped', 'Delivered', 'Completed'], true)) {
            $events[] = [
                'status' => $this->status,
                'title' => 'Paket diserahkan kepada kurir',
                'description' => 'Paket telah diserahkan kepada kurir dan sedang dalam perjalanan.',
                'offset' => 120,
            ];
            $events[] = [
                'status' => $this->status,
                'title' => 'Paket dalam perjalanan',
                'description' => 'Paket sedang dalam perjalanan ke kota tujuan.',
                'offset' => 180,
            ];
            $events[] = [
                'status' => $this->status,
                'title' => 'Paket tiba di lokasi transit',
                'description' => 'Paket telah tiba di lokasi transit terdekat.',
                'offset' => 240,
            ];
        }

        if (in_array($this->status, ['Delivered', 'Completed'], true)) {
            $events[] = [
                'status' => $this->status,
                'title' => 'Paket sedang diantar',
                'description' => 'Kurir sedang mengantarkan paket ke alamat tujuan.',
                'offset' => 300,
            ];
            $events[] = [
                'status' => $this->status,
                'title' => 'Paket tiba di alamat tujuan',
                'description' => 'Paket telah tiba di alamat tujuan.',
                'offset' => 360,
            ];
            $events[] = [
                'status' => $this->status,
                'title' => 'Pesanan diterima customer',
                'description' => 'Paket telah diterima oleh customer.',
                'offset' => 400,
            ];
        }

        if ($this->status === 'Completed') {
            $events[] = [
                'status' => $this->status,
                'title' => 'Pesanan selesai',
                'description' => 'Pesanan telah selesai. Terima kasih telah berbelanja di U-Sea.',
                'offset' => 480,
            ];
        }

        foreach ($events as $event) {
            $this->trackingEvents()->create([
                'status' => $event['status'],
                'title' => $event['title'],
                'description' => $event['description'],
                'event_at' => $baseTime->copy()->addMinutes($event['offset']),
            ]);
        }
    }
}
