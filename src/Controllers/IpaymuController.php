<?php

namespace Nusagates\Larapay\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Nusagates\Larapay\Vendors\iPaymu\Ipaymu;

/**
 * @author Cak Bud <budairi@leap.id>
 */
class IpaymuController
{
    public $ipaymu, $vaNumber, $apiKey, $user;

    public function __construct()
    {
        $this->vaNumber = env('IPAYMU_VA');
        $this->apiKey = env('IPAYMU_KEY');
        $this->ipaymu = new Ipaymu($this->vaNumber, $this->apiKey);
        $this->user = Auth::user();
    }


    public function index(Request $request)
    {
        if ($request->filled('balance')) {
            $response = $this->ipaymu->getBalance($this->user->va_number);
            if($response['Success']){
                $this->user->update([
                    'merchant_balance' => $response['Data']['MerchantBalance'],
                ]);
            }
            return $response;
        }
        if ($request->filled('history')) {
            return $this->ipaymu->getHistory($this->user->va_number);
        }
        //return $this->ipaymu->register('Hadia', 'ehla.hadia@gmail.com', '08123456789', '12345678');

        return Inertia::render('Larapay/Dashboard');
    }

    // buatkan fungsi register yang berisi nama, email, phone, dan password
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'phone'    => 'required',
            'password' => 'required'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password = $request->input('password');

        $response = $this->ipaymu->register($name, $email, $phone, $password);
        if ($response['Status'] == 200) {
            Auth::user()->update([
                'va_number' => $response['Data']['Va']
            ]);
        }
        return redirect()->back()->with('message', $response);
    }

}