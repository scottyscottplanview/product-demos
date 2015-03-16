@extends("master.layout-admin")

@section("title")
    {{ $title }}
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
        <div class="col-sm-9">
            <fieldset>
                <legend>General Info</legend>
                {{ ControlGroup::generate(
                    Form::label('email', 'Email'),
                    Form::email('email', Input::old('email') ?: $user->email, ['required']) . $errors->first('email', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('roles', 'Roles'),
                    Form::select('roles', $roles, Input::old('roles') ?: $user->rolesById(), ['multiple', 'name' => 'roles[]']),
                    null,
                    3
                ) }}
            </fieldset>
            <fieldset>
                <legend>ISR-Only Information</legend>
                {{-- ControlGroup::generate(
                    Form::label('isr_first_name', 'ISR First Name'),
                    Form::text('isr_first_name', Input::old('isr_first_name') ?: $isr->isr_first_name
                        ) . $errors->first('isr_first_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) --}}
                {{ ControlGroup::generate(
                    Form::label('isr_first_name', 'ISR First Name'),
                    Form::text('isr_first_name', Input::old('isr_first_name', $isr->isr_first_name
                        )) . $errors->first('isr_first_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_last_name', 'ISR Last Name'),
                    Form::text('isr_last_name', Input::old('isr_last_name', $isr->isr_last_name)) . $errors->first('isr_last_name', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_phone', 'ISR Phone'),
                    Form::text('isr_phone', Input::old('isr_phone', $isr->isr_phone)) . $errors->first('isr_phone', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_mobile_phone', 'ISR Mobile Phone'),
                    Form::text('isr_mobile_phone', Input::old('isr_mobile_phone', $isr->isr_mobile_phone)) . $errors->first('isr_mobile_phone', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
                {{ ControlGroup::generate(
                    Form::label('isr_location', 'ISR Location'),
                    Form::text('isr_location', Input::old('isr_location', $isr->isr_location)) . $errors->first('isr_location', '<span class="label label-danger">:message</span>'),
                    null,
                    3
                ) }}
            </fieldset>
            @if (null === $user->id)
                {{ Form::hidden('auto_password', 1) }}
            @else
                <fieldset>
                    <legend>Authentication</legend>
                    {{ ControlGroup::generate(
                        Form::label('password', 'New Password'),
                        Form::password('password') . $errors->first('password', '<span class="label label-danger">:message</span>'),
                        null,
                        3
                    ) }}
                    {{ ControlGroup::generate(
                        Form::label('password_confirmation', 'Confirm New Password'),
                        Form::password('password_confirmation') . $errors->first('password_confirmation', '<span class="label label-danger">:message</span>'),
                        null,
                        3
                    ) }}
                </fieldset>
            @endif
        </div>
        <div class="col-sm-3">
            <div class="well">
                {{ Button::primary('Submit')->submit()->block() }}
            </div>
        </div>
    {{ Form::close() }}

<br><br>ISR:
<?php
    var_dump($isr);
?>
<br><br>USER:
<?php
    var_dump($user);
?>

    </article>
@stop
