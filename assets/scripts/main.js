(function () {
    const submitBtn = document.getElementById('submit');
    const form = document.querySelector('form');

    try {
        submitBtn.addEventListener('click', () => {
            form.classList.add('was-validated')
        })
    } catch (error) {
        
    }
}())
setTimeout(function() {
    document.getElementById("msg").style.display = 'none';
}, 5000);

