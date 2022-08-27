<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mmenu;
use App\Models\Smenu;
use DB;

class MenuController extends Controller
{
    public function Showmenu($id)


    {
        // public function show($lastName,$firstName) {
        //     $qry = 'SELECT * FROM tableFoo WHERE LastName LIKE "'.$lastName.'" AND GivenNames LIKE "'.$firstName.'%" ' ;
        //     $ppl = DB::select($qry);
        //     return view('people.show', ['ppl' => $ppl] ) ;



        $Myqry='select a.id as mmid,b.id as smid,b.smenuname,b.par1,b.par2,b.par3 from tblemmenu as a
        inner join tblesmenu as b on a.id=b.mmenuid and a.id = "'.$id.'"  ';
        $data['co']=  DB::select ($Myqry);

        // return view('layouts.navigation', compact('co'));
         return view('layouts.navigation')->with($data);
        //  return redirect()->back();





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
                    DB::table('tblesize')->insert($datasave);
                    Session::put('success',"save data successfully");
                    return back();

                }

            // return redirect()->back();


    }


}
