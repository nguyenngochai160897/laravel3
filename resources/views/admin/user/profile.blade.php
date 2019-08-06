@extends('admin.layouts.default')

@section('title')
    Profile
@endsection

@section('content')
<div class="content-wrapper">
    <div class="center-block">
        <div class="col-6 profile-usertitle">
            <div class="profile-usertitle-name">
                    <span style="color: orange">User Name</span> : {{ $user->username }}
            </div>
            <div class="profile-usertitle-email">
                    <span style="color: blue">Email Address</span> : {{ $user->email }}
            </div>
            <div class="profile-usertitle-role">
                <span style="color: red">Role</span>: {{ $user->account_type }}
            </div>
        </div>
    </div>
</div>
@endsection
