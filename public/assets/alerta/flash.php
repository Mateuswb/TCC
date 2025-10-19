<?php
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $class = $flash['type'] === 'success' ? 'flash-success' : 'flash-error';
    echo "<div id='flashMessage' class='{$class}'>{$flash['message']}</div>";
}
?>

<style>
.flash-success, .flash-error {
    position: fixed; /* Fica sobre os outros elementos */
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999; /* Sempre acima de tudo */
    padding: 15px 25px;
    border-radius: 5px;
    border: 1px solid;
    font-weight: 500;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    opacity: 1;
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.flash-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}

.flash-error {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const flash = document.getElementById('flashMessage');
    if(flash) {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateX(-50%) translateY(-20px)';
            setTimeout(() => flash.remove(), 400);
        }, 3000);
    }
});
</script>
