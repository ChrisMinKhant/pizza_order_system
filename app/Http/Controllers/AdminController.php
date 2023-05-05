<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    //direct password change page
    public function passwordChangePage()
    {
        return view('admin.account.password.change');
    }

    //change password
    public function passwordChange(Request $request)
    {
        $validatedPassword = $this->validatePassword($request);                                     //password validation

        $dbOldPassword = User::select('password')->where('id', Auth::user()->id)->first();

        if (!Hash::check($validatedPassword['oldPassword'], $dbOldPassword->password)) {            //checking old and db old password
            return back()->with(['notMatch' => "Your Credential Doesn't Match"]);
        }

        User::where('id', Auth::user()->id)->update([                                               //updating new password to database
            'password' => Hash::make($validatedPassword['newPassword'])
        ]);

        return back()->with(['passwordChanged' => 'Changing Password Success!']);
    }

    //direct admin account info show page
    public function accountInfoShowPage()
    {
        return view('admin.account.account_info_show');
    }

    //direct admin account info edit page
    public function accountInfoEditPage()
    {
        return view('admin.account.account_info_edit');
    }

    //update admin account info
    public function accountInfoUpdate($adminId, Request $request)
    {

        $this->infoUpdate($adminId, $request);
        return redirect()->route('admin#accountinfo#show')->with(['accountUpdate' => 'Account Updated Successfully!']);
    }

    //Direct Admin List Page
    public function adminListPage()
    {
        $adminList = User::when(request('searchData'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('searchData') . '%')
                ->orWhere('gender', 'like', '%' . request('searchData') . '%')
                ->orWhere('email', 'like', '%' . request('searchData') . '%')
                ->orWhere('phone', 'like', '%' . request('searchData') . '%')
                ->orWhere('address', 'like', '%' . request('searchData') . '%');
        })
            ->where('role', 'admin')
            ->paginate(5);
        $adminList->appends(request()->all());
        return view('admin.account.adminlist', compact('adminList'));
    }

    //admin list delete
    public function adminListDelete($adminId)
    {
        User::where('id', $adminId)->delete();
        return back()->with(['deletedAdminList' => 'Admin Deleted Successfully!']);
    }

    //admin role change
    public function adminRoleChange($adminId)
    {
        User::where('id', $adminId)->update(['role' => 'user']);
        return back()->with(['adminRoleChanged' => 'Admin Role Changed Successfully!']);
    }

    //direct to user list page
    public function userListPage()
    {
        $userData = User::when(request('searchData'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('searchData') . '%')
                ->orWhere('gender', 'like', '%' . request('searchData') . '%')
                ->orWhere('email', 'like', '%' . request('searchData') . '%')
                ->orWhere('phone', 'like', '%' . request('searchData') . '%')
                ->orWhere('address', 'like', '%' . request('searchData') . '%');
        })
            ->where('role', 'user')
            ->paginate(5);
        $userData->appends(request()->all());
        return view('admin.account.userlist', compact('userData'));
    }

    //change user role
    public function changeUserRole(Request $request)
    {
        User::where('id', $request->userId)->update(['role' => $request->userRole]);
    }

    //edit user info from admin
    public function editUserInfoPage($requestedUserId)
    {
        $userData = User::where('id', $requestedUserId)->first();
        return view('admin.account.edituser', compact('userData'));
    }

    //update user info from admin
    public function updateUserInfo($userId, Request $request)
    {
        $this->infoUpdate($userId, $request);
        return redirect()->route('admin#userListPage');
    }

    //delete user
    public function deleteUser(Request $request)
    {
        User::where('id', $request->userId)->delete();
    }

    //all accounts info update
    protected function infoUpdate($id, Request $request)
    {
        $arrayData = $this->validateAccountInfo($request);

        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first()->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $arrayData['image'] = uniqid() . $request->file('image')->getClientOriginalName();

            $request->file('image')->storeAs('public', $arrayData['image']);
        }
        User::where('id', $id)->update($arrayData);
    }

    //password fields validation
    protected function validatePassword(Request $request)
    {
        return $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ]);
    }

    //admin account info validation
    protected function validateAccountInfo(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,jpeg,png,webp|file',
        ]);
    }
}
