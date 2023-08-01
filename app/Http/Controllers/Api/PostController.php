<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class PostController extends Controller
{
    public $storage;

    public function __construct()
    {
        $this->storage = 'local';
    }
    /**
     * Display a listing of the resource.
     */

    public function form()
    {        
        $provinces = Province::with('regencies')->get();

        return new PostResource($provinces);
    }

    public function regency(Request $request, $id)
    {
        $regencies = Regency::where('province_id', $id)->get();

        return new PostResource($regencies);
    }

    public function district(Request $request, $id)
    {
        $districts = District::where('regency_id', $id)->get();

        return new PostResource($districts);
    }

    public function village(Request $request, $id)
    {
        $villages = Village::where('district_id', $id)->get();

        return new PostResource($villages);
    }

    public function postal(Request $request)
    {
        $postals = json_decode(file_get_contents(public_path() . "/assets/postal_array.json"), true);

        return new PostResource($postals);
    }

    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return new PostResource($posts);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        //set validation
        $validator = Validator::make($request->all(), [
            'NIK'   => 'required|unique:posts,NIK',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5000',
            'name'    => 'required',
            'province' => 'required',
            'regency' => 'required',
            'district' => 'required',
            'village' => 'required',
            'postal' => 'required',
            // 'agama' => 'required',
        ], [
            'NIK.required' => 'NIK wajib diisi',
            'image.image' => 'Foto KTP wajib diisi dengan format .png, .jpg, atau .jpeg',
            'name.required' => 'Nama wajib diisi',
            'province.required' => 'Provinsi wajib dipilih',
            'regency.required' => 'Kabupaten/Kota wajib dipilih setelah memilih provinsi',
            'district.required' => 'Kecamatan wajib dipilih setelah memilih kabupaten/kota',
            'village.required' => 'Kelurahan wajib dipilih setelah memilih kecamatan',
            'postal.required' => 'Kode Pos muncul setelah memilih kelurahan',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

            $file_id = $request->file('image')->store('', $this->storage);
            $url = Storage::disk($this->storage)->url($file_id);

        // $tujuan_upload = 'assets/images/';
        // // menyimpan data file yang diupload ke variabel $file
        // $file_id = $request->file('image');
        // $name_file_id = md5(rand()) . '.' .$file_id->getClientOriginalExtension();
        // $file_id->move($tujuan_upload,$name_file_id);

        //save to database
        try {
            $post = Post::create([
                'NIK'     => $request->NIK,
                'image'   => $url,
                'image_name' => $file_id,
                'name'      => $request->name,
                'province' => $request->province,
                'regency' => $request->regency,
                'district' => $request->district,
                'village' => $request->village,
                'postal' => $request->postal,
                // 'agama' => $request->agama,
            ]);

            return new PostResource($post);

        } catch (Exception $e) {
           
            Storage::disk($this->storage)->delete($file_id);
            return response()->json($e->errors(), 400);
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $post = Post::find($id);

        return new PostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         //set validation
         $validator = Validator::make($request->all(), [
            'NIK'   => 'required',
          
            'name'    => 'required',
            'province' => 'required',
            'regency' => 'required',
            'district' => 'required',
            'village' => 'required',
            'postal' => 'required',
            // 'agama' => 'required',
        ], [
            'NIK.required' => 'NIK wajib diisi',
            'image.image' => 'Foto KTP wajib diisi dengan format .png, .jpg, atau .jpeg',
            'name.required' => 'Nama wajib diisi',
            'province.required' => 'Provinsi wajib dipilih',
            'regency.required' => 'Kabupaten/Kota wajib dipilih setelah memilih provinsi',
            'district.required' => 'Kecamatan wajib dipilih setelah memilih kabupaten/kota',
            'village.required' => 'Kelurahan wajib dipilih setelah memilih kecamatan',
            'postal.required' => 'Kode Pos muncul setelah memilih kelurahan',
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
       
        //find post by ID
        $post = Post::find($id);

        //check if image is not empty
        if ($request->hasFile('image')) {
           
            $validator = Validator::make($request->all(), [
               
                'image' => 'image|mimes:png,jpg,jpeg|max:5000',
               
            ]);

            // $tujuan_upload = 'assets/images/';
            // // menyimpan data file yang diupload ke variabel $file
            // $file_id = $request->file('image');
            // $name_file_id = md5(rand()) . '.' .$file_id->getClientOriginalExtension();;
            // $file_id->move($tujuan_upload,$name_file_id);

            // update new image
            $file_id = $request->file('image')->store('', $this->storage);
            $url = Storage::disk($this->storage)->url($file_id);

            //delete old image
            Storage::disk($this->storage)->delete($post->image_name);

            //update to database
        $post->update([       
            'NIK'     => $request->NIK,
            'image'   => $url,
            'image_name' => $file_id,
            'name'      => $request->name,
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district,
            'village' => $request->village,
            'postal' => $request->postal,
            // 'agama' => $request->agama,
        ]);

        } else {
            //update post
            $post->update([
                'NIK'     => $request->NIK,
                'name'   => $request->name,
                'province' => $request->province,
                'regency' => $request->regency,
                'district' => $request->district,
                'village' => $request->village,
                'postal' => $request->postal,
                // 'agama' => $request->agama,
            ]);
        }        

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        Storage::disk($this->storage)->delete($post->image_name);
        $post->delete();

        return new PostResource(null);
    }
}
