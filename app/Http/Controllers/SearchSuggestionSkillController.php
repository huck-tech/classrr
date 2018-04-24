<?php

namespace App\Http\Controllers;

use App\Skill;
use App\SkillDistribution;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SearchSuggestionSkillController extends Controller
{
    /**
     * Get 5 skills that users have been interested in 
     *
     * LIMIT 5
     * NEED at least one account that has had skills for counting reference
     * @return Illuminate\Database\Eloquent\Builder
     * @author 
     **/
    public function index(Request $request, Skill $model)
    {     
        $model    = $model->newQuery();
        $keyword  = $request->input('keyword');  
        $category = $request->input('category', 0);         
        $isSearch = $request->input('is_search', 0);
        $api      = '';
                    
        try {
            $popularSkill = SkillDistribution::selectRaw(DB::raw('*, count(skill_id) as interest_skills'))
                        ->groupBy('skill_id')
                        ->orderBy('interest_skills', 'DESC')
                        ->with('skill')
                        ->firstOrFail();

            if($request->has('keyword') AND $keyword != '') {            
                $model->where('name', 'LIKE', '%'.$keyword.'%');
            }

            if(!$isSearch) {
                $api = $model->where('category_id', $popularSkill->skill->category_id)->paginate(6);            
            } else {
                $api = $model->paginate(6);
            }
        } catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        return response()->json($api, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store Additional Point for user profile 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {                

        try {
            $user = auth()->user();        
            if(! $user) throw new HttpException(403, 'You must log in to do this action');   

            $getUser        = User::with('skills')->where('id', $user->id)->firstOrFail();
            $getSkills      = $getUser->skills->pluck('pivot.amount_point','id')->toArray();  
            $getSkillsMaxLevel = $getUser->skills->pluck('max_level','id')->toArray();  
            $getSkillsIds   = $getUser->skills->pluck('id')->toArray(); 

            $getHistorySkill =  $getUser->skills->pluck('pivot.history_log','id')->toArray();            
            $remainingPoint = $getUser->skill_points;
            
            $formSkills     = $request->input('skills', []);            
            $skills         = [];
            $totalPoint     = 0;        

            if(is_array($formSkills)) {
                foreach ($formSkills as $key => $value) {
                    $id    = $value['id'];
                    $point = $value['gain_point'];
                    $originPoint = 0;

                    if(in_array($id, $getSkillsIds)) {
                        $originPoint =  $getSkills[$id];
                    }                     

                    $sumPoint    = $point + $originPoint;                    
                    $totalPoint  = $totalPoint + $point;


                    // Checking if history of gaining point is exist
                    if( isset($getHistorySkill[$id]) ) {
                        $history = collect(json_decode($getHistorySkill[$id]));
                        
                        if(json_last_error() === JSON_ERROR_NONE) {                            
                            $history->push([ 'skill_point' => $sumPoint]);
                            $skills[$id] = ['history_log' => $history->toJson(), 'amount_point' => $sumPoint];

                        } else {
                            throw new \Exception("History Skill Point couldn't be added", 1);                            
                        }
                    } else {
                        $history = collect(); 
                        $history->push([ 'skill_point' => $sumPoint]);
                        $skills[$id] = ['history_log' => $history->toJson(), 'amount_point' => $sumPoint];
                    }


                }
            }
                    
            if(count($skills)) {
                $store                 = $getUser->skills()->sync($skills, false);

                $decrementPoint        = $remainingPoint - $totalPoint;
                $getUser->skill_points = $decrementPoint > 0 ? $decrementPoint : 0;
                $getUser->save();            
            }            
        } catch (\Exception $e) {            
            return response()->json(['error' => $e->getMessage()], 400);
        }
        session()->flash('status', 'Skill has been added');
        return response()->json(['message' => 'Skill has been added'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
