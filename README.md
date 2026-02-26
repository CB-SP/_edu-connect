# Edu Connect - Rede Social Acadêmica KeySolutions
Sistema de gestão escolar que conecta professores e alunos.
Projecto para TCC desenvolvido com HTML, CSS, JS e PHP.

## 🚀 Começando
**Pré-requisitos**
- Servidor local (XAMPP, WAMP ou similar)
- PHP 8+
- MySQL
- Navegador moderno

### Configuração inicial
**1.** Clone o repositório para `C:\xampp\htdocs`:
```bash
    git clone <YOUR_GIT_URL>
    cd edu_connect
```

**2.** Configure o banco de dados:
- Copie o código do banco de dados em `database/src_code`

**3.** Na raíz, crie a pasta `config` com o arquivo `config.php` e dentro dele configure as variáveis do banco:
```php
    <?php
        define("URL", "http://localhost/_edu-connect/");
        define("DB_NAME", "edu_connect");
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASS", "");
    ?>
```
> ⚠️ IMPORTANTE: Não compartilhe este arquivo com credenciais em commits públicos. O arquivo `config/config.php` contém informações sensíveis e **NÃO DEVE SER COMMITADO** no Git. Ele já está incluso no `.gitignore`.

**4.** Inicie o servidor local e acesse:
```text
    http/localhost/_edu-connect
```

# 📁 Estrutura do projecto
```text
    edu_connect/
    ├── app/                        # código principal do sistema
    │   ├── controllers/            # lógica e regras de negócio
    │   ├── models/                 # interacção com bancos de dados e APIs (dados do sistema)
    │   └── views/                  # interfaces do usuário
    │       ├── errors/             # todas as páginas de erro do sistema
    │       ├── layouts/            # layout padrão do sistema
    │       └── public/             # arquivos estáticos como imagens, fontes, css e js
    ├── config/                     # configuração do sistema
    ├── core/                       # rotas, controllers e models
    ├── database/                   # código do banco de dados
    ├── .htaccess                   # configuração do servidor Apache
    ├── index.php                   # autoload
    └── .gitignore                  # arquivos ignorados pelo Git
```

# 🔒 Segurança e boas práticas
- Nunca faça commit de arquivos com passwords ou credenciais
- Use `.gitignore` para ignorar arquivos sensíveis `config/config.php`
- Se precisar remover do histórico:
```bash
    git rm --cached config/config.php
    git commit -m "Remove arquivo de configuração"
    git push
```

## Organização de Código
**1. Views**
- Views sem parents: `app/views/[entidade]/arquivo.phtml`
- Views com parents: `app/views/[entidade_pai]/[entidade_filha]/arquivo.phtml`

**2. Nomenclaturas**
- Classes: `camelCase`
- Variáveis: `snake_case`
- Métodos: `snake_case`
- Pastas: `camelCase`

**3. Importações**
- Use paths relactivos para chamar os arquivos do sistema: `<?=URL?>app/...`

## 🛠️ Scripts Disponíveis
- Rodar servidor local: XAMPP/WAMPP
- Acessar front-end: `http://localhost/edu_connect`
- Administração do banco via **phpMyAdmin, MySQL Workbench ou MySQL 8.0 Command Line**

## 📦 Tecnologias Principais
- HTML5, CSS3, JS
- PHP 8+ (POO)
- MVC (Model - View - Controller)
- MySQL
- Servidor local (XAMPP/WAMPP)

# 🤝 Contribuindo
**1.** Crie uma branch para a sua feature: `git checkout -b feature/nova-feature`
**2.** Commit suas mudanças: `git commit -m "Adiciona nova feature"`
**3.** Push para branch: `git push origin feature/nova-feature`
**4.** Abra um **Pull Request**

# ⚠️ Problemas Comuns
- Erro de conexão com banco: verifique as credenciais em `config/config.php`
- Arquivos JS/CSS não carregam: certifique-se de que os paths estão corretos no front
- Erro de roteamento MVC: verifique se as rotas são chamadas correctamente no front

# 📄 Licença
Este projecto é propriedade da **Key Solutions Company.**