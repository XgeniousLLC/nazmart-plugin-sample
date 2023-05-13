@extends(route_prefix()."admin.admin-master")
@section('title') {{__('SitesWay Payment Gateway Settings')}}@endsection
@section("content")
    <div class="col-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">{{__('SitesWay Payment Gateway Settings')}}</h4>
                <x-error-msg/>
                <x-flash-msg/>
                <form class="forms-sample" method="post" action="{{route('sitepaymentgateway.'.route_prefix().'admin.settings')}}">
                    @csrf
                    <x-fields.input type="text" value="{{get_static_option('sitesway_api_key')}}" name="sitesway_api_key" label="{{__('Api Key')}}"/>
                    <x-fields.input type="text" value="{{get_static_option('sitesway_brand_id')}}" name="sitesway_brand_id" label="{{__('Brand Id')}}"/>

                    <x-fields.switcher label="{{__('Sitesway Enable/Disable Landlord & Tenant Both')}}" name="sitesway_status" value="{{$sitesways->status}}"/>
                    <x-fields.switcher label="{{__('Sitesway Enable/Disable Landlord Websites')}}" name="sitesway_landlord_status" value="{{$sitesways->admin_settings->show_admin_landlord}}"/>
                    <x-fields.switcher label="{{__('Sitesway Enable/Disable Tenant Websites')}}" name="sitesway_tenant_status" value="{{$sitesways->admin_settings->show_admin_tenant}}"/>

                    <button type="submit" class="btn btn-gradient-primary mt-5 me-2">{{__('Save Changes')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
