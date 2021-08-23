<?php

    namespace App\Http\Controllers;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Models\User as ModelsUser;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator as FacadesValidator;

class UserController extends Controller
    {
        public function login()
        {
            $credentials = [
                'email' => request('email'), 
                'password' => request('password')
            ];

            if (Auth::attempt($credentials)) {
                $success['token'] = Auth::user()->createToken('MyApp')->accessToken;

                return response()->json([
                    'success' => $success,
                    'user' => Auth::user()
                ]);
            }

            return response()->json(['error' => 'Unauthorised'], 401);
        }

        public function register(Request $request)
        {
            $validator = FacadesValidator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            $user = ModelsUser::create($input);
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->name;

            return response()->json([
                'success' => $success,
                'user' => $user
            ]);
        }

        public function getDetails(Request $request)
        {
            return response()->json(['user' => ModelsUser::find($request->user)]);
        }

        public function profileUpload(Request $request)
        {
            $this->validate($request,[
                'image' => 'required',
                'user' => 'required'
            ]);

            $user = ModelsUser::find($request->user);
            $user->update([
                'avatar' => $request->image
            ]);

            return response()->json([
                'avatar' => $user->avatar
            ]);
        }

        public function follow(Request $request)
        {
            $user = ModelsUser::find($request->willFollow);
            $will_follow = ModelsUser::find($request->user);
            $is_followed = $will_follow->isFollowedBy($user);
            if($is_followed)
                $user->unfollow($will_follow,false);
            else
                $user->follow($will_follow,true);
            
            return !$will_follow->isFollowedBy($user);
        }

        public function getFollowings(Request $request)
        {
            $user = ModelsUser::find($request->user);
            return $user->followings;
        }

        public function getSugUsers()
        {
            return ModelsUser::inRandomOrder()->with('followers')->limit(5)->get();
        }
    }