<?php

namespace App\Http\Controllers;

use App\Models\Chatting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ChattingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        // print_r($request->all());
        // die;

       // return view('chatting');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function save(request $request )
    {
      // print_r($request->all());
        //    $user_id= Auth::user()->id;
        $user_id= $request->user_id;
        $validatedData = $request->validate([
            'chat' => 'required',

        ]);
        $users = [
        'message' => $request->chat,
        'user_id' => $user_id,
        'user_type' => 'user',
        'created_at' => date('Y-m-d H:i:s'),
        ];
        $rowDataQuery = DB::table('chattings')->insert($users);
        $responseData = ['status' => 1, 'message' => 'Message sent'];
        return response()->json($responseData, 200);
      // return redirect()->route('chatting.show')->with('success', 'Data inserted successfully');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function lists(Request $request)
    {
    //    $users = Chatting::leftjoin('users', 'users.id', '=', 'chattings.user_id')
    //    ->select('users.id', 'users.name', 'users.email', 'users.cpf_no', 'users.mobile', 'chattings.chat_id','chattings.user_id')
    //    ->groupBy('chattings.user_id')
    //    ->get();

        $usersid = Chatting::groupBy('user_id')->pluck('user_id');
        $users = User::whereIn('id', $usersid)->get();

        $data=[];
        $data['chat_list'] = $users;
        return view('chatting_list', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        {
            $chats = Chatting::where('user_type', 'user')->where('user_id', $id)->where('chat_resp_id',0)->get();
            $data=[];
            $data['chatting_list'] = $chats;
            return view('chatting', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chatting $chatting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chatting $chatting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chatting $chatting)
    {
        //
    }
}
