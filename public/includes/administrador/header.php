    <header>
    <div class="menu-btn" id="menu-btn">
      <i class="fas fa-bars"></i>
    </div>

    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Buscar paciente, exame, profissional...">
    </div>

    <div class="profile">
        <img src="<?= BASE_URL ?>/public/assets/icones/icon_admin.png" alt="user">
        <div><strong>Perfil Admin</strong><br><small>Administrador</small></div>
    </div>
  </header>


  <style>

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

    /* Header */
    .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #085274ff;
    color: #fff;
    padding: 15px 30px;
    }

    .header input {
    padding: 8px 12px;
    border: none;
    border-radius: 20px;
    outline: none;
    width: 200px;
    }

    .profile {
    display: flex;
    align-items: center;
    gap: 10px;
    }

    .profile img {
      width: 35px;
      height: 35px;
      border-radius: 2  0%;
    }

    .menu-btn {
    cursor: pointer;
    font-size: 20px;
    margin-right: 15px;
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
  </style>