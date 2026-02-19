# 🏥 MEDHUB — Sistema para Gestão Médica

## 📖 Descrição

O **MEDHUB** é um sistema web desenvolvido para o gerenciamento de consultas e exames em clínicas privadas de saúde.

A plataforma permite realizar o agendamento, controle e acompanhamento de atendimentos médicos, oferecendo maior organização administrativa e melhor experiência para pacientes, profissionais de saúde e administradores.

O projeto foi estruturado com base no padrão arquitetural **MVC (Model-View-Controller)**, visando organização do código, facilidade de manutenção e escalabilidade.

---

## 🛠️ Tecnologias Utilizadas

* **PHP** — Backend e regras de negócio
* **MySQL** — Banco de dados
* **HTML5** — Estrutura das páginas
* **CSS3** — Estilização da interface
* **JavaScript** — Interatividade do sistema

---

## 📚 Bibliotecas Externas

* **Chart.js (v4.5.0)**
  Utilizada para geração de gráficos estatísticos e indicadores de desempenho do sistema.

* **FullCalendar (v6.1.19)**
  Responsável pela criação do calendário interativo para agendamento e visualização das consultas.

---

## 🧱 Estrutura do Projeto

O sistema foi organizado seguindo o padrão MVC:

```
MEDHUB/
│
├── controllers/   → Controlam a lógica da aplicação e recebem as requisições
├── models/        → Realizam acesso e manipulação dos dados no banco
├── views/         → Telas e interface do sistema (HTML, CSS, JS e PHP)
└── libs/          → Bibliotecas externas utilizadas pelo sistema
```

### 📁 controllers/

Arquivos PHP responsáveis por processar as requisições do usuário, aplicar regras de negócio e intermediar a comunicação entre as *views* e os *models*.

### 📁 models/

Responsáveis pela comunicação com o banco de dados, realizando operações de inserção, consulta, atualização e exclusão de informações.

### 📁 views/

Contém a interface do sistema. Inclui páginas HTML, folhas de estilo (CSS), scripts JavaScript e trechos PHP para renderização dinâmica.

### 📁 libs/

Armazena as bibliotecas externas utilizadas pelo sistema, como o calendário de agendamentos e os gráficos estatísticos.

---

## 🎯 Objetivo do Sistema

O objetivo do MEDHUB é reduzir problemas comuns em clínicas, como:

* Longo tempo de espera
* Dificuldade no controle de agendas
* Falta de organização nos atendimentos
* Ausência de acompanhamento histórico do paciente

O sistema centraliza as informações e automatiza processos administrativos, auxiliando na gestão clínica e no atendimento ao paciente.
