<?php

namespace App\Http\Controllers;

use App\Coin;
use Illuminate\Http\Request;

class BitcoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupItemsCount = 5;

        $columns = Coin::groupBy('currency')->select('currency')->get()->sort(function($column) {
            return $column->currency;
        });

        $itemsPerPage = $columns->count() * $groupItemsCount;

        $coins = Coin::orderBy('created_at')
            ->paginate($itemsPerPage);

        $result = [];
        $count = 0;

        for($i = 0; $i < $groupItemsCount; $i++){

            for($k = 0; $k < $columns->count(); $k++)
            {
                $item = $coins[$count];
                $result[] = ['currency' => $item->currency, 'exchange_rate' => $item->exchange_rate, 'time' => $item->created_at, 'group' => $i];
                $count++;
            }

        }

        $result = collect($result)->sortBy(function($coin) {
            return $coin['currency'];
        })->groupBy('group');

        return view('bitcoin.index', ['bitcoins' => $coins, 'result' => $result, 'columns' => $columns]);
    }

}
