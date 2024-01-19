<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\ConferenceCategory;



class ConferenceCategoryController extends BaseController
{
    public function index()
    {


        $ConferenceCategorys = ConferenceCategory::paginate(10);
        if ($ConferenceCategorys) {
            return $this->sendResponse($ConferenceCategorys, 'ConferenceCategorys retrieved successfully');
        } else {
            // Handle case when ConferenceCategory with given ID is not found
            return $this->sendError('ConferenceCategory not found', 404);
        }
    }

    public function show($id)
    {

        $ConferenceCategory = ConferenceCategory::find($id);
        if ($ConferenceCategory) {
            return $this->sendResponse($ConferenceCategory, 'ConferenceCategorys retrieved successfully');
        } else {
            // Handle case when ConferenceCategory with given ID is not found
            return $this->sendError('ConferenceCategory not found', 404);
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        // Validate incoming data and create a new applicant
        $validator = Validator::make($request->all(), [

            'name'  => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ConferenceCategory = ConferenceCategory::create($input);

        return $this->sendResponse($ConferenceCategory, 'Applied successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'name'  => 'required',


        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();


        $ConferenceCategory = ConferenceCategory::find($id);


        if ($ConferenceCategory) {
            $ConferenceCategory->update($input);
            // Other operations or return statements as needed
            return $this->sendResponse($ConferenceCategory, 'Updated successfully');
        } else {
            // Handle case when ConferenceCategory with given ID is not found
            return $this->sendError('ConferenceCategory not found', 404);
        }
    }

    public function destroy($id)
    {
        // Find the applicant and delete it
        $ConferenceCategory = ConferenceCategory::find($id);
        // dd($ConferenceCategory);
        if ($ConferenceCategory) {
            $ConferenceCategory->delete();
            return $this->sendResponse('Deleted successfully', 200);
        } else {
            // Handle case when ConferenceCategory with given ID is not found
            return $this->sendError('ConferenceCategory not found', 404);
        }
    }
}
