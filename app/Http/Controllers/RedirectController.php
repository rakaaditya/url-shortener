<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Base;
use App\Urls;

class RedirectController extends Base
{
    public function go($shortCode)
    {
        $data = Urls::where('short_url', $shortCode)->first();
        
        if($data)
            return view('go', [
                'url' => $data->long_url,
            ]);
        else
            return view('notfound');
    }
}