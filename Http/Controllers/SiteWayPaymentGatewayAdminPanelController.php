<?php

namespace Modules\SiteWayPaymentGateway\Http\Controllers;

use App\Helpers\ModuleMetaData;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SiteWayPaymentGatewayAdminPanelController extends Controller
{
    public function settings()
    {
        $all_module_meta_data = (new ModuleMetaData("SiteWayPaymentGateway"))->getExternalPaymentGateway();
        $sitesways = array_filter($all_module_meta_data,function ( $item ){
            if ($item->name === "SitesWay"){
                return $item;
            }
        });
        $sitesways = current($sitesways);
        return  view("sitewaypaymentgateway::admin.settings",compact("sitesways"));
    }

    public function settingsUpdate(Request $request){
        $request->validate([
            "sitesway_api_key" => "required|string",
            "sitesway_brand_id" => "required|string",
        ]);

        update_static_option("sitesway_api_key",$request->sitesway_api_key);
        update_static_option("sitesway_brand_id",$request->sitesway_brand_id);
        if(is_null(tenant())){
            $jsonModifier = json_decode(file_get_contents("core/Modules/SiteWayPaymentGateway/module.json"));
            $jsonModifier->nazmartMetaData->paymentGateway->status = $request?->sitesway_status === 'on';
            $jsonModifier->nazmartMetaData->paymentGateway->admin_settings->show_admin_landlord = $request?->sitesway_landlord_status === 'on';
            $jsonModifier->nazmartMetaData->paymentGateway->admin_settings->show_admin_tenant = $request?->sitesway_tenant_status === 'on';
            file_put_contents("core/Modules/SiteWayPaymentGateway/module.json",json_encode($jsonModifier));
        }



        return back()->with(["msg" => __("Settings Update"),"type" => "success"]);
    }
}
