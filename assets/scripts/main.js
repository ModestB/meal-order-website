(function () {
    const submitBtn = document.getElementById('submit');
    const form = document.querySelector('form');

    try {
        submitBtn.addEventListener('click', () => {
            form.classList.add('was-validated')
        })
    } catch (error) {
        
    }
}());
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
}());

(function (){
    const saladsOptions = Array.from(document.querySelectorAll('.salads select'));
    saladsOptions.forEach((option) => {
        option.addEventListener('input', (e) => {
            const hasAddonsClass = Array.from(e.currentTarget.selectedOptions)[0].classList.value;
            let selectId = "";
            const hasAddons = hasAddonsClass.includes('True');
            if(hasAddonsClass.includes('True')){
                selectId = hasAddonsClass.substring(0, hasAddonsClass.indexOf('True'))
            }else{
                selectId = hasAddonsClass.substring(0, hasAddonsClass.indexOf('False'))
            }

            const addonSelect = document.getElementById(selectId);
            if(hasAddons){
                addonSelect.classList.remove('disable');
            }else{
                addonSelect.classList.add('disable');
            }
        })
    });
}());

(function (){
    const mainDishesOptions = Array.from(document.querySelectorAll('.main-dishes select'));
    mainDishesOptions.forEach((option) => {
        option.addEventListener('input', (e) => {
            const hasSideDishClass = Array.from(e.currentTarget.selectedOptions)[0].classList.value;
            let selectId = "";
            const hasSideDish = hasSideDishClass.includes('True');
            if(hasSideDishClass.includes('True')){
                selectId = hasSideDishClass.substring(0, hasSideDishClass.indexOf('True'))
            }else{
                selectId = hasSideDishClass.substring(0, hasSideDishClass.indexOf('False'))
            }
            console.log(selectId)

            const sideDishSelect = document.getElementById(selectId);
            if(hasSideDish){
                sideDishSelect.classList.remove('disable');
            }else{
                sideDishSelect.classList.add('disable');
            }
        })
    });
}());