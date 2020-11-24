<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\Finder;
use App\Http\Requests;

class FinderController extends Controller
{
    //
    protected $finders;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $finders = Finder::Where(
                'find_num1', $request->find_num1)
            ->orWhere('find_num2', $request->find_num2)
            ->orWhere('find_num3', $request->find_num3)->get();
            $id = 0;
        return view('finder', [
            'finders' => $finders,
            'name' => $request->user()->name,
            'ver' => $request->ver,
            'id' => $request->id,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $finder = Finder::find($id);

        return view('finder', [
            'finder' => $finder,
            'ver' => $request->ver,
            'id' => $id,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'find_name' => 'required|max:10',
            'find_num1' => 'required|max:4',
            'find_num2' => 'required|max:4',
            'find_num3' => 'required|max:4',
        ]);

        if ($validator->fails()) {
            return redirect('/finder?ver='.$request->ver)
                ->withInput()
                ->withErrors($validator);
        }

        $finders = new Finder;
        $finders->find_user_id = $request->user()->id;
        $finders->find_name = $request->find_name;
        $finders->find_addr2 = $request->find_addr2;
        $finders->find_addr = $request->find_addr;
        if($request->find_addr = 0){
            return redirect('/finder');
            $finders->find_addr2 = 0;
            $finders->find_addr = 0;
        }
        $finders->find_num1 = $request->find_num1;
        $finders->find_num2 = $request->find_num2;
        $finders->find_num3 = $request->find_num3;
        $finders->save();

        return redirect('/findnum?ver='.$request->ver);
        // Create The Task...
    }

    public function edit_store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'find_name' => 'required|max:10',
            'find_num1' => 'required|max:4',
            'find_num2' => 'required|max:4',
            'find_num3' => 'required|max:4',
            'find_addr' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/finder/edit/'.$id)
                ->withInput()
                ->withErrors($validator);
        }

        $finder = Finder::find($id);
        $finder->find_name = $request->find_name;
        $finder->find_addr2 = $request->find_addr2;
        $finder->find_addr = $request->find_addr;
        $finder->find_num1 = $request->find_num1;
        $finder->find_num2 = $request->find_num2;
        $finder->find_num3 = $request->find_num3;
        $finder->save();

        return redirect('/findnum?ver='.$request->ver);
        // Create The Task...
    }

    public function destroy(Request $request, Finder $finder)
    {
        $finder->delete();
        return redirect('/finder');
    }
}
