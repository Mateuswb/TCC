<footer>
  <div class="footer-container">
    <div class="footer-left">
      <strong>Criadores:</strong> Henrique Luiz e Mateus Warmling
    </div>

    <div class="footer-center">
      Gestão de Consultas e Exames com Agilidade e Segurança<br>
      © 2025 <span>MedHub</span> | Direitos reservados
    </div>

    <div class="footer-right">
      <button class="btn-fale">💬 Fale Conosco</button>
    </div>
  </div>
</footer>

<style>
  /* ===== RODAPÉ ===== */
footer {
  position: fixed;
  bottom: 0;
  left: 250px; /* respeita o tamanho da sidebar */
  right: 0;
  background-color: #003366;
  color: #fff;
  font-size: 13px;
  padding: 10px 30px;
  z-index: 9999;
  box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
}

/* Container flexível */
.footer-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

/* Texto da esquerda */
.footer-left {
  font-size: 13px;
  font-weight: 500;
}

/* Texto central */
.footer-center {
  text-align: center;
  flex: 1;
  font-size: 13px;
  line-height: 1.4;
}

/* Botão “Fale Conosco” */
.btn-fale {
  background-color: #004aad;
  color: #fff;
  border: none;
  border-radius: 20px;
  padding: 8px 20px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s;
}

.btn-fale:hover {
  background-color: #003a8c;
}

/* Responsivo */
@media (max-width: 768px) {
  footer {
    left: 0; /* sidebar recolhida no mobile */
    text-align: center;
  }

  .footer-container {
    flex-direction: column;
    gap: 8px;
  }

  .footer-right {
    order: 3;
  }
}

</style>