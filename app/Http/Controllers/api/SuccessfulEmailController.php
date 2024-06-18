<?php

namespace App\Http\Controllers\api;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SuccessfulEmail;

class SuccessfulEmailController extends Controller
{
    public function index()
    {
        return SuccessfulEmail::whereNull('deleted_at')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'affiliate_id' => 'required|integer',
            'envelope' => 'required|string',
            'from' => 'required|string',
            'subject' => 'required|string',
            'dkim' => 'nullable|string',
            'SPF' => 'nullable|string',
            'spam_score' => 'nullable|numeric',
            'email' => 'required|string',
            'sender_ip' => 'nullable|string|max:50',
            'to' => 'required|string',
            'timestamp' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $email = SuccessfulEmail::create($request->all());
        $email->update(['raw_text' => (new GeneralHelper)->extractPlainText($email->email)]);

        return response()->json($email, 201);
    }

    public function show($id)
    {
        return SuccessfulEmail::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        $email->update($request->all());
        return response()->json($email);
    }

    public function destroy($id)
    {
        $email = SuccessfulEmail::findOrFail($id);
        $email->delete();
        return response()->json(['message' => 'Record soft deleted successfully']);
    }
}
