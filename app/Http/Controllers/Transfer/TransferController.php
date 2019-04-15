<?php

namespace App\Http\Controllers\Transfer;

use App\Transfer;
use App\User;
use App\Http\Requests\SaveTransferReguest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Whoops\Exception\ErrorException;
use PHPUnit\Framework\Constraint\ExceptionMessage;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get user transfers

        //return view('');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transfers.create', [
            'users' => $this->getUsers(),
            'currentUser' => $this->getCurrentUser(),
            'minDate' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveTransferReguest $request)
    {
        $transfer = new Transfer();
        $transfer->message = '!test hardcore';
        $transfer->value = $request->value;
        $transfer->account_id_to = (new User())->getUserInfo($request->user)->account->id;
        $transfer->account_id_from = \Auth::user()->account->id;
        $transfer->status = 'planned';
        $transfer->plane_date = Carbon::createFromTimestamp(strtotime($request->plane_date));
        $transfer->uuid = uniqid();
        $transfer->save();

        $account = (new User())->getUserInfo(\Auth::user()->id)->account;
        $account->assumed_value = $account->assumed_value - $transfer->value;
        $account->save();

        return view('transfers.stored', ['status' => 1, 'transfer' => $transfer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        $this->checkAccesToTransfer($transfer);

        return view('transfers.show', ['transfer' => $transfer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        $this->checkAccesToTransfer($transfer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfer $transfer)
    {
        $this->checkAccesToTransfer($transfer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        $this->checkAccesToTransfer($transfer);
    }

    /**
     * get current user info
     *
     * @return \App\User
     */
    private function getCurrentUser(): \App\User
    {
        return \Auth::user();
    }

    /**
     * get users
     * 
     * return \Illuminate\Database\Eloquent\Collection
     */
    private function getUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return (new User())->getOtherUsers();
    }

    /**
     * Undocumented function
     *
     * @param Transfer $transfer
     * @return \Illuminate\Http\Response|void
     */
    public function checkAccesToTransfer(Transfer $transfer)
    {
        if ($transfer->accountOwner()->first()->user_id !== \Auth::user()->id) {
            $validator = \Validator::make($transfer->all()->toArray(), [
                'id' => [Rule::in($this->getCurrentUser()->with('transfers')->first()->transfers()->pluck('transfers.id')),]
            ]);

            $validator->errors()->add('id.in', 'Permission denied!');
            return Redirect::back()->withErrors($validator);
        }
    }
}
