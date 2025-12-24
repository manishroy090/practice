<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\ComissionRule;
use Illuminate\Support\Facades\Validator;
use App\Events\TestEvent;

class ComissionController extends Controller
{


    public function index()
    {
        try {
            $airports = Airport::all();
            $comissionRule = ComissionRule::select('id','origin', 'destination', 'rate', 'ratevalue')->get();
            $response = [
                'airports' => $airports,
                'comissionrule' => $comissionRule,
                'totalorigin'=>Airport::count(),
                'totalcommissionrule'=>ComissionRule::count(),
                'message' => "fetch successfully"
            ];
           
        
            $code = 200;
        } catch (\Throwable $th) {

            $response = [
                'airports' => [],
                'comissionrule' => [],
                'message' => "Something Went Wrong"
            ];
            $code = 500;
        }

        return response()->json($response, $code);
    }

    public function create(Request $request)
    {
        //    return response()->json([
        //     'res'=>$request->all()
        //    ]);

        $validator =  Validator::make($request->all(), [
            'rows' => 'required|array|min:1',
            'rows.*.origin' => 'required|array|min:1',
            'rows.*.destination' => 'required|array|min:1',
            'rows.*.rate' => 'required|numeric',
            'rows.*.rateValue' => 'required',

        ], [
            'origin.required' => "Origin is required",
            'destination.required' => "Destination is required",
            'rate.required' => "Rate is required",
            'rateValue.required' => "Rate value is required"
        ]);



        if ($validator->fails()) {
            $code = 422;
            $response = [
            'validator_err' => $validator->messages()
            ];
        } else {

            try {
                $data =  $validator->validate();

                foreach ($data['rows'] as $key => $value) {
                # code...
                $data['rows'][$key]['origin'] =  json_encode($value['origin']);
                $data['rows'][$key]['destination'] =  json_encode($value['destination']);
               }
                ComissionRule::insert($data['rows']);
                //  event(new TestEvent("Commission rule is created"));
                TestEvent::dispatch('Commission rule is created');
                $code = 201;
                $response = [
                    'message' => "Commission Rule created successfully"
                ];
            } catch (\Throwable $th) {
              
                $code = 500;
                $response = [
                    'message' =>$th->getMessage()
                ];
            }
        }


        return response()->json($response, $code);
    }

    public function edit(Request $request)
    {
        $ids = $request->input('ids');

        try {
            //code...
            $commission = ComissionRule::whereIn('id', $ids)->get();
            $code = 200;
            $response = [
                'commissions' => $commission,
                'message' => "commission found"
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'message' => $th->getMessage()
            ];
            $code = 500;
        }

        return response()->json($response, $code);
    }

  public function update(Request $request)
{
    $validator = Validator::make($request->all(), [
        'rows' => 'required|array|min:1',
        'rows.*.id' => 'nullable',
        'rows.*.origin' => 'required|array|min:1',
        'rows.*.destination' => 'required|array|min:1',
        'rows.*.rate' => 'required|numeric',
        'rows.*.rateValue' => 'required',
    ], [
        'rows.*.origin.required' => "Origin is required",
        'rows.*.destination.required' => "Destination is required",
        'rows.*.rate.required' => "Rate is required",
        'rows.*.rateValue.required' => "Rate value is required",
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages()
        ], 422);
    }

    try {
        $data = $validator->validated();

       

        foreach ($data['rows'] as $key => $value) {
            $data['rows'][$key]['origin'] = json_encode($value['origin']);
            $data['rows'][$key]['destination'] = json_encode($value['destination']);
        }
        foreach ($data['rows'] as $key => $value) {
          ComissionRule::where('id',$data['rows'][$key]['id'])->update($data['rows'][$key]);
        }

        // Example save
        // ComissionRule::insert($data['rows']);

        return response()->json([
            'message' => 'Commission rule updated successfully',
            'data' => $data
        ], 200);

    } catch (\Throwable $th) {
        return response()->json([
            'message' => $th->getMessage()
        ], 500);
    }
}



    public function delete(Request $request) {
           $ids = $request->input('ids');
           try {
            ComissionRule::whereIn('id', $ids)->delete();
            $response = [
               'message'=>"Comission rule deleted successfully"
            ];

            $code =200;

           } catch (\Throwable $th) {
             $response = [
               'message'=>"Something went wrong"
            ];
            $code = 500;
           }

           return response()->json($response ,$code);
       

    }
}
