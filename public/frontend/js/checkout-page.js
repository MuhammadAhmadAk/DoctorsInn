(function () {
    function initializeCheckout() {
        const easypaisaDetails = document.getElementById('ep-details');
        const cardDetails = document.getElementById('card-details');
        const paymentLabels = document.querySelectorAll('.pm-label');
        const successModal = document.getElementById('success-modal');

        function setMethod(value) {
            easypaisaDetails?.classList.toggle('is-active', value === 'easypaisa');
            cardDetails?.classList.toggle('is-active', value === 'card');

            paymentLabels.forEach(label => {
                const selected = label.htmlFor === `pm-${value}`;
                label.classList.toggle('active', selected);
                label.querySelector('.pm-check')?.classList.toggle('is-active', selected);
            });
        }

        document.querySelectorAll('.pm-radio').forEach(radio => {
            radio.addEventListener('change', () => setMethod(radio.value));
        });
        setMethod(document.querySelector('.pm-radio:checked')?.value || 'easypaisa');

        document.querySelector('.screenshot-upload-trigger')?.addEventListener('click', () => {
            document.getElementById('ep-screenshot')?.click();
        });

        document.getElementById('ep-screenshot')?.addEventListener('change', event => {
            const file = event.currentTarget.files?.[0];
            if (!file) return;

            const reader = new FileReader();
            reader.addEventListener('load', result => {
                const previewImage = document.getElementById('ep-preview-img');
                const preview = document.getElementById('ep-preview');
                if (previewImage) previewImage.src = result.target.result;
                preview?.classList.add('is-visible');
            });
            reader.readAsDataURL(file);
        });

        document.getElementById('card-number')?.addEventListener('input', event => {
            const digits = event.currentTarget.value.replace(/\D/g, '').substring(0, 16);
            event.currentTarget.value = digits.replace(/(.{4})/g, '$1 ').trim();
        });

        document.getElementById('card-expiry')?.addEventListener('input', event => {
            let digits = event.currentTarget.value.replace(/\D/g, '').substring(0, 4);
            if (digits.length >= 2) digits = `${digits.substring(0, 2)} / ${digits.substring(2)}`;
            event.currentTarget.value = digits;
        });

        document.getElementById('place-order-btn')?.addEventListener('click', () => {
            const firstName = document.getElementById('first-name')?.value.trim();
            const lastName = document.getElementById('last-name')?.value.trim();
            const email = document.getElementById('email-address')?.value.trim();
            const phone = document.getElementById('phone-number')?.value.trim();

            if (!firstName || !lastName || !email || !phone) {
                window.alert('Please fill in all required fields (Name, Email, Phone).');
                return;
            }
            if (!email.includes('@') || !email.includes('.')) {
                window.alert('Please enter a valid email address.');
                return;
            }

            const reference = `DI-${new Date().getFullYear()}-${Math.floor(1000 + Math.random() * 9000)}`;
            document.getElementById('order-ref').textContent = reference;
            successModal?.classList.add('is-visible');
        });

        successModal?.addEventListener('click', event => {
            if (event.target === successModal) successModal.classList.remove('is-visible');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCheckout, { once: true });
    } else {
        initializeCheckout();
    }
})();