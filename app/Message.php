<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['archived_at', 'unarchived_at'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'sender_id', 'receiver_id', 'archived_by', 'archived_reason'];

    /**
     * archived reasons that can be unarchived
     *
     * @var array
     */
    public static $canBeUnarchivedReasons = ['reported_spam'];

    /**
     * Get all of the owning messageable models.
     */
    public function messageable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the message's replies.
     */
    public function replies()
    {
        return $this->hasMany('App\MessageReply');
    }

    /**
     * Get unread replies count with relation
     */
    public function unreadRepliesCount()
    {
        return $this->hasMany('App\MessageReply')
            ->where('is_read', false)
            ->where('sender_id', '!=' , Auth::user()->id)
            ->selectRaw('message_id, count(*) as count')
            ->groupBy('message_id');
    }

    /**
     * Get unread replies count
     */
    public function getUnreadRepliesCount(){

        if($this->unreadRepliesCount->count()) {
            return $this->unreadRepliesCount[0]->count;
        }

        return 0;
    }

    /**
     * Get message's sender.
     */
    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * Get message's receiver.
     */
    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    /**
     * Get other partner
     * @param null $userId the user id that will get his partner in message
     * @return object of partner
     */
    public function partner($userId = null)
    {
        // If no user id given then use the current authenticate user id
        if(!$userId){
            $userId = Auth::user()->id;
        }

        // If sender id equal to user id then the partner is the receiver
        if($this->sender_id == $userId){
            $partner =  $this->receiver;
        }
        // Else then the partner is the sender
        else{
            $partner = $this->sender;
        }

        // Return the partner
        return $partner;
    }

    /**
     * Get the last reply
     * @return object of partner
     */
    public function lastReply()
    {
        return $this->hasOne('App\MessageReply', 'id', 'last_reply_id');
    }

    /**
     * Get the last reply text
     * @return object of partner
     */
    public function lastReplyText()
    {
        return $this->lastReply?$this->lastReply->text:'';
    }

    /**
     * Get the last reply sender first name
     * @param bool $pronoun if true and last reply sender was the
     * current authenticated user we will use you instead of his name
     *
     * @return string first name of last reply sender
     */
    public function lastReplySenderFirstName($pronoun = false)
    {
        if(!$this->lastReply){
            return '';
        }

        // If pronoun equal true && last reply sender id equal to current
        // authenticated user id then we should return 'You' instead of first name
        if($pronoun && $this->lastReply->sender_id == Auth::user()->id){
            return 'You';
        }

        // Return last reply sender first name
        return  $this->lastReply->sender->nameOrEmail();
    }

    /**
     * Check if message can be unarchived
     * @return bool
     */
    public function canBeUnarchived(){
        if(in_array($this->archived_reason, self::$canBeUnarchivedReasons)){
            return true;
        }
        return false;
    }

    /**
     * Archive message
     *
     * @param $reason
     */
    public function archive($reason){
        $this->archived_by = Auth::user()->id;
        $this->archived_reason = $reason;
        $this->archived_at = Carbon::now();
        $this->unarchived_at = null;
        $this->save();
    }

    /**
     * unarchive message
     */
    public function unarchive(){
        $this->archived_by = null;
        $this->archived_reason = null;
        $this->archived_at = null;
        $this->unarchived_at = Carbon::now();
        $this->save();
    }


    /**
     * Get current user inbox details
     */
    public static function getInboxDetails(){

        // Get current user inbox
        return Message::with([
            'lastReply',
            'unreadRepliesCount',
            'messageable',
            'sender' => function($query){
                $query->select([
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'avatar_id'
                ])->with(['profile_avatar' => function($query){
                    $query->select([
                        'id',
                        'path'
                    ]);
                }]);
            }, 'receiver' => function($query){
                $query->select([
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'avatar_id'
                ])->with(['profile_avatar' => function($query){
                    $query->select([
                        'id',
                        'path'
                    ]);
                }]);
            }])
            ->where(function($query){
                $query->where('sender_id', Auth::user()->id)
                    ->orWhere('receiver_id', Auth::user()->id);
            })
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
