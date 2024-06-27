<?php

namespace Nusagates\Laraipaymu\Models;
/**
 * @author Cak Bud <budairi@leap.id>
 */
class Buyer
{
    public $name, $email, $phone;

    public function __construct($name, $email, $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function toArray(): array
    {
        return ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone];
    }
}