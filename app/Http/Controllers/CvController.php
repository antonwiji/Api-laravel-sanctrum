<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function GuzzleHttp\Promise\all;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cv = Cv::all();

        $respon = [
            'message' => 'Data Cv Anda',
            'data' => $cv
        ];

        return response()->json($respon, Response::HTTP_OK);
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
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'umur' => ['required', 'numeric'],
            'alamat' => ['required']
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $cv = Cv::create($request->all());
            $respon = [
                'message' => 'Succes Create Data',
                'data' => $cv
            ];

            return response()->json($respon, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'error' . $e->errorInfo
            ]);
        }
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cvById = Cv::find($id);

        if(!$cvById)
        {
            return response()->json([
                'error' => 'id not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $response = [
            'message' => 'find id',
            'data' => $cvById
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $cv = Cv::find($id);

        if(!$cv)
        {
            return response()->json([
                'error' => 'data not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'umur' => ['required', 'numeric'],
            'alamat' => ['required']
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $cv->update($request->all());
            $respon = [
                'message' => 'data is updated',
                'data' => $cv
            ];
            return response()->json($respon, Response::HTTP_OK);
        } catch (QueryException $e) {
           return response()->json([
            'error' => $e->errorInfo
           ], Response::HTTP_BAD_REQUEST);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cv = Cv::find($id);

        if(!$cv){
            return response()->json(['error' => 'id not found'], Response::HTTP_NOT_FOUND);
        }

        $cv->delete();
        return response()->json(['message' => 'data is dalated'], Response::HTTP_OK);
    }
}
