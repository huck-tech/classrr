<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sender_id', 'text'];

    /**
     * Get reply's sender.
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['message'];

    /**
     * Get the message that the reply belongs to.
     */
    public function message()
    {
        return $this->belongsTo('App\Message');
    }

}
