<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Integer;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [];

    /**
     * Accounts relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('\App\Account');
    }

    /**
     * Transfers relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function transfers(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough('\App\Transfer', '\App\Account', 'user_id', 'account_id_from', 'id', 'id');
    }

    /**
     * get Users without current
     *
     * @return Collection
     */
    public function getOtherUsers(): Collection
    {
        return $this->with('account')->where('id', '<>', \Auth::user()->id)->get();
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return \App\User
     */
    public function getUserInfo(int $id): \App\User
    {
        // return $this->whereId($id)->with('account')->first();
        return $this->find(id)->with('account')->first();
    }

    /**
     * Undocumented function
     *
     * @return \App\User
     */
    public static function getCurrentUser(): \App\User
    {
        return self::find(\Auth::user()->id);
    }
}
