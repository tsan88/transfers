<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message', 'value', 'account_id_to', 'account_id_from', 'plane_date', 'status', 'uuid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'decimal:2',
        'account_id_to' => 'float',
        'account_id_from' => 'float',
        'message' => 'string',
        'uuid' => 'uuid',
        'status' => 'string'
    ];

    //protected $dates = ['plane_date'];

    /**
     * Relation owner account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountOwner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('\App\Account', 'account_id_from');
    }

    /**
     * Relation recipient account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipient(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne('\App\Account', 'account_id_to');
    }
}
