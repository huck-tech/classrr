<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Classroom;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        // Make sure the user is authenticated using auth middleware
        $this->middleware('auth');
    }

    /**
     * Show the messages
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get current user messages
        $messages = Message::getInboxDetails();

        // If request it ajax so we must prepare data and return it
        if($request->ajax()){

            foreach($messages as $message){
                $message->partner = $message->partner();
                $message->partner->name = $message->partner()->nameOrEmail();
                $message->partner->avatarPath = $message->partner()->getAvatarPath();
                $message->unreadRepliesCount = $message->getUnreadRepliesCount();
                $message->lastReplyText = $message->lastReplyText();
                $message->lastReplySenderFirstName = $message->lastReplySenderFirstName(true);
                $message->isReportedByCurrentUser = $message->messageble_type == 'booking'?$message->messageable->isReportedByCurrentUser():false;
            }
            return $messages;
        }

        // Return messages view
        return view('user.messages', compact('messages'));
    }

    /**
     * Show message
     *
     * @param $messageId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function show($messageId)
    {
        // Get Authenticated user id
        $authUserId = Auth::user()->id;

        // Get message
        $message = Message::where(function($query) use($authUserId){
                $query->where('sender_id', $authUserId)
                    ->orWhere('receiver_id', $authUserId);
            })
            ->find($messageId);


        // If message not found
        if(!$message){
            return redirect('/user/messages')->withErrors(['Message not found..!']);
        }

        // Get current message id
        $currentMessageId = $message?$message->id:null;

        // Get current user messages
        $messages = Message::getInboxDetails();

        // Return messages view
        return view('user.messages', compact('messages', 'currentMessageId'));
    }

    /**
     * Get a message replies
     *
     * @param Request $request
     * @param $messageId
     * @return \Illuminate\Http\Response
     * @internal param $roomId
     */
    public function repliesIndex(Request $request, $messageId)
    {
        // Get Authenticated user id
        $authUserId = Auth::user()->id;

        // Get message
        $message = Message::where(function($query) use($authUserId){
                $query->where('sender_id', $authUserId)
                    ->orWhere('receiver_id', $authUserId);
            })
            ->find($messageId);

        if($message) {

            // Set is_read to true
            $message->replies()->where('sender_id', '!=' , $authUserId)
                ->update([
                    'is_read'=> true
                ]);

            // Get message replies
            $replies = $message->replies();

            if ($lastReplyId = $request->get('last_reply_id')) {
                $replies = $replies->where('id', '>', $lastReplyId);
            }else{
                $replies = $replies->limit(20);
            }

            $replies = $replies->with('sender.profile_avatar')
                ->orderBy('id', 'desc')
                ->get();

            // Return replies
            return array_reverse($replies->toArray());
        }
    }

    /**
     * Get message previous replies
     *
     * @param $messageId
     * @param $firstReplyId
     * @return
     * @internal param $roomId
     */
    public function previousReplies($messageId, $firstReplyId)
    {
        // Get Authenticated user id
        $authUserId = Auth::user()->id;

        // Get message
        $message = Message::where(function($query) use($authUserId){
            $query->where('sender_id', $authUserId)
                ->orWhere('receiver_id', $authUserId);
        })
            ->find($messageId);

        if($message) {

            // Get message replies
            $replies = $message->replies()
                ->where('id', '<', $firstReplyId)
                ->limit(20)
                ->with('sender.profile_avatar')
                ->orderBy('id', 'desc')
                ->get();

            // Return replies
            return $replies;
        }
    }

    /**
     * Store message
     * @param Request $request
     * @param $messageId
     * @return
     */
    public function repliesStore(Request $request, $messageId)
    {
        // Validate message
        $this->validate($request, [
            'message' => 'required|min:1|max:2500'
        ]);

        // Get current user
        $authUserId = Auth::user()->id;

        // Get message
        $message = Message::where(function($query) use($authUserId){
                $query->where('sender_id', $authUserId)
                    ->orWhere('receiver_id', $authUserId);
            })
            ->where('archived_at', null)
            ->find($messageId);

        if($message) {

            // Create new reply for this message
            $message->replies()
                ->create([
                    'sender_id' => $authUserId,
                    'text' => $request->get('message')
                ]);

            // Get message replies
            $replies = $message->replies();

            // If last reply id given so we should get only the replies after it
            if ($lastReplyId = $request->get('last_reply_id')) {
                $replies = $replies->where('id', '>', $lastReplyId);
            }

            $replies = $replies->with('sender.profile_avatar')
                ->get();

            // Return replies
            return $replies;
        }
    }

    /**
     * Archive message
     * @param $messageId
     * @param $reason
     * @return MessagesController|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function archive($messageId, $reason)
    {
        // Get Authenticated user id
        $authUserId = Auth::user()->id;

        // Get message
        $message = Message::where(function($query) use($authUserId){
            $query->where('sender_id', $authUserId)
                ->orWhere('receiver_id', $authUserId);
        })
        ->find($messageId);


        // If message not found
        if(!$message){
            return redirect('/user/messages')->withErrors(['Message not found..!']);
        }

        // Check if message is archived already if archived already redirect with error
        if($message->archived_at){
            return redirect('/user/messages/' . $messageId)->withErrors(['Can not close this message as it has been closed already!']);
        }

        // Archive message
        $message->archive($reason);

        // Redirect to message with success message
        return redirect('/user/messages/'. $messageId)->with('status', 'Message have been reported as spam successfully');
    }

    /**
     * Unarchive message
     * @param $messageId
     * @return MessagesController|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unarchive($messageId)
    {
        // Get Authenticated user id
        $authUserId = Auth::user()->id;

        // Get message
        $message = Message::where(function($query) use($authUserId){
            $query->where('sender_id', $authUserId)
                ->orWhere('receiver_id', $authUserId);
        })
            ->find($messageId);

        // If message not found
        if(!$message){
            return redirect('/user/messages')->withErrors(['Message not found..!']);
        }

        // Check if message is archived by the current participant if not redirect him with error
        if($message->archived_by != $authUserId){
            return redirect('/user/messages/' . $messageId)->withErrors(['Can not reopen this message as it has been closed by the other participant!']);
        }

        // Check if message can be unarchived
        if(!$message->archived_at){
            return redirect('/user/messages/' . $messageId)->withErrors(['This message is already open!']);
        }

        // Check if message can be unarchived
        if(!$message->canBeUnarchived()){
            return redirect('/user/messages/' . $messageId)->withErrors(['This message cannot be unarchived!']);
        }

        // unarchive message
        $message->unarchive();

        // Redirect to message with success message
        return redirect('/user/messages/'.$messageId)->with('status', 'Message has been reopened successfully');
    }
}
