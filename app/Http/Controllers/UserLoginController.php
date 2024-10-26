<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ResponseApi;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ForgetPasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable; 

class UserLoginController extends Controller
{
    use ResponseApi;

    public function login(LoginRequest $request){
        
      try {
        // تحقق من صحة بيانات الاعتماد
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->responseError('Password & Email does not match with', 401);
        }

        // إنشاء رمز الوصول
        $token = $user->createToken('task')->plainTextToken;

        return $this->responseSuccess('User logged in successfully', $token);
    } catch (Throwable $th) {
        return $this->responseException($th->getMessage());
    }
 }


   public function forgetPassword(ForgetPasswordRequest $request)
     {
     try {
         // إرسال رابط إعادة تعيين كلمة المرور
         $status = Password::sendResetLink(
             $request->only('email')
         );

         return $status === Password::RESET_LINK_SENT
             ? $this->responseSuccess('Reset link sent to your email.')
             : $this->responseError('Unable to send reset link.', 500);
     } catch (Throwable $th) {
         return $this->responseException($th->getMessage());
     }
 }

 public function resetPassword(ResetPasswordRequest $request)
{
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['message' => 'Password has been reset successfully.'], 200)
        : response()->json(['message' => 'Failed to reset password.'], 500);
}
}
