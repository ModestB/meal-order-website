(function () {
    const submitBtn = document.getElementById('submit');
    const form = document.querySelector('form');
    submitBtn.addEventListener('click', () => {
        form.classList.add('was-validated')
    })
}())