<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SalesCSVProcess;
use App\Models\Sales;

class SalesController extends Controller
{
       public function index()
    {

        return view('jobs.index');
    }


    public function upload(Request $request)
    {
        if ($request->has('file_data')) {
            //  $data = array_map('str_getcsv',file($request->file_data));
            $path = resource_path('temp');
            $data =  file($request->file_data);
            //  $headers = $data[0];
            //  unset($data[0]);


            //chunking file
            $chunks = array_chunk($data, 1000);

            //convert 1000 rec into new csv file

            foreach ($chunks as $key => $chunk) {
                # code...
                $name = "/tem{$key}.csv";
                file_put_contents($path . $name, $chunk);
            }

            $files = glob("$path/*.csv");

            $header = [];
            foreach ($files as $key => $file) {
                $data = array_map('str_getcsv', file($file));
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                SalesCSVProcess::dispatch($data, $header);
            }
            unlink($file);
        }
    }


    public function store() {}
}
