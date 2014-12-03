<?php

class DemosController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$demos = Demo::paginate(5);
		//$demos = Demo::orderBy('title', 'asc')->paginate(5);
		//$demos = Demo::orderBy('title', 'asc')->get();
		$demos = Demo::orderBy('title', 'asc')->get();
		
		return View::make("demos.index")->with(array("demos"=>$demos));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		App::abort(404);
		/*
		// return 'the create function';
		return View::make("demos.create");
		*/
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		App::abort(404);
		/*
		// return 'the store function';
		$demo = new Demo;
		$demo->title = Input::get('demo_title');
		$demo->description = Input::get('demo_description');
		$demo->save();

		return View::make("demos.store")->with(array("demo"=>$demo));
		*/	
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$demo = Demo::findOrFail($id);
		return View::make("demos.show")->with(array("demo"=>$demo));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		App::abort(404);
		/*
		// /demos/1/edit
		// return 'the edit function';
		$demo = Demo::withTrashed()->findOrFail($id);
		return View::make("demos.edit")->with(array("demo"=>$demo));
		*/
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		App::abort(404);
		/*
		// /demos/1
		// return 'the update function';
		if (Input::get('submit_button_restore')) {
			$restoreDemo = Demo::withTrashed()->where('id', $id)->restore();
			$demo = Demo::withTrashed()->findOrFail($id);
			if (stripos($demo->title,"EXPIRED: ") === 0) {
				$demo->title = substr($demo->title,8);
				$demo->save();
			}
		} else {
			$demo = Demo::withTrashed()->find($id);
			$demo->title = Input::get('demo_title');
			$demo->description = Input::get('demo_description');
			$demo->save();
		}

		$demo = Demo::withTrashed()->findOrFail($id);
		return View::make("demos.update")->with(array("demo"=>$demo));
		*/	
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		App::abort(404);
		/*
		//return 'the destroy function';
		$demo = Demo::withTrashed()->find($id);
		$demo->title = "EXPIRED: ".$demo->title;
		$demo->save();
		$dseatroyDemo = Demo::destroy($id);

		return View::make("demos.destroy")->with(array("demo"=>$demo));
		*/
	}


}
