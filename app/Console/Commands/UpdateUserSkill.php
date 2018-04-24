<?php

namespace App\Console\Commands;

use App\Booking;
use App\Classroom;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUserSkill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user-skill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add point +1 for each of finished classroom by user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();       
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        /**
        * List IDs of ended classroom
        *
        * @var string
        **/
        $listEnded = $this->getEndedBookingToday();
        if(count($listEnded)) {
            $this->transferSkills($listEnded);
        }
    }

    /**
     * Transfer skill from classroom to users
     *     
     * Add 1 Point if skill exist.
     * Otherwise,set 1 Point and skill id
     *
     * Add History Log Each transfered Skill
     * History is column in table skill_distributions
     * 
     * @return void
     * @author 
     **/
    public function transferSkills($list = []) {    
        $bookingIds = collect(); 
        $plusPoint  = 1;  

        DB::beginTransaction();
        try {
            if(count($list)) {
                // Process Transfer Skills to each users
                list($usersIds, $value) = array_divide($list);            
                $users = User::with('skills')->find($usersIds);         
                 
                foreach($users as $user) {
                    $setKey = $user->id;
                    $selectUser = array_where($list, function($value, $index) use($setKey) {
                        return $index == $setKey;
                    });

                    $addSkills    = [];
                    $getSkills    = $user->skills->pluck('pivot.amount_point','id')->toArray();
                    $getSkillsIds = $user->skills->pluck('id')->toArray();       

                    // Array of  skill provided by classroom
                    $providedSkills = isset($selectUser[$setKey]['skills'])?$selectUser[$setKey]['skills']:[];
                    // Get item in booking list by user_id
                    $bookingId = $selectUser[$setKey]['booking_id'];

                    $getHistorySkill =  $user->skills->pluck('pivot.history_log','id')->toArray();

                    if(count($providedSkills)) {

                        foreach($providedSkills as $given) {                    
                            
                            if( in_array($given, $getSkillsIds )) {
                                $gainPoint = $getSkills[$given] + $plusPoint;
                                // $addSkills[ $given ] = ['amount_point' => $gainPoint];

                                /**
                                 * Log History of transfered skill
                                 */
                                if( isset($getHistorySkill[$given]) ) {
                                    $history = collect(json_decode($getHistorySkill[$given]));
                                    
                                    if(json_last_error() === JSON_ERROR_NONE) {                            
                                        $history->push([ 'booking' => [ $bookingId => $gainPoint] ]);
                                        $addSkills[$given] = ['history_log' => $history->toJson(), 'amount_point' => $gainPoint];
                                    } else {
                                        throw new \Exception("History Booking Class Point couldn't be added", 1);
                                    }
                                    // Log::info('exist history');
                                } else {
                                    $history = collect(); 
                                    $history->push([ 'booking' =>  [ $bookingId => $gainPoint] ]);
                                    $addSkills[$given] = ['history_log' => $history->toJson(), 'amount_point' => $gainPoint];
                                }

                            } else {
                                /**
                                 * Add New Skill to user
                                 */
                                $addSkills[ $given ] = ['amount_point' => $plusPoint];
                                $history = collect(); 
                                $history->push([ 'booking' =>  [ $bookingId => $plusPoint] ]);

                                $addSkills[$given] = ['history_log' => $history->toJson(), 'amount_point' => $plusPoint];
                                // Log::info('new history');
                            }

                        }
                    }
                    
                    $user->skills()->sync($addSkills, false);
                    $bookingIds->push($bookingId);
                }
                
                $skillTransfered = Booking::whereIn('id', $bookingIds->toArray())->update(['transfer_skill' => 1]);
                if(!$skillTransfered) {
                    throw new \Exception('Failed to transfer');
                }
             }   
        } catch(\Exception $e) {         
            Log::error($e);   
            DB::rollback();
            return false;
        }    
        DB::commit();
        return true;        
    }
  
    /**
     * Get All Booking that end today
     * 30/90 days from start_date of bookings
     *
     * @return Array|Collection
     * @author 
     **/
    public function getEndedBookingToday()
    {        
        $list       = [];        
        $now        = Carbon::now();    

        // Because using between aggregate, date must add or sub with 1 day
        $previousMonth = $now->copy()->subDays(29); 
        $earlierMonth  = $now->copy()->subDays(91); 

        $bookings = Booking::where('payment_status', 'completed')
                        ->with(['student', 'classroom.skills','classroom.duration'])->where('transfer_skill', 0)
                        ->whereBetween('start_date', [$earlierMonth, $previousMonth])
                        ->get();        

        if($bookings) {
            foreach($bookings as $book) {
                $duration = (int) $book->classroom->duration->days;
                $ended    = $book->begin_date->addDays($duration);
                if($now->isSameDay($ended)) {
                    $skills = $book->classroom->skills->pluck('id')->toArray();
                    // Log::info($skills);
                    if(count($skills)) {                    
                        $list[ $book->student_id ] = ['skills' => $skills, 'booking_id' => $book->id ];                 
                    }
                }
            }        
        }
        // Log::info($list);
        return $list;
    }

}
