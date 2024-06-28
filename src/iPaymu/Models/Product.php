<?php

namespace Nusagates\Larapay\iPaymu\Models;
/**
 * @author Cak Bud <budairi@leap.id>
 */
class Product
{
    public array $items = [];

    /**
     * Add new item to the product collections
     * @param $id
     * @param $name
     * @param $price
     * @param $quantity
     * @param $description
     * @param $weight
     * @param $length
     * @param $width
     * @param $height
     * @return void
     */
    public function addItem($id, $name, $price, $quantity): void
    {

        $this->items[] = [
            'id'          => $id,
            'product'     => trim($name),
            'price'       => $price,
            'quantity'    => $quantity
        ];
    }

    /**
     * collections of product items
     * @return array
     */
    public function getItems(): array
    {
        $productsName = [];
        $productsPrice = [];
        $productsQty = [];
        foreach ($this->items as $item) {
            $productsName[] = $item['product'];
            $productsPrice[] = $item['price'];
            $productsQty[] = $item['quantity'];
        }
        $items['product'] = $productsName;
        $items['qty'] = $productsQty;
        $items['price'] = $productsPrice;

        return $items;
    }

    /**
     * get the total price of all added items
     * @return float
     */
    public function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

}