

<header>
  <div class="menu-btn" id="menu-btn">
    <i class="fas fa-bars"></i>
  </div>

  <div class="search-bar">
    <i class="fas fa-search"></i>
    <input type="text" placeholder="Buscar paciente, exame, profissional...">
  </div>

  <div class="profile" id="profile-btn">
    <div class="user-info">
      <span id="nome-paciente">Nome Pacienttte</span>
      <div class="avatar">MB</div>
    </div>
  </div>
</header>

<!-- MENU SUSPENSO -->
<div class="profile-menu" id="profile-menu">
  <div id="profile-header">
    <div class="avatar-large">H</div>
    <span class="profile-name">Nome Pacienttte</span>
    <span class="close-menu" id="close-menu">&times;</span>
  </div>
  <ul>
  <li onclick="location.href='<?= BASE_URL ?>/views/paciente/perfil.php'">
    <i class="fas fa-user"></i> Perfil
  </li>
  <li onclick="location.href='#'">
    <i class="fas fa-notes-medical"></i> Histórico de Consulta
  </li>
  <li onclick="location.href='#'">
    <i class="fas fa-file-medical-alt"></i> Histórico de Exames
  </li>
  <li onclick="location.href='<?= BASE_URL ?>/views/logout/logout.php'">
    <i class="fas fa-sign-out-alt"></i> Sair
  </li>
</ul>
</div>

<style>
/* HEADER EXISTENTE */
header {
  background-color: #fff;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  border-bottom: 1px solid #e0e0e0;
  position: fixed;
  top: 0;
  left: 250px;
  right: 0;
  z-index: 10;
}

.search-bar input {
  width: 350px;
  padding: 8px 12px;
  border-radius: 25px;
  border: 1px solid #ccc;
  outline: none;
  font-size: 14px;
}

.user-info {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.user-info span {
  margin-right: 10px;
  font-weight: 600;
  color: #003366;
}

.user-info .avatar {
  background-color: #003366;
  color: #fff;
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-weight: 600;
}
/* MENU SUSPENSO */
.profile-menu {
  position: absolute;
  top: 75px;
  right: 30px;
  width: 300px;
  background: #fdfdfd;
  border: 1px solid #ccc;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
  display: none;
  font-family: "Poppins", sans-serif;
  z-index: 20;
  overflow: hidden;
}

#profile-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #003366;
  color: #fff;
  padding: 15px;
  position: relative;
}

.avatar-large {
  width: 40px;
  height: 40px;
  background: #fff;
  color: #003366;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  margin-right: 10px;
}

.profile-name {
  flex: 1;
  font-weight: 600;
}

.close-menu {
  cursor: pointer;
  font-size: 18px;
}

.profile-menu ul {
  list-style: none;
  margin: 0;
  padding: 10;
}

.profile-menu ul li {
  padding: 18px 10px;
  display: flex;
  align-items: center;
  font-size: 18px;
  cursor: pointer;
  color: #003366;
}

.profile-menu ul li i {
  margin-right: 10px;
}

.profile-menu ul li:hover {
  background: #e6f0ff;
  border-left: 4px solid #003366;
}
</style>

<script>
// Mostrar/ocultar menu ao clicar no perfil
const profileBtn = document.getElementById('profile-btn');
const profileMenu = document.getElementById('profile-menu');

profileBtn.addEventListener('click', () => {
  profileMenu.style.display = profileMenu.style.display === 'block' ? 'none' : 'block';
});

// Fechar menu clicando fora
document.addEventListener('click', function(event) {
  if (!profileBtn.contains(event.target) && !profileMenu.contains(event.target)) {
    profileMenu.style.display = 'none';
  }
});
</script>
