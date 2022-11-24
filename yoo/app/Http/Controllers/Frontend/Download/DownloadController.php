<?php

namespace App\Http\Controllers\Frontend\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function driverApk(Request $request)
    {
        return view('frontend.download.driver_apk');
    }

    public function directDownloadDriverApk(Request $request)
    {
        $path = public_path('apk/driver-app-release.apk');

        return response()->file($path ,[
            'Content-Type'=>'application/vnd.android.package-archive',
            'Content-Disposition'=> 'attachment; filename="yoo-driver.apk"',
        ]) ;
    }

    public function directDownloadCustomerApk(Request $request)
    {
        $path = public_path('apk/customer-app-release.apk');

        return response()->file($path ,[
            'Content-Type'=>'application/vnd.android.package-archive',
            'Content-Disposition'=> 'attachment; filename="yoo-customer.apk"',
        ]) ;
    }
}
