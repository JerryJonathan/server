<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mobil;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostResource;

class MobilController extends Controller
{
    public function index()
    {
        $mobil = Mobil::latest()->paginate(10);
        return new PostResource($mobil);
    }

    public function store(Request $request)
    {   
        //set validation
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
          
        ], [
            'name.required' => 'Nama wajib diisi',
           
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
   
            $mobil= Mobil::create([
                'name'      => $request->name,
              
            ]);
            return new PostResource($mobil);
    }

    public function show(Request $request, $id)
    {
        $mobil= Mobil::find($id);

        return new PostResource($mobil);
    }

    public function update(Request $request, $id)
    {   
        //set validation
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
           
        ], [
          
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mobil= Mobil::find($id);

        //update to database
            $mobil->update([
                'name'      => $request->name,
               
            ]);
            return new PostResource($mobil);
    }

    public function destroy($id)
    {
        $mobil= Mobil::find($id);

        $mobil->delete();

        return new PostResource(null);
    }    

}
