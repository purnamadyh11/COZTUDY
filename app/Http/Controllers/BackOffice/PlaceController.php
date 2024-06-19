<?php

namespace App\Http\Controllers\BackOffice;

use DataTables;
use App\Models\Place;
use App\Models\PlaceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Place::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('type_status', function ($row) {
                    $type[1] = "Ready";
                    $type[2] = "Booked";
                    $type[3] = "Closed";

                    return $type[$row->status];
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a data-id="' . $row->id . '" data-name="' . $row->name . '" data-latitude="' . $row->latitude . '" data-longitude="' . $row->longitude . '" data-status="' . $row->status . '" data-description="' . $row->description . '" data-price="' . $row->price . '" href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> ';
                    $actionBtn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';

                    return $actionBtn;
                })
                ->addColumn('description_place', function ($row) {
                    return $row->description;
                })
                ->addColumn('harga', function ($row) {
                    return "Rp ".str_replace(",", ".", number_format($row->price));
                })
                ->rawColumns(['type_status', 'description_place', 'harga', 'action'])
                ->make(true);
        }
        return view('back-office/place/index');
    }

    public function delete($id)
    {
        try {
            PlaceDetail::where('place_id', $id)->delete();
            $place = Place::findOrFail($id);
            $place->delete();

            return response()->json(['code' => 200, 'message' => 'Tempat berhasil terhapus.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Oops ada yang salah : ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            $storagePath = storage_path('app/images');
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
            if (!is_writable($storagePath)) {
                throw new \Exception('Storage directory is not writable');
            }

            $request->merge([
                'price' => preg_replace('/[^\d]/', '', $request->price)
            ]);

            $data = $request->except(['image', 'image_description']);

            $place = Place::create($data);

            // insert image
            self::insertImage($request, $place->id);

            return response()->json(['code' => 200, 'message' => 'Data berhasil ditambahkan.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Oops, terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function insertImage($request, $place_id)
    {
        // get old image
        if ($request->old_image) {
            foreach ($request->old_image as $k => $v) {
                PlaceDetail::create([
                    'place_id' => $place_id,
                    'images' => $request->old_image[$k],
                    'description' => $request->image_description[$k]
                ]);
            }
        }

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $key => $file) {
                if (!$file->isValid()) {
                    throw new \Exception("File upload error: " . $file->getErrorMessage());
                }

                // Ensure the storage directory exists and is writable
                $storagePath = public_path('uploads/images');
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true);
                }

                // Move the uploaded file to the storage directory
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $storagePath . '/' . $fileName;

                if (!move_uploaded_file($file->getPathname(), $filePath)) {
                    throw new \Exception("Failed to move uploaded file");
                }

                PlaceDetail::create([
                    'place_id' => $place_id,
                    'images' => 'uploads/images/' . $fileName,
                    'description' => $request->image_description[$key]
                ]);
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $place = Place::where('id', $id)->first();

            $request->merge([
                'price' => preg_replace('/[^\d]/', '', $request->price)
            ]);
            
            // Assuming you have fields like 'name', 'address', etc. in your Place model
            $place->update($request->all());

            PlaceDetail::where('place_id', $id)->delete();
            
            self::insertImage($request, $id);

            return response()->json(['code' => 200, 'message' => 'Data berhasil diedit.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Oops, terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function getImage($id)
    {
        $detail = PlaceDetail::where('place_id', $id)->get();
        return $detail;
    }
}