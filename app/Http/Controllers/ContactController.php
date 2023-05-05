<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    //direct to message list page
    public function messageListPage()
    {
        $contactData = Contact::when(request('searchData'), function ($query) {
            $query = $query->orWhere('name', 'like', '%' . request('searchData') . '%')
                ->orWhere('email', 'like', '%' . request('searchData') . '%')
                ->orWhere('message', 'like', '%' . request('searchData') . '%');
        })
        ->get();
        return view('admin.contact.messagelist', compact('contactData'));
    }

    //direct to message detail page
    public function messageDetailPage($requestedId)
    {
        $requestedContactData = Contact::where('id',$requestedId)->first();
        return view('admin.contact.messagedetail',compact('requestedContactData'));
    }

    //delete message
    public function deleteMessage($requestedId)
    {
        Contact::where('id',$requestedId)->delete();
        return back();
    }
}
