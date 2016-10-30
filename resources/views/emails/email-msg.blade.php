@extends('emails/layouts/html')

@section('logo')
@if (empty($logo))
{{$community}}
@else
{{$logo}}
@endif
@stop

@section('content')
    <p>Dear {{$name}},</p>

    <p>You've received a new message to the <strong>{{$thread_subject}}</strong> thread in the Share, <a href="{{$community_url}}" style="color: white;">{{ $community }}</a>

    @if (isset($entry_name))
        on the entry titled <strong><a href="{{$community_url}}/entry/{{$entry_id}}" style="color: white;">{{$entry_name}}</a></strong>
    @endif
:</p>

    <blockquote>{{ $offer }}</blockquote>

    <p style="text-align: center">
        <strong>
            <a href="{{$community_url}}/account/message/{{$thread_id}}"  style="color: white;">
                Click here to view this message online
            </a>
        </strong>
    </p>

@stop
