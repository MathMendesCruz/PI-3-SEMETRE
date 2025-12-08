/**
 * Contact Form Module
 * Handles contact form submission and feedback
 */

export const ContactFormModule = {
    init() {
        const contactForm = document.getElementById('contact-form');
        const successMessage = document.getElementById('success-message');
        const submitBtn = document.getElementById('submit-btn');

        if (!contactForm) return;

        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const email = contactForm.querySelector('input[name="email"]').value;
            const message = contactForm.querySelector('input[name="message"]').value;

            if (!email || !message) {
                alert('Por favor, preencha todos os campos.');
                return;
            }

            this.handleSubmit(contactForm, successMessage, submitBtn);
        });
    },

    handleSubmit(form, successMessage, submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';
        submitBtn.style.opacity = '0.6';

        setTimeout(() => {
            form.reset();
            form.style.display = 'none';
            successMessage.style.display = 'block';
            successMessage.classList.add('show');

            setTimeout(() => {
                form.style.display = 'block';
                successMessage.style.display = 'none';
                successMessage.classList.remove('show');

                submitBtn.disabled = false;
                submitBtn.textContent = 'Enviar';
                submitBtn.style.opacity = '1';
            }, 5000);
        }, 1500);
    }
};
