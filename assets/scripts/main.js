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

(function (){
    const checkBoxes = Array.from(document.querySelectorAll('.switch > input'));
    checkBoxes.forEach((box) => {
        box.addEventListener('input', (e) => {
            const idRaw = e.target.parentNode.id;
            const day = idRaw.substring(0, idRaw.indexOf('Switch'));
            const soupElement = document.querySelector(`#${day} .soup`)
            const saladsElement = document.querySelector(`#${day} .salads`)

            soupElement.classList.toggle('disable');
            saladsElement.classList.toggle('disable');
        })
    })
}())