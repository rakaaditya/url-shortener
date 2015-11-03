<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Base;
use App\Urls;

class UrlController extends Base
{

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'long_url'  => 'required|url|max:255',
        ]);

        if ($validator->fails()) {
            $status = [
                'status'    => 'failed',
                'error'     => $validator->errors(),
            ];
        } else {
            $header = @get_headers($request->input('long_url'));
            if (! preg_match('/200/',$header[0])) {
                $status = [
                    'status' => 'failed',
                    'error'  => 'URL Not Found / invalid',
                ];
            } else {
                $host       = 'htp://'.env('HOSTNAME').'/';
                $current    = Urls::where('long_url', $request->input('long_url'))->first();
                
                if($current) {
                    $shortUrl     = $host.$current->short_url;
                } else {
                    $unique     = strtolower(str_random(3));
                    $shortUrl   = $host.$unique;
                    $data = Urls::firstOrCreate([
                        'long_url'  => $request->input('long_url'),
                        'short_url' => $unique,
                    ]);
                    $data->save();
                }

                $status = [
                    'status'    => 'success',
                    'long_url'  => $request->input('long_url'),
                    'short_url' => "$shortUrl",
                ];   
            }
        }
        return response()->json($status)
                 ->setCallback($request->input('callback'));
    }
}
