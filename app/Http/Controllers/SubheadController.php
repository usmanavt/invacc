<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Manhead;
use App\Models\Subhead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// CHART OF ACCOUNTS
class SubheadController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->search;
        $subheads = Subhead::where(function($q) use ($search){
            $q->where('subheadname','LIKE',"%$search%")
              ->orWhereHas('manhead', function($qu) use($search){
                $qu->where('mheadname','like',"%$search%");
            });
        })
        ->with('manhead')
        ->orderBy('id','desc')
        ->paginate(5);
         return view('subheads.index')->with('subheads',$subheads);

    }

    public function create()
    {
        return view('subheads.create')->with('manhead',Manhead::all())->with('subheads',Subhead::all());
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'subheadname'=>'required|unique:tblsubhead|min:3',
            'ob'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $subhead = new Subhead();
            $subhead->tblmanhead_id = $request->tblmanhead_id;
            $subhead->subheadname = $request->subheadname;
            $subhead->ob = $request->ob;
            if($request->has('sstatus'))
            {
                $subhead->sstatus = 'Active';
            }else {
                $subhead->sstatus = 'Deactive';
            }
            $subhead->save();
            DB::commit();
            Session::flash('success','Subhead opened');
            return redirect()->route('subheads.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function edit($id)
    {
        return view('subheads.edit')->with('manhead',Manhead::all())->with('subhead',Subhead::findOrFail($id));
    }

    public function update(Subhead $subhead,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'subheadname'=>'required|min:3|unique:tblsubhead,subheadname,' . $subhead->id,
            'ob'=>'required|numeric'
        ]);
        DB::beginTransaction();
        try {
            $subhead=Subhead::findOrFail($subhead->id);
            $subhead->tblmanhead_id = $request->tblmanhead_id;
            $subhead->subheadname = $request->subheadname;
            $subhead->ob = $request->ob;
            if($request->has('sstatus'))
            {
                $subhead->sstatus = 'Active';
            }else {
                $subhead->sstatus = 'Deactive';
            }
            $subhead->save();
            DB::commit();
            Session::flash('info','Subhead updated');
            return redirect()->route('subheads.index');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function destroy($id)
    {
        return redirect()->back();
    }
}
