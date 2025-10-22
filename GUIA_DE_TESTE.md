# 🚀 Guia Rápido de Teste - Tuguinha

## Iniciar o Servidor
```bash
php artisan serve
```

O site estará disponível em: http://127.0.0.1:8000

---

## ✅ Testes a Realizar

### 1. **Design e CSS** 🎨
- [ ] Visitar a página inicial
- [ ] Verificar o design moderno e responsivo
- [ ] Testar o menu mobile (redimensionar janela)
- [ ] Verificar animações e transições
- [ ] Confirmar que todos os ícones aparecem corretamente

**URLs para testar:**
- http://127.0.0.1:8000/
- http://127.0.0.1:8000/produtos
- http://127.0.0.1:8000/carrinho

---

### 2. **Páginas de Erro** 🚨
- [ ] Página 404 - aceder a URL inválido
- [ ] Página 403 - tentar aceder ao backoffice sem ser admin
- [ ] Verificar design das páginas de erro

**URLs para testar:**
- http://127.0.0.1:8000/pagina-que-nao-existe (404)
- http://127.0.0.1:8000/backoffice (403 se não for admin)

---

### 3. **Sistema de Autenticação** 🔐

#### **Registo**
- [ ] Aceder a `/register`
- [ ] Verificar ícones nos campos
- [ ] Criar nova conta
- [ ] Confirmar design moderno

#### **Login**
- [ ] Aceder a `/login`
- [ ] Verificar link "Esqueceste-te da password?"
- [ ] Testar login
- [ ] Verificar ícones e design

---

### 4. **Recuperação de Password** 📧

**IMPORTANTE:** Antes de testar, configurar Mailtrap no `.env`

#### **Passo a Passo:**
1. [ ] Aceder a http://127.0.0.1:8000/login
2. [ ] Clicar em "Esqueceste-te da password?"
3. [ ] Inserir email de utilizador existente
4. [ ] Clicar em "Enviar Link de Recuperação"
5. [ ] Verificar mensagem de sucesso
6. [ ] Abrir Mailtrap e verificar email recebido
7. [ ] Verificar design do email
8. [ ] Clicar no link do email
9. [ ] Preencher nova password
10. [ ] Confirmar redefinição
11. [ ] Fazer login com nova password

**URLs:**
- Pedido: http://127.0.0.1:8000/forgot-password
- Reset: http://127.0.0.1:8000/reset-password/{token}

---

### 5. **Backoffice** 🏢
**Apenas para utilizadores admin**

- [ ] Aceder a `/backoffice`
- [ ] Verificar design moderno das tabelas
- [ ] Verificar badges de tipos de utilizador
- [ ] Testar adicionar produto
- [ ] Testar eliminar produto
- [ ] Verificar ícones e responsividade

**URL:**
- http://127.0.0.1:8000/backoffice

---

### 6. **Carrinho de Compras** 🛒
- [ ] Adicionar produtos ao carrinho
- [ ] Verificar ícones modernos
- [ ] Testar remoção de itens
- [ ] Verificar mensagem de carrinho vazio
- [ ] Confirmar design responsivo

---

## 🔧 Configuração do Mailtrap

### Se ainda não configuraste:

1. **Criar conta**: https://mailtrap.io/
2. **Obter credenciais** em "Email Testing" → "Inboxes"
3. **Editar `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=teu_username
MAIL_PASSWORD=tua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@tuguinha.pt"
MAIL_FROM_NAME="Tuguinha"
```
4. **Limpar cache**:
```bash
php artisan config:clear
```

---

## 📱 Teste de Responsividade

### Testar em diferentes tamanhos:
- [ ] Desktop (1920x1080)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

**Como testar:**
- Usar DevTools do browser (F12)
- Testar menu mobile
- Verificar tabelas em mobile
- Confirmar formulários em mobile

---

## 🎨 Elementos para Verificar

### Ícones Font Awesome:
- [ ] Bandeira portuguesa no logo
- [ ] Ícone de casa no "Início"
- [ ] Ícone de caixa nos "Produtos"
- [ ] Ícone de carrinho
- [ ] Ícone de utilizador
- [ ] Ícone de engrenagem (admin)
- [ ] Ícone de porta para sair
- [ ] Ícones nos formulários
- [ ] Ícones nos botões
- [ ] Ícones nas páginas de erro

### Footer:
- [ ] Redes sociais (Facebook, Instagram, Twitter)
- [ ] Ano dinâmico
- [ ] Design moderno

---

## 🐛 Problemas Comuns

### Email não chega?
1. Verificar credenciais no `.env`
2. Executar `php artisan config:clear`
3. Verificar logs: `storage/logs/laravel.log`
4. Confirmar que o Mailtrap está ativo

### Ícones não aparecem?
1. Verificar ligação à internet (Font Awesome é CDN)
2. Abrir DevTools e verificar console
3. Verificar se o link do Font Awesome está no layout

### Página 404 não funciona?
- Laravel automaticamente usa `resources/views/errors/404.blade.php`
- Não é necessário configurar rotas

---

## ✨ Funcionalidades Implementadas

✅ CSS moderno e profissional
✅ Ícones Font Awesome em todo o site
✅ Páginas de erro personalizadas (404, 403, 500)
✅ Sistema completo de recuperação de password
✅ Email HTML personalizado
✅ Integração com Mailtrap
✅ Design responsivo
✅ Animações e transições
✅ Footer com redes sociais
✅ Backoffice modernizado
✅ Formulários de login/registo melhorados

---

## 📞 Checklist Final

Antes de considerar concluído:
- [ ] Servidor a correr
- [ ] Base de dados configurada
- [ ] Mailtrap configurado
- [ ] Todos os ícones visíveis
- [ ] Páginas de erro funcionais
- [ ] Sistema de password a funcionar
- [ ] Design responsivo OK
- [ ] Sem erros no console

---

**🎉 Bom teste! Se encontrares algum problema, verifica os ficheiros de instruções.**
