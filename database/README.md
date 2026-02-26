# 📚 Banco de Dados EduConnect

O banco de dados **EduConnect** foi projetado para suportar uma plataforma escolar multi-tenant, conectando administradores, directores, professores, coordenadores e alunos, com suporte a comunicação, gestão de turmas, cursos, disciplinas, posts, comentários e anexos.

---

## 🏫 Tabela: `escolas`

Armazena informações das escolas cadastradas no sistema.

- **id**: int (PK) — Identificador único da escola
- **nome**: varchar(100) — Nome da escola (único)
- **endereco**: varchar(150) — Endereço físico da escola
- **contacto_1**: varchar(16) — Primeiro contacto (único)
- **contacto_2**: varchar(16) — Segundo contacto (opcional)
- **foto**: varchar(255) — Logo da escola
- **created_at**: timestamp — Data de criação
- **deleted_at**: timestamp — Data de eliminação (soft delete)

---

## 👤 Tabela: `usuarios`

Contém todos os usuários do sistema, incluindo admins, directores, professores e alunos.

- **id**: int (PK) — Identificador único do usuário
- **nome**: varchar(100) — Nome do usuário (único por escola)
- **contacto_1**: varchar(16) — Número principal
- **contacto_2**: varchar(16) — Número secundário (opcional)
- **nif**: varchar(14) — Número de identificação fiscal (único)
- **email**: varchar(100) — Email do usuário (opcional e único)
- **foto**: varchar(255) — URL da foto de perfil
- **password**: varchar(255) — Senha criptografada
- **role**: enum — Função do usuário (`admin`, `director`, `professor`, `aluno`)
- **escola**: int (FK) — Referência à tabela `escolas`
- **created_at**: timestamp — Data de criação
- **deleted_at**: timestamp — Data de eliminação (soft delete)

---

## 👨‍🏫 Tabela: `coordenadores`

Subtipo de professor, apenas professores podem ser coordenadores.

- **id**: int (PK, FK) — Referência ao `id` da tabela `usuarios`

---

## 🎓 Tabelas: `niveis` e `niveis_escolas`

Definem os níveis de ensino e quais níveis pertencem a cada escola.

- **`niveis`**: catálogo global de níveis (`Ensino Primário`, `I Ciclo do Ensino Secundário` e `II Ciclo do Ensino Secundário`)  
- **`niveis_escolas`**: vincula níveis às escolas, permitindo N:N

---

## 💼 Tabelas: `cursos`, `cursos_escolas`, `cursos_niveis`

- **`cursos`**: cadastro de cursos disponíveis, com descrição e coordenador (opcional)  
- **`cursos_escolas`**: relaciona cursos a escolas específicas  
- **`cursos_niveis`**: relaciona cursos a níveis de ensino

---

## 📘 Tabelas: `disciplinas`, `professores_disciplinas`

- **`disciplinas`**: disciplinas oferecidas por escola  
- **`professores_disciplinas`**: vincula professores às disciplinas que leccionam

---

## 🏫 Tabelas: `turmas`, `alunos_turmas`

- **`turmas`**: turmas criadas pelos professores, vinculadas à escola  
- **`alunos_turmas`**: associa alunos às turmas

---

## 📝 Tabelas: `posts`, `comentarios`, `reaccoes`

Permite comunicação interna e publicação de avisos.

- **`posts`**: publicações gerais ou avisos, vinculados a usuário e escola  
- **`comentarios`**: comentários em posts  
- **`reacoes`**: reações aos posts (`like`, `apoio`, `love`), apenas uma por usuário/post

---

## 💬 Tabelas: `chats`, `mensagens`

Implementa chats por turma.

- **`chats`**: cada turma possui um chat, vinculado à escola  
- **`mensagens`**: mensagens enviadas por usuários dentro do chat

---

## 📎 Tabela: `anexos`

Suporte a anexos em posts, comentários e mensagens.

- **ficheiro**: varchar(500) — URL ou caminho do arquivo  
- **usuario**: int (FK) — Autor do arquivo  
- **post**: int (FK, opcional) — Post associado  
- **comentario**: int (FK, opcional) — Comentário associado  
- **mensagem**: int (FK, opcional) — Mensagem associada  
- **escola**: int (FK) — Escola do conteúdo  
- **created_at**: timestamp — Data de criação  
- **deleted_at**: timestamp — Data de eliminação (soft delete)

---

## 🔗 Relacções principais

- Usuário pertence a **uma escola**  
- Coordenador é um **professor**  
- Turmas são criadas por professores e vinculadas a uma escola  
- Cursos e níveis podem pertencer a múltiplas escolas (N:N)  
- Posts, comentários, reacções e anexos respeitam o multi-tenant  
- Chats e mensagens são por turma e escola

---

## 🔐 Considerações de arquitetura

- **Multi-tenant**: cada escola mantém seus dados isolados  
- **Soft delete**: `deleted_at` para marcação de exclusão sem perder histórico  
- **Roles**: controle de acesso por função (`admin`, `director`, `professor`, `aluno`)  
- **Validação no backend**: algumas regras não podem ser garantidas apenas no banco, como:
  - Coordenador deve ser professor  
  - Usuário não postar em escola de outro usuário  
  - Apenas um tipo de anexo por registro (post/comentário/mensagem)
