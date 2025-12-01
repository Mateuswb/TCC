<?php
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        switch ($flash['type']) {
            case 'success':
                $class = 'flash-success';
                break;
            case 'warning':
                $class = 'flash-warning';
                break;
            default:
                $class = 'flash-error';
                break;
        }
        echo "<div id='flashMessage' class='{$class}'>{$flash['message']}</div>";
    }
?>

<style>
    .flash-success, .flash-error, .flash-warning {
        position: fixed; 
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        padding: 15px 25px;
        border-radius: 5px;
        border: 1px solid;
        font-weight: 500;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        opacity: 1;
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .flash-success {
        background-color: #c8e0ffff;
        color: #000e3aff;
        border-color: #c3d8e6ff;
    }
    .flash-error {
        background-color: #f8d7da;
        color: #721c24;
        border-color: #f5c6cb;
    }
    .flash-warning {
        background-color: #fff9c4; 
        color: #665000ff;             
        border: 1px solid #ffeb3b;  
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
