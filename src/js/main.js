console.log("Sitio web cargado correctamente ✅");

document.querySelectorAll('.tarea').forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    setTimeout(() => {
        el.style.transition = 'all 0.4s ease';
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
    }, i * 100);
}); 
