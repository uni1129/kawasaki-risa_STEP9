<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Register</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>


<body>
    <div class="top-title">
        <h3>Laravel</h3>
        <ul>
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        </ul>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">Register</div>
            <div class="auth-card-body">
                @if ($errors->any())
                <div style="color: red; margin-bottom: 15px; font-size: 0.85rem;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="form-group-row">
                        <label for="name" class="form-label-col">Name (ユーザ名)</label>
                        <div class="form-input-col">
                            <input type="text" id="name" class="form-control-input" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label for="name_kanji" class="form-label-col">名前 (漢字)</label>
                        <div class="form-input-col">
                            <input type="text" id="name_kanji" class="form-control-input" name="name_kanji" value="{{ old('name_kanji') }}" required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label for="name_kana" class="form-label-col">名前 (カナ)</label>
                        <div class="form-input-col">
                            <input type="text" id="name_kana" class="form-control-input" name="name_kana" value="{{ old('name_kana') }}" required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label for="email" class="form-label-col">Email Address</label>
                        <div class="form-input-col">
                            <input type="email" id="email" class="form-control-input" name="email" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label for="password" class="form-label-col">Password</label>
                        <div class="form-input-col">
                            <input type="password" id="password" class="form-control-input" name="password" required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label for="password-confirm" class="form-label-col">Confirm Password</label>
                        <div class="form-input-col">
                            <input type="password" id="password-confirm" class="form-control-input" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <div class="form-label-col"></div>
                        <div class="form-input-col">
                            <button type="submit" class="btn-laravel-primary">
                                Register
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>