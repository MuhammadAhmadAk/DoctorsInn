(function () {
    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');

        if (!toast || !toastMessage) return;

        toastMessage.textContent = message;
        toast.classList.remove('d-none');
        toast.classList.add('d-flex');

        window.setTimeout(() => {
            toast.classList.add('d-none');
            toast.classList.remove('d-flex');
        }, 3000);
    }

    function switchTab(tabId) {
        document.querySelectorAll('.profile-nav-tabs .nav-link').forEach(button => {
            button.classList.toggle('active', button.dataset.profileTab === tabId);
        });
        document.querySelectorAll('.tab-pane-content').forEach(pane => {
            pane.classList.toggle('active', pane.id === `pane-${tabId}`);
        });
    }

    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(`${inputId}-icon`);

        if (!input || !icon) return;

        const showPassword = input.type === 'password';
        input.type = showPassword ? 'text' : 'password';
        icon.className = showPassword ? 'fal fa-eye-slash' : 'fal fa-eye';
    }

    function submitProfileForm(event, successMessage) {
        event.preventDefault();
        const submitButton = event.target.querySelector('button[type="submit"]');
        if (!submitButton) return;

        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<i class="fal fa-spinner fa-spin me-2"></i>Saving...';
        submitButton.disabled = true;

        window.setTimeout(() => {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
            showToast(successMessage);

            if (event.target.id === 'personalInfoForm') {
                const firstName = document.getElementById('firstName')?.value || '';
                const lastName = document.getElementById('lastName')?.value || '';
                const email = document.getElementById('emailAddr')?.value || '';
                const studentName = document.querySelector('.student-name');
                const studentEmail = document.querySelector('.student-email');

                if (studentName) studentName.textContent = `${firstName} ${lastName}`;
                if (studentEmail) studentEmail.textContent = email;
            }
        }, 1000);
    }

    function downloadInvoice(courseName, amount, date) {
        const invoice = [
            '-------------------------------------------',
            '              INVOICE                      ',
            '-------------------------------------------',
            'Site: DoctorsInnElite',
            `Course: ${courseName}`,
            `Amount Paid: ${amount}`,
            `Date: ${date}`,
            'Status: Paid',
            '-------------------------------------------',
            'Thank you for your purchase!'
        ].join('\n');
        const link = document.createElement('a');
        const url = URL.createObjectURL(new Blob([invoice], { type: 'text/plain' }));
        link.href = url;
        link.download = `invoice-${courseName.toLowerCase().replace(/ /g, '-')}.txt`;
        link.className = 'd-none';
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
        showToast('Preparing invoice for download...');
    }

    function initializeCourseProgress() {
        const courseLessonsCount = {
            'mdcat-reboot-60-day': 14,
            'mdcat-2026-parvaaz-flps': 10,
            'mdcat-2026-al-fateh-cts': 14,
            'amc-prep-course-2026-ansaar': 12,
            'kts-mock-test-doctorsinnelite': 8
        };

        Object.entries(courseLessonsCount).forEach(([slug, total]) => {
            let completed = [];

            try {
                const stored = localStorage.getItem(`completed_lessons_${slug}`);
                if (stored) completed = JSON.parse(stored);
            } catch (error) {
                completed = [];
            }

            const count = completed.length;
            const percent = Math.min(100, Math.round((count / total) * 100));
            const progressBar = document.getElementById(`course-prog-bar-${slug}`);
            const progressText = document.getElementById(`course-prog-txt-${slug}`);

            if (!progressBar || !progressText) return;

            progressBar.style.width = `${count > 0 ? percent : 0}%`;
            progressText.textContent = count > 0 ? `${percent}% Completed (${count}/${total})` : '0% Completed';

            if (percent === 100) {
                progressBar.classList.add('bg-success');
                progressText.className = 'fw-bold text-success';
            }
        });
    }

    document.addEventListener('click', event => {
        const tabButton = event.target.closest('[data-profile-tab]');
        if (tabButton) switchTab(tabButton.dataset.profileTab);

        const passwordButton = event.target.closest('[data-password-target]');
        if (passwordButton) togglePassword(passwordButton.dataset.passwordTarget);

        const invoiceButton = event.target.closest('.invoice-btn');
        if (invoiceButton) {
            downloadInvoice(invoiceButton.dataset.courseName, invoiceButton.dataset.amount, invoiceButton.dataset.date);
        }
    });

    document.getElementById('personalInfoForm')?.addEventListener('submit', event => {
        submitProfileForm(event, event.currentTarget.dataset.successMessage);
    });

    document.getElementById('changePasswordForm')?.addEventListener('submit', event => {
        event.preventDefault();
        const newPassword = document.getElementById('newPass').value;
        const confirmPassword = document.getElementById('confirmNewPass').value;

        if (newPassword !== confirmPassword) {
            window.alert('New password and confirmation do not match!');
            return;
        }
        if (newPassword.length < 8) {
            window.alert('Password must be at least 8 characters long.');
            return;
        }

        submitProfileForm(event, 'Password successfully updated!');
        event.currentTarget.reset();
    });

    document.getElementById('imageUpload')?.addEventListener('change', event => {
        const file = event.currentTarget.files?.[0];
        if (!file) return;

        const reader = new FileReader();
        reader.addEventListener('load', result => {
            const profileImage = document.getElementById('profileImage');
            if (profileImage) profileImage.src = result.target.result;
            showToast('Profile photo updated!');
        });
        reader.readAsDataURL(file);
    });

    initializeCourseProgress();
})();