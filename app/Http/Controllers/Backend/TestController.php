<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Jobs\TestJob;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public $tests = [
        'index',
        'testPermissions',
        'debugSentry',
    ];
    public function index($function=null)
    {
        if ($function!==null){
            return $this->$function();
        }else{
            $message = 'Tests working';
        }
        $tests = $this->tests;
        return view('pages.test', compact('message','tests'));
    }
    public function testPermissions()
    {
        $message = 'only super admin can see this';
        $tests = $this->tests;
        return view('pages.test', compact('message','tests'));
    }
    public function debugSentry()
    {
        throw new \Exception('My first Sentry error!');
    }

    public function emailTemplate(){
        try{

            $user = User::find(3);

            $otp = 1234;

            return view('frontend.email.welcome',compact('user','otp'));
        } catch (\Exception $ex) {
            dd($ex);
        }

    }
}
