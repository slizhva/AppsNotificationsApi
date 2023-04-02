@extends('layouts.admin')

@section('container-class')
    container
@endsection

@section('body-class')
    col-md-12
@endsection

@section('admin-title')
    <span><a class="btn btn-link p-0" href="{{ route('notifications') }}">Notifications</a></span>
@endsection

@section('admin-body')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    *Add telegram bot to you chat/channel for telegram notifications:
                    <a target="_blank" href="https://t.me/apps_notifications_api_bot">t.me/apps_notifications_api_bot</a>
                </div>
                <hr>
                <strong>---Add notification:---</strong>
                <form class="row" method="POST" action="{{ route('notification.add') }}" >
                    {{ csrf_field() }}
                    <input name="name" type="text" value="" placeholder="Name" class="col-md-4" required>
                    <input name="data" type="text" value="" placeholder="data" class="col-md-3" required>
                    <select name="type" class="col-md-2" required>
                        <option value="" hidden>type</option>
                        @foreach($notificationTypes as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Add" class="col-md-1">
                    <div class="col-md-2"></div>
                </form>
                <div class="row border-bottom border-top bg-light border-end">
                    <div class="col-md-4 border-start">Name</div>
                    <div class="col-md-3 border-start">Data</div>
                    <div class="col-md-2 border-start">Type</div>
                    <div class="col-md-3 border-start"></div>
                </div>
                @foreach($notifications as $notification)
                    <div class="row border-bottom align-items-center  border-end">
                        <div class="col-md-4 border-start">
                            <div>{{ $notification['name'] }}</div>
                            <input class="d-none" name="data" type="text" value="{{ $notification['name'] }}" />
                        </div>
                        <div class="col-md-3 border-start">
                            <div>{{ $notification['data'] }}</div>
                            <input class="d-none" name="data" type="text" value="{{ $notification['data'] }}" />
                        </div>
                        <div class="col-md-2 border-start">
                            <div>{{ $notificationTypes[$notification['type']] }}</div>
                            <select class="d-none" name="type" required>
                                <option value="" hidden>type</option>
                                @foreach($notificationTypes as $key => $value)
                                    <option
                                        value="{{ $key }}"
                                        @if ($notification['type'] === $key) selected @endif
                                    >
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1 border-start p-0">
                            <form method="POST" action="{{ route('notification.update', $notification['id']) }}">
                                {{ csrf_field() }}
                                <input name="name" type="hidden" value="{{ $notification['name'] }}"/>
                                <input name="data" type="hidden" value="{{ $notification['data'] }}" />
                                <input name="type" type="hidden" value="{{ $notification['type'] }}" />
                                <input class="col-md-12 pt-0 pb-0 updateInputs" type="submit" value="Update" disabled>
                                <input class="col-md-12 pt-0 pb-0 d-none" type="submit" value="Save">
                            </form>
                        </div>
                        <div class="col-md-1 p-0">
                            <form method="POST" action="{{ route('notification.delete', $notification['id']) }}">
                                {{ csrf_field() }}
                                <input name="dangerous_actions_key" class="dangerous-action-key-value" type="text" value="" hidden>
                                <input class="col-md-12 pt-0 pb-0 dangerous-action-button" type="submit" value="Delete" disabled>
                            </form>
                        </div>
                        <div class="col-md-1 p-0">
                            <div class="d-none copyLinkValue">{{ route('notification.run', [$notification['id'], $token]) }}</div>
                            <button class="btn btn-link p-1 w-100 copyLinkButton">Copy link</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row mt-5">
            <hr>
            <div class="col-md-5">
                @include('components.dangerous_action_form')
            </div>
        </div>
    </div>
@endsection
