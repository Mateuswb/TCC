<div class="logout-modal-overlay" id="logout-modal" style="display: none;">
  <div class="logout-modal-box">
    <a class="logout-btn-back" onclick="fecharLogoutModal()">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>

    <div class="logout-user-photo">
      <i class="fa-solid fa-user"></i>
    </div>

    <h2 id="logout-title">Encerrar sessão</h2>
    <p id="logout-subtitle">Deseja realmente sair da sua conta?</p>

    <div class="logout-btn-group">
      <a href="<?= BASE_URL ?>/autentica/logout.php" class="logout-btn logout-btn-confirm">
        <i class="fa-solid fa-right-from-bracket"></i> Sair
      </a>
      <button class="logout-btn logout-btn-cancel" onclick="fecharLogoutModal()">
        <i class="fa-solid fa-circle-xmark"></i> Cancelar
      </button>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
  :root {
    --logout-azul: #007bff;
    --logout-vermelho: #dc3545;
  }

  .logout-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    animation: logout-fadeInOverlay 0.3s ease;
  }

  @keyframes logout-fadeInOverlay {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .logout-modal-box {
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    padding: 40px 35px;
    text-align: center;
    width: 360px;
    position: relative;
    animation: logout-fadeInBox 0.4s ease;
  }

  @keyframes logout-fadeInBox {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
  }

  .logout-btn-back {
    position: absolute;
    top: 15px;
    left: 15px;
    color: var(--logout-azul);
    text-decoration: none;
    display: flex;
    align-items: center;
    font-size: 15px;
    gap: 6px;
    cursor: pointer;
  }

  .logout-btn-back:hover {
    color: #0056b3;
  }

  .logout-user-photo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #004d9bff, #0057c9ff);
    color: #fff;
    font-weight: 600;
    font-size: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    border: 3px solid #fff;
    box-shadow: 0 0 8px rgba(0,0,0,0.15);
  }

  #logout-title {
    margin-bottom: 10px;
    color: #222;
  }

  #logout-subtitle {
    color: #555;
    margin-bottom: 30px;
    font-size: 15px;
  }

  .logout-btn-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }

  .logout-btn {
    padding: 12px;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
    width: 220px;
    text-align: center;
    cursor: pointer;
    font-size: 15px;
    transition: transform 0.2s ease;
  }

  .logout-btn-confirm {
    background-color: var(--logout-vermelho);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .logout-btn-confirm:hover {
    background-color: #b02a37;
    transform: translateY(-2px);
  }

  .logout-btn-cancel {
    background-color: #0054a8ff;
  }

  .logout-btn-cancel:hover {
    background-color: #00458aff;
    transform: translateY(-2px);
  }
</style>

<script>
  function abrirModalLogout() {
    document.getElementById('logout-modal').style.display = 'flex';
  }

  function fecharLogoutModal() {
    document.getElementById('logout-modal').style.display = 'none';
  }

  window.addEventListener('click', function(e) {
    const modal = document.getElementById('logout-modal');
    if (e.target === modal) {
      fecharLogoutModal();
    }
  });
</script>
  