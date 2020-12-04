<?php


namespace App\Models;


use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartSession
{
    public $sessionName = 'cart';

    /** @var Collection */
    protected $items;

    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * @param $session mixed
     */
    public function from($session)
    {
        if (is_array($session)) {
            $this->items = collect($session);
        }

        return $this;
    }

    /**
     * Save the collection into session.
     */
    protected function save()
    {
        Session::put($this->sessionName, $this->items->all());
    }

    /**
     * @param Product $product
     * @param $quantity
     * @return $this
     */
    public function add(Product $product, $quantity)
    {
        if ($index = $this->findKey($product->id)) {
            $this->update($product, $quantity);
        } else {
            $this->items->push(['product' => $product, 'product_id' => $product->id, 'quantity' => $quantity, 'price' => $product->price, 'total_price' => $product->price * $quantity]);
        }

        $this->save();

        return $this;
    }

    public function update(Product $product, $quantity)
    {
        $index = $this->findKey($product->id);
        if ($index !== null && $index !== false) {
            $exProduct = $this->items->get($index);
            $exProduct['quantity'] = $quantity;
            $exProduct['total_price'] = $product['price'] * $quantity;
            $this->items = $this->items->replace([$index => $exProduct]);
            $this->save();
        }
    }

    public function remove($productId)
    {
        $this->items->forget($this->findKey($productId));

        $this->save();

        return $this;
    }

    /**
     * @param $productId
     * @return int|null
     */
    protected function findKey($productId)
    {
        if ($this->items->isEmpty()) {
            return null;
        }

        return $this->items->search(function ($item) use ($productId) {
            return $item['product_id'] === $productId;
        });
    }

    public function all()
    {
        return $this->items->map(function ($item) {
            return (object) $item;
        })->toArray();
    }

    public function ppn()
    {
        return $this->subTotal() * 0.1;
    }

    public function ppnAsIDR()
    {
        return $this->asIDR($this->ppn());
    }

    public function subTotal()
    {
        return $this->items->sum(function ($item) {
            return $item['total_price'];
        });
    }

    public function subTotalAsIDR()
    {
        return $this->asIDR($this->subTotal());
    }

    public function grandTotal()
    {
        return $this->subTotal() + $this->ppn();
    }

    public function grandTotalAsIDR()
    {
        return $this->asIDR($this->grandTotal());
    }

    public function asIDR($number)
    {
        return 'Rp. '.number_format($number, 0, ',','.');
    }

}
