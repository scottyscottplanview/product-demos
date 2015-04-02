<?php
    $body_class = "demo";
?>
@extends("master.layout")

@section("title")
    {{{$demo->title}}}
@stop

@if (User::find(Auth::id())->can('manage_content'))
    @section("nav_menu_admin")
        @parent
        <li>{{HTML::link('/pvadmin/demos/'.$demo->id, 'Edit This Demo', array('id' => 'topnav-admin-view'));}}</li>
    @stop
@endif

@section("content")
    <p class="back-to-demos"><a href="/demos" title="Back to Demo List">&laquo; Back to Demo List</a></p>

    <h1 id="page-title">{{{$demo->title}}}</h1>

    <div class="col-md-8">

        <div class="limelight-video-respond">
            <span class="LimelightEmbeddedPlayer">
                {{$demo->demo_code}}
            </span>
        </div>

    </div>
    <div class="col-md-4">

        <div class="right-sidebar">
            <div class="module-contact-info">
                <h2 id="header-contact">Contact</h2>
                <p><strong>ISR&nbsp;Admin</strong><br />
                Location: North America<br />
                Tel: 512-555-1212<br />
                Mobil: 512-555-1212<br />
                Email: <a href="mailto:isr-admin@planview.com" class="email-link" title="Email ISR&nbsp;Admin">isr-admin@planview.com</a></p>
            </div>

            <div class="module-related-content">
                <h2>Related Content</h2>
                <ul class="left-arrows">
                    {{$demo->related_content_code}}
                </ul>
            </div>
        </div>

    </div>
@stop
