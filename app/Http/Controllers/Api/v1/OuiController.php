<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\OUI_records;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MultipleOuiRequest;
use App\Http\Resources\v1\OuiResource;
use App\Http\Resources\v1\OuiCollection;
use App\Services\v1\OuiQuery;

class OuiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new OuiQuery();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0){
            return json_encode(OUI_records::all());
        }else{

            //Remove Mac Address Separators
            $value = str_replace(":","",$queryItems[0][2]);
            $value = str_replace("-","",$value);
            $value = str_replace(".","",$value);
            $value_oui = substr($value,0,6);

            $vendor_name = new OuiCollection(OUI_records::where(['Assignment' => $value_oui])->paginate());

            $vendor_name =  $vendor_name[0];

            $new_vendor = ['mac_address'=>$value,'vendor'=>$vendor_name];
            
            return json_encode($new_vendor);
        }

        //return new OuiCollection(OUI_records::paginate());

        //OUI_records::where($queryItems);

        //return OUI_records::all();
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
       $data = $request->all();

       $vendor_results = [];

       foreach ($data as $key => $value) {

            //Remove Mac Address Separators
            $value = str_replace(":","",$value);
            $value = str_replace("-","",$value);
            $value = str_replace(".","",$value);
            $value_oui = substr($value,0,6);

            //print [json_encode(new OuiCollection(OUI_records::where(['Assignment' => $value_oui])->paginate()))];

            $vendor_name = new OuiCollection(OUI_records::where(['Assignment' => $value_oui])->paginate());

            $vendor_name =  $vendor_name[0];

            $new_vendor = ['mac_address'=>$value,'vendor'=>$vendor_name];

            $vendor_results[] = $new_vendor;
       }

       return json_encode($vendor_results);
        
        //
    }

    public function MultipleOuiCheck(Request $request)
    {
        //return new OuiCollection(OUI_records::where($request)->paginate());

       

        return 'I am good';
    }

    //return json_encode(OUI_records::all());

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Oui_records $Oui)
    {
        return new OuiResource($Oui);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
