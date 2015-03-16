@extends("master.layout-admin")

@section("title")
    {{ $title }}
@stop

@section("nav_menu_admin")
    @parent
    <li>{{HTML::link('/demos/'.$demo->id, 'View This Demo', array('id' => 'topnav-admin-view'));}}</li>
@stop

@section("page_messages")
    @include('pvadmin.partials.flash')
@stop

@section("content")
    <header class="page-header">
        <h1>{{ $title }}</h1>
    </header>
    <article>
    {{ Form::horizontal(['route' => $action, 'class' => 'row', 'method' => $method]) }}
        <div class="col-sm-10">
            {{ ControlGroup::generate(
                Form::label('title', 'Title'),
                Form::text('title', Input::old('title') ?: $demo->title, ['required']) . $errors->first('title', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('description', 'Description'),
                Form::textarea('description', Input::old('description') ?: $demo->description, ['required']) . $errors->first('description', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('enterprise_version', 'Enterprise Version'),
                Form::select('enterprise_version', array('10.4' => 'PVE 10.4', '11' => 'PVE 11'), $demo->enterprise_version, ['required']) . $errors->first('enterprise_version', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('language', 'Language'),
                Form::select('language', array('Deutsch' => 'Deutsch', 'North America' => 'North America', 'UK' => 'UK'), $demo->language, ['required']) . $errors->first('language', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('demo_code', 'Demo Code'),
                Form::textarea('demo_code', Input::old('demo_code') ?: $demo->demo_code, ['required']) . $errors->first('demo_code', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            {{ ControlGroup::generate(
                Form::label('related_content_code', 'Related Content Code'),
                Form::textarea('related_content_code', Input::old('related_content_code') ?: $demo->related_content_code, ['required']) . $errors->first('related_content_code', '<span class="label label-danger">:message</span>'),
                null,
                3
            ) }}
            <div class='form-group'>
                <div class='col-sm-3'>&nbsp;</div>
                <div class='col-sm-4'>
                    <div class="well">
                        {{ Button::primary('Submit')->submit()->block() }}
                    </div>
                </div>
                <div class='col-sm-5'>&nbsp;</div>
            </div>
        </div>
    {{ Form::close() }}
    </article>
@stop
