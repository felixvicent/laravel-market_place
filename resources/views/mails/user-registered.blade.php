<h1>Olá {{ $user->name }} Obrigado pela sua compra</h1>

<p>
    Aproveite e compre em nosso marketplace <br>
    Seu email de cadastro é: <strong>{{ $user->email }}</strong><br>
</p>

<hr>

Email enviado em {{ date('d/m/Y H:i:s') }}.