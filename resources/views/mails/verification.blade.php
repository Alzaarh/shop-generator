<h1>This Message Is From {{ env('APP_NAME') }}</h1>
<p>Click The Link To Verify Your Account</p>
<p>{{ route('auth.verify',
    ['email' => $data['email'], 'verificationCode' => $data['verificationCode']]) }}
</p>
<a href="{{ route('auth.verify',
['email' => $data['email'], 'verificationCode' => $data['verificationCode']]) }}">CLICK</a>