<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{

	public function __construct__()
	{
		$this->middleware('auth');
	}

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'content' => 'required|max:140'
    	]);

    	Auth::user()->statuses()->create([
    		'content' => $request->content
    	]);

    	return redirect()->back();
    }

    public function destroy(Status $status)
    {
        try {
            $this->authorize('destroy', $status);
        } catch (\Exception $e) {
          return abort(403, '对不起，你无权进行此操作！');
        }

        $status->delete();

        session()->flash('success', '微博被成功删除！');

        return redirect()->back();
    }
}
