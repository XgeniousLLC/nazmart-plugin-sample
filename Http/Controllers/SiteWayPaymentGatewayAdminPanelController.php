<?php

namespace Modules\SiteWayPaymentGateway\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SiteWayPaymentGatewayAdminPanelController extends Controller
{
    public function settings()
    {
        return  view("sitewaypaymentgateway::admin.settings");
    }

    public function settingsUpdate(Request $request){
        $request->validate([
            "sitesway_api_key" => "required|string",
            "sitesway_brand_id" => "required|string",
        ]);

        update_static_option("sitesway_api_key",$request->sitesway_api_key);
        update_static_option("sitesway_brand_id",$request->sitesway_brand_id);

        return back()->with(["msg" => __("Settings Update"),"type" => "success"]);
    }
}
