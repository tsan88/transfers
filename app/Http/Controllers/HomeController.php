<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use App\Transfer;
use App\Account;
use Illuminate\Support\Collection as IlluminateCollection;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): \Illuminate\Contracts\Support\Renderable
    {
        return view('home', $this->getDashboardData());
    }

    private function getDashboardData(): array
    {
        return [
            'all_user_transfers' => $this->getOneTransferByEachUser(),
            'transfers' => $this->getUserTransfers()
        ];
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Support\Collection
     */
    public function getOneTransferByEachUser(): \Illuminate\Support\Collection
    {
        return collect($this->getOneTransferByEachAccounts())->map(function($transfer) {
            return collect($transfer)->merge(
                [
                    'user' => \App\Account::whereId($transfer->account_id_from)->with('user')->first()->user
                ]
            );
        });
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getOneTransferByEachAccounts(): array
    {
        // select * from `transfers` tr
        // where 
        // 	tr.`id`= (SELECT max(`transfers`.`id`) FROM `transfers` WHERE `transfers`.`account_id_from`=tr.account_id_from )
        return \DB::table('transfers as tr')
            ->whereRaw('tr.id=(SELECT max(`transfers`.`id`) FROM `transfers` WHERE `transfers`.`account_id_from`=tr.account_id_from )')
            ->get();
    }

    /**
     * get user transfers
     * 
     * return Collection
     */
    private function getUserTransfers($limit = null): Collection
    {
        return User::whereId(\Auth::user()->id)->orderByDesc('created_at')->limit($limit)->with('transfers')->first()->transfers;
    }
}
