SISTEMA PARA GESTÃO MÉDICA: MEDHUB
1. Descrição do Sistema

O MEDHUB é um sistema web desenvolvido para o gerenciamento de consultas e exames em clínicas privadas de saúde.

A plataforma permite o agendamento, controle e acompanhamento de atendimentos médicos, proporcionando maior organização, eficiência operacional e melhoria na experiência de pacientes, profissionais de saúde e administradores.

O sistema foi projetado com foco em usabilidade, segurança da informação e organização estrutural baseada no padrão arquitetural MVC (Model-View-Controller).

2. Tecnologias e Bibliotecas Utilizadas

O desenvolvimento do sistema utilizou tecnologias voltadas ao desenvolvimento web backend e frontend, garantindo desempenho, interatividade e organização do código.

Bibliotecas externas

Chart.js v4.5.0
Biblioteca JavaScript utilizada para a geração de gráficos dinâmicos, permitindo a visualização de indicadores de desempenho, estatísticas de atendimentos e relatórios administrativos.

FullCalendar v6.1.19
Biblioteca JavaScript responsável pela criação de calendários interativos para agendamento de consultas e visualização de compromissos médicos.

3. Estrutura do Projeto

O sistema foi organizado seguindo uma arquitetura baseada no padrão MVC, visando separação de responsabilidades e melhor manutenção do código.

/controllers
/models
/views
/libs
📁 controllers/

Contém os arquivos PHP responsáveis pelo controle da lógica da aplicação.
Gerenciam requisições, regras de negócio e comunicação entre Models e Views.

📁 models/

Arquivos PHP responsáveis pela manipulação e acesso aos dados no banco de dados.
Implementam consultas, inserções, atualizações e exclusões de registros utilizando PDO.

📁 views/

Arquivos responsáveis pela interface do sistema.
Incluem HTML, CSS, JavaScript e trechos de PHP para renderização dinâmica de informações.

📁 libs/

Contém as bibliotecas externas utilizadas no projeto, como ferramentas para gráficos e calendários interativos.
