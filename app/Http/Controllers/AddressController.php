<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use DataTables;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = Address::get();
        if($request->ajax()) {
            $allData = DataTables::of($addresses)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'. 
                $row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm 
                editAddress">Edit</a>';
                $btn.= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'. 
                $row->id.'" data-original-title="Delete" class="edit btn btn-danger btn-sm 
                deleteAddress">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
            return $allData;
        }
        return view('addresses', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Address::updateOrCreate(
            ['id'=>$request->address_id,
            'firstname'=> $request->firstname,
            'addition'=> $request->addition,
            'lastname'=> $request->lastname,
            'address'=> $request->address,
            'postalcode'=> $request->postalcode,
            'cityname'=> $request->cityname,
            'phonenumber'=> $request->phonenumber,
            'email'=> $request->email
        ]
        );
        return response()->json(['success'=>'Address Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addresses = Address::find($id);
        return response()->json($addresses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Address::find($id)->delete();
        return response()->json(['success'=>'Address Deleted Successfully']);
    }
}
