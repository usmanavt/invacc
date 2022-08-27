<?php

namespace App\Http\Controllers;

use App\Models\Itemsize;
use Illuminate\Http\Request;
use DB;

class ItemsizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $itemsize = Itemsize::where(function($q) use ($search){
            $q->where('sizename','LIKE',"%$search%")
            ->orWhere('sizenname','LIKE',"%$search%");
        })
        ->orderBy('id','desc')
        ->paginate(6);
        return view('itemsize.index')->with('itemsize',$itemsize);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('itemsize.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'sizename'=>'required',
                'sizename'=>'required|unique:tblesize'

            ]
            );
        $maxValue = DB::table('tblesize')->max('sizeid')+1;
        // dd($maxValue);
        // try {
            // DB::transaction(function () {
                $itemsize = new Itemsize();
                $itemsize->sizeid = $maxValue;
                $itemsize->sizename = $request->sizename;
                $itemsize->sizenname = $request->sizenname;
                $itemsize->save();
        //     });
        //     // return redirect()->route('suppliers.index');
            return redirect()->back();
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     throw $th;
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Itemsize  $itemsize
     * @return \Illuminate\Http\Response
     */
    public function show(Itemsize $itemsize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Itemsize  $itemsize
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemsize=Itemsize::find($id);
        if (is_null($itemsize))
            {
                // NOT FOUND
                return redirect()->back();
            }
                else
            {
                $data=compact('itemsize');
                return view('itemsize.edit')->with($data);
            };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Itemsize  $itemsize
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request)
    {
        $itemsize=Itemsize::find($id);
                $itemsize->sizename = $request->sizename;
                $itemsize->sizenname = $request->sizenname;
                $itemsize->save();
                return redirect()->route('itemsize.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Itemsize  $itemsize
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $itemsize=Itemsize::find($id);
            if(!is_null($itemsize));
    {
        ($itemsize)->delete();


    }
    return redirect()->back();
    }


    public function storetemp(Request $request)
    {


                $fname = $request->iname;
                $lanme=$request->lname;
                $age=$request->age;

                for($i=0;$i<count($fname);$i++){
                    $datasave=[

                        'sizeid' => $age[$i],
                        'sizename' => $fname[$i],
                        'sizenname' => $lname[$i],

                    ];
                    return dd($datasave);
                    DB::table('tblesize')->insert($datasave);
                    Session::put('success',"save data successfully");
                    return back();

                }

            // return redirect()->back();


    }

}
