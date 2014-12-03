@extends("master.layout")

@section("page_title")
	{{{$demo->title}}}
@stop

@section("nav_menu_admin")
	@parent
	| {{HTML::link('/pvadmin/demos/'.$demo->id.'/edit', 'edit this demo');}}
@stop

@section("page_content")
	<article><p>{{{$demo->description}}}</p></article>
@stop