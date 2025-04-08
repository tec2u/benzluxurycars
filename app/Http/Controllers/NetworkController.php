<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
    public function index()
    {
        $networkFirst = Network::with('user')->where('user_id', auth()->user()->id)->first();

        $network = [
            [
                'id' => $networkFirst->id,
                'upline_id' => $networkFirst->upline_id,
                'name' => $networkFirst->user->name,
                'img' => $networkFirst->user->avatar
            ]
        ];

        $network = array_merge($network, $this->network($networkFirst->id));

        $network = json_encode($network);
        return view('network.index', compact('network'));
    }

    private function network($id = 0)
    {
        $network = [];
        $netsBelow = Network::with('user')->where('upline_id', $id)->get();
        foreach ($netsBelow as $netBelow) {
            $network[] = [
                'id' => $netBelow->id,
                'pid' => $netBelow->upline_id,
                'name' => $netBelow->user->name,
                'img' => $netBelow->user->avatar
            ];
            $network = array_merge($network, $this->network($netBelow->id));
        }
        return $network;
    }
}
