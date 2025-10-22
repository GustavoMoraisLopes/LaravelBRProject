# 📧 Instruções para Configurar o Mailtrap

## Passos para configurar o envio de emails:

### 1. Criar conta no Mailtrap
1. Acede a https://mailtrap.io/
2. Cria uma conta gratuita
3. Acede ao painel de controlo

### 2. Obter credenciais
1. No painel do Mailtrap, vai a "Email Testing" → "Inboxes"
2. Clica na tua inbox (ou cria uma nova)
3. Na aba "SMTP Settings", seleciona "Laravel 9+"
4. Copia as credenciais apresentadas

### 3. Configurar o ficheiro .env
Abre o ficheiro `.env` na raiz do projeto e atualiza as seguintes linhas:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=teu_username_aqui
MAIL_PASSWORD=tua_password_aqui
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tuguinha.pt"
MAIL_FROM_NAME="Tuguinha"
```

**IMPORTANTE**: Substitui `teu_username_aqui` e `tua_password_aqui` pelas credenciais fornecidas pelo Mailtrap!

### 4. Limpar cache de configuração
Executa o seguinte comando no terminal:

```bash
php artisan config:clear
```

### 5. Testar o sistema
1. Acede à página de login: http://127.0.0.1:8000/login
2. Clica em "Esqueceste-te da password?"
3. Insere um email de um utilizador existente
4. Verifica a inbox do Mailtrap para ver o email recebido

## 🎨 Melhorias Implementadas

### CSS Modernizado
- Design moderno com gradientes
- Animações suaves
- Responsivo para mobile
- Sombras e transições profissionais

### Ícones Font Awesome
- Substituídos todos os emojis por ícones profissionais
- Interface mais limpa e consistente

### Páginas de Erro Personalizadas
- 404 - Página não encontrada
- 403 - Acesso negado
- 500 - Erro interno do servidor

### Sistema de Recuperação de Password
- Formulário de pedido de reset
- Formulário de redefinição de password
- Integração completa com o sistema de emails do Laravel
- Link adicionado à página de login

## 📝 Notas Importantes

- O Mailtrap é apenas para ambiente de desenvolvimento/teste
- Para produção, deves usar um serviço real como SendGrid, Amazon SES, ou Mailgun
- Todos os emails enviados em desenvolvimento vão para o Mailtrap e não são entregues a emails reais
- Isto é perfeito para testar sem risco de enviar emails acidentalmente aos utilizadores

## 🔐 Segurança

- Nunca commites o ficheiro `.env` no Git
- As credenciais do Mailtrap devem ser mantidas privadas
- Em produção, usa variáveis de ambiente seguras
