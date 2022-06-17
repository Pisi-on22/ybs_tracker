<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSignUp;
use Validator;
use Exception;

class UserSignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "success"=> true,
            "statusCode"=>200,
            "data"=> UserSignUp::all()
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->only(['username','email','password','comfirm_password']);

        $validator = Validator::make($input, [
            'username' => 'required',
            'email' => 'required|unique:user_sign_ups',
            'password' => 'min:6',
            'comfirm_password' => 'required_with:password|same:password|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'statusCode' => 400,
                'errors' => $validator->errors()->first()
            ],400);
        }

        try{
            $newUser = UserSignUp::create($input);

            return response()->json([
                'success' => true,
                'statusCode' => 201,
                'data' => $newUser
            ],201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'errors' => 'Unknown Error'
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserSignUpRequest  $request
     * @param  \App\Models\UserSignUp  $userSignUp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSignUp $userSignUp)
    {
        $id = $request->id;
        $user = UserSignUp::find($id);


        if($user === null){
            return response()->json([
                "success" => false,
                "statusCode" => 404,
                "errors" => "Resource not found"
            ],404);
        }

        $input = $request->only(['username','email','password','comfirm_password']);

        if(isset($input['email'])){
            $validator = Validator::make($input,[
                'email' => 'unique:user_sign_ups'
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'statusCode' => 400,
                    'errors' => $validator->errors()->first()
                ],400);
            }
        }

        $user->username = isset($input['username']) ? $input['username']: $user->username;
        $user->email = isset($input['email']) ? $input['email']: $user->email;
        $user->password = isset($input['password']) ? $input['password']: $user->password;
        $user->comfirm_password = isset($input['comfirm_password']) ? $input['comfirm_password']: $user->comfirm_password;

        $user->save();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'data' => $user
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSignUp  $userSignUp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $user = UserSignUp::find($id);

        if($user === null){
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'errors' => "Resource not found"
            ],404);
        }

        try{
            $user->delete();
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'errors' => "User deleted successfully"
            ],200);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'statusCode' => 500,
                'errors' => "Unknown error"
            ],500);
        }
    }
}
