<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreClassroom extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all = $this->all();
        // Log::info($all);
        $rules = [
            'id'                  => 'filled|integer',
            'title'               => 'required|min:25|max:40|regex:/([A-Za-z0-9 ])+/',
            'category_id'         => 'required|integer|exists:categories,id',
            'level_id'            => 'required|integer|exists:classroom_levels,id',
            'description'         => 'required|min:100|max:5000',
            'number_student'      => 'required|numeric|between:1,6',
            'country_id'          => 'required|integer|exists:countries,id',
            'address_1'           => 'required|min:2',
            'address_2'           => 'present',
            'state'               => 'present',
            'zip_code'            => 'present',
            'city'                => 'required|min:2',
            'lat'                 => 'required|numeric',
            'lng'                 => 'required|numeric',
            'location_comments'   => 'required|min:50|max:1000',
            'pricing'             => 'required|in:fixed,flexible|no_js_validation',
            'base_price_fixed'    => 'required_if:price,fixed|no_js_validation',
            'base_price_flexible' => 'required_if:price,flexible|no_js_validation',
            'price_morning'       => 'present',
            'price_afternoon'     => 'present',
            'price_evening'       => 'present',
            'price_weekend'       => 'present',
            //'add_weekend_fee'     => 'filled',
            //'late_signup'         => 'filled',
            'duration_id'         => 'required|integer',
            'enrollment_date'     => 'required|date_format:"'.config('app.dateformat_php') .'"',
            'schedule_json'       => 'required|json',
            'schedule'            => 'required|no_js_validation', // Custom Validation | Check if at least one checkbox is present
            'cancellation_policy' => 'required|integer',
            //'is_guaranteed'       => 'filled',
            //'is_international'    => 'filled',
            'language'            => 'present',
            'age_range'           => 'present',
            //'advanced_booking'    => 'filled',
            'associated_tutors'   => 'present',
            'rules'               => 'present',
            'photos_ids'          => 'required_without:id|array',
            'photos_ids.*'        => 'numeric',
            //'curriculum_later'    => 'filled',
            //'remove_lecture'      => 'filled',

            'lowest_hour'  => 'required|integer|min:1',
            'median_hour'  => 'required|numeric|min:1',
            'highest_hour' => 'required|integer|min:1',

            'lecture'               => 'required_unless:curriculum_later,1|no_js_validation',
            'lecture.*.order'       => 'required_unless:curriculum_later,1|integer|no_js_validation',
            // 'lecture.*.duration' => 'required_unless:curriculum_later,1|integer|no_js_validation',
            'lecture.*.title'       => 'required_unless:curriculum_later,1|min:3|no_js_validation',
            // 'skills'                => 'required',
        ];

        // run only if curriculum later not checked
        if($this->request->get('curriculum_later') !== 1) {
            $lowest_hour  = $this->request->get('lowest_hour') * 60;
            $highest_hour = $this->request->get('highest_hour') * 60;
            $median_hour  = $this->request->get('median_hour') * 60;                   
            
            $rules['total_hours'] = ["required","integer","min:{$lowest_hour}","max:{$highest_hour}"]; 
        }
        
        return $rules;
    }

    /**
     * Custom Message
     *
     * @return array
     * @author 
     **/
    public function messages()
    {
        $messages = [
            'lowest_hour.min' => 'Set the duration and schedule first',
            'median_hour.min' => 'Set the duration and schedule first',
            'highest_hour.min' => 'Set the duration and schedule first',
            'total_hours.between' => "The :attribute value must be minimum :min minutes and maximum :max minutes",
        ];

        $first_lecture    = '';

          // run only if curriculum later not checked
        if($this->request->get('curriculum_later') !== 1) {
            $lowest_hour = $this->request->get('lowest_hour') * 60;
            $highest_hour = $this->request->get('highest_hour') * 60;
            $median_hour = round($this->request->get('median_hour')) * 60;

            $lecture       = $this->request->get('lecture');
            $first_lecture = '';

            if(is_array($lecture)) {                
                foreach( $lecture as $key => $value) {  
                    if($first_lecture == '') {
                        $first_lecture  = $key;
                    }                  
                    $messages["lecture.".$first_lecture.".duration.min"] = "The lecture minimum minutes should be " . $lowest_hour . " minutes";
                    $messages["lecture.".$first_lecture.".duration.max"] = "The lecture maximum minutes should be " . $highest_hour . " minutes";
                }
            }
        }

        return $messages;
    }

    /**
     * Get all input
     *
     * @return array
     * @author 
     **/
    public function all()
    {
        $attributes = parent::all();
        
        if(!$this->request->has('add_weekend_fee')) {
            $attributes['add_weekend_fee'] = 0;
        }

        if(!$this->request->has('is_guaranteed')) {
            $attributes['is_guaranteed'] = 0;
        }

        if(!$this->request->has('is_international')) {
            $attributes['is_international'] = 0;
        }

        if(!$this->request->has('late_signup')) {
            $attributes['late_signup'] = 0;
        }

        // Total hours of lecture
        $lecture          = $this->request->get('lecture');
        $first_lecture    = null;
        $total_curriculum = 0;
        if( is_array($lecture) AND count($lecture) > 0) {
            foreach( $lecture as $key => $value) { 
                if(is_null($first_lecture)) {
                    $first_lecture  = $key;
                }
                $total_curriculum+= $value['duration'];  
            }
        }     

        $attributes['total_hours'] = $total_curriculum;
        
        return $attributes;
    }
}
