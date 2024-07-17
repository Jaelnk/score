document.addEventListener('DOMContentLoaded', function () {
    const wizardNumbered = document.querySelector('.wizard-numbered');
    if (wizardNumbered) {
        const wizardNumberedBtnNextList = [].slice.call(wizardNumbered.querySelectorAll('.btn-next'));
        const wizardNumberedBtnPrevList = [].slice.call(wizardNumbered.querySelectorAll('.btn-prev'));
        const numberedStepper = new Stepper(wizardNumbered, { linear: false });

        wizardNumberedBtnNextList.forEach(wizardNumberedBtnNext => {
            wizardNumberedBtnNext.addEventListener('click', event => {
                event.preventDefault();
                const form = document.querySelector('form');
                if (form.checkValidity()) {
                    numberedStepper.next();
                } else {
                    form.reportValidity();
                    const firstInvalidField = form.querySelector(':invalid');
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                }
            });
        });

        wizardNumberedBtnPrevList.forEach(wizardNumberedBtnPrev => {
            wizardNumberedBtnPrev.addEventListener('click', event => {
                numberedStepper.previous();
            });
        });
    }
});
