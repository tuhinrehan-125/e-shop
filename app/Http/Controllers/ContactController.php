<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }

    public function index(Request $request)
    {
        $type= $request->type;
        $keyword= $request->keyword;
        $contacts = Contact::Active($type);
        if($keyword){
            $contacts->where(function ($query) use($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('mobile', 'like', '%' . $keyword . '%');
            });
        }
        $result=$contacts->get();

        return response()->json(ContactResource::collection($result),Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type'     => 'required',
                'name'     => 'required',
                'email'     => 'required',
                'address'     => 'required',
                'city'     => 'required',
                'mobile'     => 'required',
                'zip_code'     => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()], 422);
        }

        $contact = new Contact();
        $contact->business_id = auth()->user()->business_id;
        $contact->name = $request->name;
        $contact->supplier_business_name = $request->supplier_business_name;
        $contact->type = $request->type;
        $contact->email = $request->email;
        $contact->tax_number = $request->tax_number;
        $contact->city = $request->city;
        $contact->address = $request->address;
        $contact->state = $request->state;
        $contact->country = $request->country;
        $contact->zip_code = $request->zip_code;
        $contact->mobile = $request->mobile;
        $contact->alternate_number = $request->alternate_number;
        $contact->created_by = auth()->user()->id;
        $contact->customer_group_id = $request->customer_group_id;
        $contact->save();

        return response(new ContactResource($contact), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        if ($request->has('name')) {
            $contact->name = $request->name;
        }
        if ($request->has('supplier_business_name')) {
            $contact->supplier_business_name = $request->supplier_business_name;
        }
        if ($request->has('type')) {
            $contact->type = $request->type;
        }
        if ($request->has('email')) {
            $contact->email = $request->email;
        }
        if ($request->has('tax_number')) {
            $contact->tax_number = $request->tax_number;
        }
        if ($request->has('city')) {
            $contact->city = $request->city;
        }
        if ($request->has('address')) {
            $contact->address = $request->address;
        }
        if ($request->has('state')) {
            $contact->state = $request->state;
        }
        if ($request->has('country')) {
            $contact->country = $request->country;
        }
        if ($request->has('zip_code')) {
            $contact->zip_code = $request->zip_code;
        }
        if ($request->has('mobile')) {
            $contact->mobile = $request->mobile;
        }
        if ($request->has('alternate_number')) {
            $contact->alternate_number = $request->alternate_number;
        }
        if ($request->has('customer_group_id')) {
            $contact->customer_group_id = $request->customer_group_id;
        }

        $contact->save();

        return response(new ContactResource($contact), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $contact = Contact::where('id', $id)->first();

        $contact->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully'], 204);
    }

    public function contactSearch(Request $request)
    {
        $business_id = auth()->user()->business_id;

        $type = $request->type;
        $name = $request->name;
        if ($type == "customer") {
            $type = "customer";
            $contact = Contact::where('type', 'LIKE', "%$type%")->where('name', 'LIKE', "%$name%")->where('business_id', 'LIKE', "%$business_id%")->get();
        } elseif ($type == "supplier") {
            $type = "supplier";
            $contact = Contact::where('type', 'LIKE', "%$type%")->where('name', 'LIKE', "%$name%")->where('business_id', 'LIKE', "%$business_id%")->get();
        }

        if (count($contact) > 0) {
            return response(ContactResource::collection($contact), Response::HTTP_OK);
        } else {
            return response()->json(['success' => true, 'message' => 'Contact not found'], 200);
        }
    }
}
