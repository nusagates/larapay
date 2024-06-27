<?php

namespace Nusagates\Laraipaymu\Models;
/**
 * @author Cak Bud <budairi@leap.id>
 */
class Product
{
    public array $items = [];
    public $id, $description, $weight, $length, $width, $height;
    public string $name;
    public float $price;
    public int $quantity;

    public function addItem($id, $name, $price, $quantity, $description = null, $weight = 0, $length = 0, $width = 0, $height = 0): void
    {

        $this->items[] = [
            'id'          => $id,
            'product'     => trim($name),
            'price'       => $price,
            'quantity'    => $quantity,
            'description' => trim($description),
            'weight'      => $weight,
            'length'      => $length,
            'width'       => $width,
            'height'      => $height
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
        $productsDesc = [];
        $productsWeight = [];
        $productsDimension = [];
        $productsLength = [];
        $productsWidth = [];
        $productsHeight = [];
        foreach ($this->items as $item) {
            $productsName[] = $item['product'];
            $productsPrice[] = $item['price'];
            $productsQty[] = $item['quantity'];
            $productsDesc[] = $item['description']??null;
            $productsWeight[] = $item['weight'];
            $productsLength[] = $item['length'];
            $productsWidth[] = $item['width'];
            $productsHeight[] = $item['height'];
            if (!($item['length'] == null || $item['width'] == null || $item['height'] == null)) {
                $productsDimension[] = $item['length'] . ':' . $item['width'] . ':' . $item['height'];
            }
        }
        $items['product'] = $productsName;
        $items['qty'] = $productsQty;
        $items['price'] = $productsPrice;

        return $items;

    }

    public function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        return $subtotal;
    }

}