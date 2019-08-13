<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset password</title>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style>
        input{
            margin-bottom: 10px;
        }
        li{
            list-style-type: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Change Password</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <p class="text-center">Use the form below to change your password.</p>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" id="passwordForm">
                    <input type="text" class="input-lg form-control" name="token"
                        placeholder="code" autocomplete="off">
                    <input type="password" class="input-lg form-control" name="password" id="password1"
                        placeholder="New Password" autocomplete="off">
                    <input type="password" class="input-lg form-control" name="c_password" id="password2"
                        placeholder="Repeat Password" autocomplete="off">
                    <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg"
                        data-loading-text="Changing Password..." value="Change Password">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</body>

</html>
