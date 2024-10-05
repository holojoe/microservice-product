<?php

namespace App\Listeners;

use App\Events\ProductEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CategoryComsumerListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductEvent $event)
    {
        //

        $config = config('services.catservice.url');

        $product = $event->product;
        $product->slug =  str($product->name)->slug('-');
        $product->save();
        $url = $config . '/api/v1/categories/comsummer';
        $data['product_id'] = $product->id;
        $data['category_id'] = $product->category_id;
        $data['type'] = $event->type;
        $response = Http::post($url, $data);
        Log::info("message", [$response]);
        if ($response->successful()) {
            Log::info("message",  [$response]);
        }

        return $response;
    }
    // public function shouldQueue(ProductEvent $event): bool
    // {
    //     return $event->product;
    // }
}
