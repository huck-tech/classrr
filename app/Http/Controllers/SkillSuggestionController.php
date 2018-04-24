<?php

namespace App\Http\Controllers;

use App\SkillSuggestion;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SkillSuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            if(!auth()->check()) { 
                throw new HttpException(403, "You must log in to access this page.");
            }
            
            $input = [
                'user_id' => auth()->user()->id,
                'skill_name' => $request->input('skill_name'),
            ];
            
            SkillSuggestion::create($input);
        } catch(\Exception $e) {
            if($e instanceof HttpException) {
                return response(['error' => $e->getMessage(), $e->getCode()]);
            }
            return response(['error' => 'Failed to store skill suggestion', 400]);
        }
        return response(['message' => 'Your suggestion has been sent successfully', 200]);
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
