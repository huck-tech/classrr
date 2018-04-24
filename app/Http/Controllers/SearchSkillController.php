<?php

namespace App\Http\Controllers;

use App\Skill;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchSkillController extends Controller
{    
    /**     
     * @author 
     **/
    public function __construct()
    {        
        
    }
    /**
     * Display all skills for classroom,
     * Only Skill which user has reach max can be shown
     * 
     * Zero, means IN ALL CATEGORIES
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Skill $model)
    {                
        $keyword  = $request->input('keyword');
        $category = (int) $request->input('category', 0);         

        $skills = $this->allMaxSkills();
        $ids    = $skills->pluck('skill_id');

        $groupedSkills = $skills->groupBy('category_id');        

        if(!$request->has('keyword'))  {
            $api =  Skill::whereIn('id', $ids)->paginate(15);    
            return response()->json($api, 200);
        }   
        
        $skillsFilter = [];        
        $model        = $model->newQuery();
        $inCategory   = [0];

        if($keyword !== '') {
            $model->where('name', 'LIKE', "%{$keyword}%");
        }

        if($category > 0) {
            // $groupCategory = $groupedSkills->keys()->toArray();
            $inCategory = array_merge($inCategory, [$category]);
            // if(in_array($category, $groupCategory)) {
            //     $classSkills = $groupCategory[$category];

            //     foreach ($$classSkills as $key => $value) {
            //         $idSkill = $value['skill_id'];
            //         $skillsFilter = array_merge($skillsFilter, [$idSkill]);
            //     }
            // }
        }
        
        $api = $model->whereIn('id', $ids)->whereIn('category_id', $inCategory)->paginate(15);
        return response()->json($api, 200);                
    }

    /**
     * Get All Max Skills
     *
     * @return Illuminate\Support\Collection
     * @author 
     **/
    public function allMaxSkills()
    { 
        $skills = collect();
        // Get all skill that user has mastered
        $getSkills = auth()->user()->skills;

        if(count($getSkills)) {
            foreach($getSkills as $skill) {
                $id            = $skill->id;
                $point         = $skill->pivot->amount_point;
                $skillCategory = $skill->category_id;

                if(is_max_level($point, $skill->max_level)) {                    
                    $skills = $skills->push([ 'skill_id' => $id, 'category_id' => $skillCategory]);  
                }
            }
        }   
        return $skills;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function get()
    {
    }
}
