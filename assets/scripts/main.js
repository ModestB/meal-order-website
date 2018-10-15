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
    try {
        document.getElementById("msg").style.display = 'none';
    } catch (error) {
        
    }
}, 5000);

(function (){
    const checkBoxes = Array.from(document.querySelectorAll('.switch > input'));
    let idRaw, day, soupElement, saladsElement; 
    checkBoxes.forEach((box) => {
        if(box.checked){
            idRaw = box.parentNode.id;
            day = idRaw.substring(0, idRaw.indexOf('Switch'));
            soupElement = document.querySelector(`#${day} .soup`)
            saladsElement = document.querySelector(`#${day} .salads`)

            soupElement.classList.toggle('disable');
            saladsElement.classList.toggle('disable');
        }
        box.addEventListener('input', (e) => {
            idRaw = e.target.parentNode.id;
            day = idRaw.substring(0, idRaw.indexOf('Switch'));
            soupElement = document.querySelector(`#${day} .soup`)
            saladsElement = document.querySelector(`#${day} .salads`)

            soupElement.classList.toggle('disable');
            saladsElement.classList.toggle('disable');
        })
    })
}());

(function (){
    const saladsOptions = Array.from(document.querySelectorAll('.salads select'));
    const checkBoxes = Array.from(document.querySelectorAll('.switch > input'));
    let hasAddonsClass, selectId, hasAddons, addonSelect;

    checkBoxes.forEach((box) => {
        if(box.checked){
            saladsOptions.forEach((option) => {
                if(option.selectedOptions[0].classList.value){
                    hasAddonsClass = option.selectedOptions[0].classList.value;
                    hasAddons = hasAddonsClass.includes('True');
                    if(hasAddons){
                        selectId = hasAddonsClass.substring(0, hasAddonsClass.indexOf('True'))
                    }else{
                        selectId = hasAddonsClass.substring(0, hasAddonsClass.indexOf('False'))
                    }
        
                    addonSelect = document.getElementById(selectId);
                    if(hasAddons){
                        addonSelect.classList.remove('disable');
                    }else{
                        addonSelect.classList.add('disable');
                    }
                }
            });
        }
    })
    saladsOptions.forEach((option) => {
        option.addEventListener('input', (e) => {
            hasAddonsClass = Array.from(e.currentTarget.selectedOptions)[0].classList.value;
            selectId = "";
            hasAddons = hasAddonsClass.includes('True');
            if(hasAddonsClass.includes('True')){
                selectId = hasAddonsClass.substring(0, hasAddonsClass.indexOf('True'))
            }else{
                selectId = hasAddonsClass.substring(0, hasAddonsClass.indexOf('False'))
            }

            addonSelect = document.getElementById(selectId);
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
    let hasSideDishClass,selectId, hasSideDish, sideDishSelect;
    mainDishesOptions.forEach((option) => {
        if(option.selectedOptions[0].classList.value){
            hasSideDishClass = option.selectedOptions[0].classList.value;
            selectId = "";
            hasSideDish = hasSideDishClass.includes('True');
            if(hasSideDishClass.includes('True')){
                selectId = hasSideDishClass.substring(0, hasSideDishClass.indexOf('True'))
            }else{
                selectId = hasSideDishClass.substring(0, hasSideDishClass.indexOf('False'))
            }

            sideDishSelect = document.getElementById(selectId);
            if(hasSideDish){
                sideDishSelect.classList.remove('disable');
            }else{
                sideDishSelect.classList.add('disable');
            }
        }

        option.addEventListener('input', (e) => {
            hasSideDishClass = Array.from(e.currentTarget.selectedOptions)[0].classList.value;
            selectId = "";
            hasSideDish = hasSideDishClass.includes('True');
            if(hasSideDishClass.includes('True')){
                selectId = hasSideDishClass.substring(0, hasSideDishClass.indexOf('True'))
            }else{
                selectId = hasSideDishClass.substring(0, hasSideDishClass.indexOf('False'))
            }

            sideDishSelect = document.getElementById(selectId);
            if(hasSideDish){
                sideDishSelect.classList.remove('disable');
            }else{
                sideDishSelect.classList.add('disable');
            }
        })
    });
}());

function showActivePageButton() {
    const pagesButtons = Array.from(document.querySelectorAll('.heading-text'));
    pagesButtons.forEach((pageButton) => {
        pageButton.classList.toggle('heading-text-inactive')
    });
};

function showActivePage() {
    const pages = Array.from(document.querySelectorAll('.admin-page, .statistics-page'));
    pages.forEach((page) => {
        page.classList.toggle('d-none');
    });
};

(function () {
    const pagesButtons = Array.from(document.querySelectorAll('.heading-text'));
    pagesButtons.forEach((pageButton) => {
        pageButton.addEventListener('click', () => {
            showActivePageButton();
            showActivePage();
        });
    });
}());