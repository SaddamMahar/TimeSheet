<?php

namespace App\Http\Controllers;

//use App\Model\Client;
use App\Model\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return View('client/client')->with("clients",$clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return View("client/clientRegistration");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        $insertClient = ['name'=>$request->input('inputName'),
            'address'=>$request->input('inputAddress'),
            'contact'=>$request->input('inputContact'),
            'contactPerson'=>$request->input('inputContactPerson'),
            'nic'=>$request->input('inputnic')];

        Client::InsertGetID($insertClient);
        return redirect('/client');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($client)
    {
        $data = Client::find($client);
        echo json_encode($data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $clientdb = Client::find($request->input('id'));
        $clientdb->name = $request->input('inputName');
        $clientdb->address =$request->input('inputAddress');
        $clientdb->contact =$request->input('inputContact');
        $clientdb->contactPerson =$request->input('inputContactPerson');
        $clientdb->nic =$request->input('inputnic');
        $clientdb->save();
        return redirect('/client');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if($client->dailyInput != null){
            foreach($client->dailyInput as $dailyInput){
                $dailyInput->delete();
            }
        }
        $client->delete();
        return redirect('/client');
    }

    public function delete($id)
    {
        $client = Client::find($id);
        if($client->dailyInput != null){
            foreach($client->dailyInput as $dailyInput){
                $dailyInput->delete();
            }
        }
        Client::destroy($client->id);
        return redirect('/client');
    }


    public function updateClient(Request $request)
    {
        $clientdb = Client::find($request->input('id'));
        $clientdb->name = $request->input('inputName');
        $clientdb->address =$request->input('inputAddress');
        $clientdb->contact =$request->input('inputContact');
        $clientdb->contactPerson =$request->input('inputContactPerson');
        $clientdb->nic =$request->input('inputnic');
        $clientdb->save();
        return redirect('/client');

    }

    public function search(Request $request)
    {
        $searchText = $request->input('search');
        $clients = Client::where('name','LIKE','%'.$searchText.'%')->get();
        return View('client/client')->with("clients",$clients)->with('search',$searchText);
    }


    public function allClients(Request $request)
    {

        $columns = array(
            0 =>'name',
            1=> 'address',
            2=> 'contact',
            3=> 'contactPerson',
            4=> 'nic',
        );

        $totalData = Client::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if($request->input('search.value') == null || $request->input('search.value') == '')
        {
            $clients = Client::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $clients =  Client::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('address', 'LIKE',"%{$search}%")
                ->orWhere('contact', 'LIKE',"%{$search}%")
                ->orWhere('contactPerson', 'LIKE',"%{$search}%")
                ->orWhere('nic', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Client::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($clients))
        {
            foreach ($clients as $client)
            {
//                $edit =  "http://localhost:8000/client/".$client->id.'/edit/';

                $delete =  url("/client/delete/".$client->id);

                $editImg =  url("/img/edit.png");
                $delImg =  url("/img/remove.png");


                $nestedData['id'] = $client->id;
                $nestedData['name'] = $client->name;
                $nestedData['address'] = $client->address;//substr(strip_tags($client->body),0,50)."...";
                $nestedData['contact'] = $client->contact;//date('j M Y h:i a',strtotime($client->created_at));
                $nestedData['contactPerson'] = $client->contactPerson;//date('j M Y h:i a',strtotime($client->created_at));
                $nestedData['nic'] = $client->nic;//date('j M Y h:i a',strtotime($client->created_at));
                $nestedData['action'] = "<ul class='list-inline'><li>
<a href='#' data-toggle='modal' data-target='#myModal2' onclick='edit_book($client->id)' ><img src=".$editImg." alt=''></a>
</li><li><a href=".$delete."><img src=".$delImg." alt=''></a></li></ul>";


                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }
}
