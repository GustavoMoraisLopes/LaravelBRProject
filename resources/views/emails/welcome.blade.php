@component('mail::message')
# Bem-vindo à Tuguinha, {{ $user->name }}!

É com muito gosto que te recebemos na nossa loja de produtos tradicionais portugueses.

@component('mail::button', ['url' => route('profile.edit')])
Ver o meu perfil
@endcomponent

Se tiveres alguma dúvida, responde a este email.

Boas compras,

Equipa Tuguinha
@endcomponent
