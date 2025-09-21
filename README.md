# Sistema de Agendamento - TCC

## Descrição
Sistema de agendamento e gerenciamento de  consultas e exames para clinicas privadas.

## Bibliotecas utilizadas
- **Chart.js v4.5.0** — para gráficos de desempenho.

## Estrutura do Projeto
- `controllers/` — arquivos PHP que controlam a lógica da aplicação.
- `models/` — arquivos PHP que acessam o banco de dados.
- `views/` — arquivos HTML/JS/CSS/PHP que representam as telas.




Dashboard (Resumo geral)

👉 Fica só com os indicadores principais que te falei:

Total de exames

Agendados hoje

Pacientes ativos

Profissionais ativos

Exames concluídos no mês

Cancelamentos do mês

Taxa de comparecimento/ocupação no gráfico





1. Gráfico de Linha – Evolução Mensal de Consultas

O que mostra: Total de consultas ao longo dos meses (ou semanas).

Objetivo: Identificar tendências e picos de atendimento.

Dados que pode ter:

Eixo X: Meses do ano.

Eixo Y: Número de consultas.

Linha ou área mostrando crescimento ou queda nos agendamentos.

Pode destacar pontos de maior movimento ou meses com mais cancelamentos.


2. Gráfico de Barras – Consultas por Dia da Semana/mês

O que mostra: Quantidade de consultas agendadas para cada dia da semana.

Objetivo: Permitir que o profissional veja rapidamente quais dias estão mais cheios.

Dados que pode ter:

Dias da semana no eixo X (Seg, Ter, Qua, Qui, Sex).

Número de consultas no eixo Y.

Pode destacar barras com cores diferentes se o dia tiver consultas canceladas ou remarcadas.


3 Status das Consultas

Fatias: Concluídas, Agendadas, Canceladas.

Mostra rapidamente a proporção de cada status.

Ex.: 50% concluídas, 30% agendadas, 20% canceladas.