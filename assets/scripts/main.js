// ON submit adds was-validated class on FORM
// was-validated class initialize fomr validation style
(function () {
    const submitBtn = document.getElementById('submit');
    const form = document.querySelector('form');

    try {
        submitBtn.addEventListener('click', () => {
            form.classList.add('was-validated');
        });
    } catch (error) {
        
    };
}());

// Message with $_SESSION['message'] disapears after 5s
(function () {
    setTimeout(function() {
        try {
            document.getElementById("msg").style.display = 'none';
        } catch (error) {
            
        };
    }, 5000);
}());

// idRaw --> id of checkbox label
// day --> current day of the week used to target correct soup or salad element
function showCorrectStarter(idRaw){
    let day, soupElement, saladsElement;

    day = idRaw.substring(0, idRaw.indexOf('Switch'));
    soupElement = document.querySelector(`#${day} .soup`);
    saladsElement = document.querySelector(`#${day} .salads`);

    soupElement.classList.toggle('disable');
    saladsElement.classList.toggle('disable');
};

(function (){
    const checkBoxes = Array.from(document.querySelectorAll('.switch > input')); 
    checkBoxes.forEach((box) => {
        box.addEventListener('input', (e) => {
            idRaw = e.target.parentNode.id;
            showCorrectStarter(idRaw);
        });
    });
}());

// When diffrent select option is selected CHECKS current selected option class
// Option class can be either weekDayAdditionalOptionsTrue or weekDayAdditionalOptionsFalse
// IF option class has word TRUE 
// Substrings AdditionalOptions select id from option class 
// weekDayAdditionalOptionsTrue --(becomes)--> weekDayAdditionalOptions
// weekDayAdditionalOptions is id of specific day Additional option selector
// Using id gets Additional option selector and either SHOWS it or DISABLES it
function displayCorrectSelect(selector){
    const dishesOptions = Array.from(document.querySelectorAll(selector));
    let additionalOptionsClass,selectId, hasSideDish, sideDishSelect;

    dishesOptions.forEach((option) => {
        option.addEventListener('input', (e) => {
            additionalOptionsClass = Array.from(e.currentTarget.selectedOptions)[0].classList.value;
            selectId = "";
            hasAdditionalOptions = additionalOptionsClass.includes('True');
            if( hasAdditionalOptions){
                selectId = additionalOptionsClass.substring(0, additionalOptionsClass.indexOf('True'))
            }else{
                selectId = additionalOptionsClass.substring(0, additionalOptionsClass.indexOf('False'))
            }

            additionalOptionsSelect = document.getElementById(selectId);
            if(hasAdditionalOptions){
                additionalOptionsSelect.classList.remove('disable');
            }else{
                additionalOptionsSelect.classList.add('disable');
            }
        })
    });
}

displayCorrectSelect('.salads-select select')
displayCorrectSelect('.main-dishes select')

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