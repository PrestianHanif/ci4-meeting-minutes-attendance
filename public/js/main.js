document.addEventListener('DOMContentLoaded', function () {

    // ─── Re-init Lucide Icons ───
    if (typeof lucide !== 'undefined') lucide.createIcons();

    // ─── FAQ Accordion ───
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const btn = item.querySelector('.faq-btn');
        const content = item.querySelector('.faq-content');

        if (!btn || !content) return;

        btn.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');

            // Close all
            faqItems.forEach(other => {
                other.classList.remove('active');
                const oc = other.querySelector('.faq-content');
                if (oc) oc.style.maxHeight = null;
            });

            // Toggle clicked
            if (!isOpen) {
                item.classList.add('active');
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });

    // ─── Rentang Umur Dropdown Toggle ───
    const rentangSelect = document.getElementById('rentang_umur');
    if (rentangSelect) {
        const triggerChange = function () {
            if (typeof window.handleRentangUmurChange === 'function') {
                window.handleRentangUmurChange(rentangSelect);
            } else {
                const otherWrap = document.getElementById('rentangUmurOtherWrap');
                const otherInput = document.getElementById('rentang_umur_other');
                if (!otherWrap) return;
                if (rentangSelect.value === 'Lainnya') {
                    otherWrap.classList.remove('hidden');
                    otherWrap.style.setProperty('display', 'block', 'important');
                    if (otherInput) {
                        otherInput.setAttribute('required', 'required');
                        setTimeout(() => otherInput.focus(), 50);
                    }
                } else {
                    otherWrap.classList.add('hidden');
                    otherWrap.style.setProperty('display', 'none', 'important');
                    if (otherInput) {
                        otherInput.removeAttribute('required');
                        otherInput.value = '';
                    }
                }
            }
        };

        rentangSelect.addEventListener('change', triggerChange);
        if (rentangSelect.value === 'Lainnya') {
            triggerChange();
        }
    }

    // ─── Lead Form Submission ───
    const leadForm = document.getElementById('leadForm');
    const submitBtn = document.getElementById('submitBtn');
    const successMessage = document.getElementById('successMessage');

    if (leadForm && submitBtn) {
        leadForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = `
                <svg class="spin-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="width:20px;height:20px;animation:spin 1s linear infinite;">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" style="opacity:0.25;"></circle>
                    <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" style="opacity:0.75;"></path>
                </svg>
                <span>Memproses...</span>
            `;
            submitBtn.disabled = true;

            try {
                const formData = new FormData(leadForm);
                const rentangSelect = document.getElementById('rentang_umur');
                const rentangOther = document.getElementById('rentang_umur_other');
                if (rentangSelect && rentangSelect.value === 'Lainnya') {
                    if (rentangOther && rentangOther.value.trim()) {
                        formData.set('rentang_umur', rentangOther.value.trim());
                    }
                }

                const submitUrl = leadForm.getAttribute('action') || '/LP-yatim/public/submit';
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    leadForm.style.display = 'none';

                    const donationModal = document.getElementById('donationModal');
                    const donationLeadId = document.getElementById('donationLeadId');
                    const registeredEmailSpan = document.getElementById('registeredEmail');

                    if (registeredEmailSpan && result.email) {
                        registeredEmailSpan.textContent = result.email;
                    }

                    if (donationModal && donationLeadId) {
                        donationLeadId.value = result.lead_id || '';
                        donationModal.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            donationModal.classList.add('open');
                        });
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    } else if (successMessage) {
                        successMessage.classList.remove('hidden');
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                } else {
                    showError(result.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    resetBtn();
                }
            } catch (err) {
                console.error(err);
                showError('Terjadi kesalahan koneksi. Silakan coba lagi.');
                resetBtn();
            }

            function resetBtn() {
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        });
    }

    // ─── Error Toast Helper ───
    function showError(msg) {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position:fixed; bottom:24px; left:50%; transform:translateX(-50%);
            background:rgba(153,27,27,0.95); color:#fca5a5;
            padding:14px 24px; border-radius:12px; font-size:0.9rem; font-weight:600;
            z-index:9999; border:1px solid rgba(239,68,68,0.3);
            backdrop-filter:blur(10px); box-shadow:0 8px 32px rgba(0,0,0,0.4);
            animation:slideUp 0.3s ease;
        `;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }

    // ─── Donation Modal Logic ───
    const donationModal = document.getElementById('donationModal');
    const btnYesDonate = document.getElementById('btnYesDonate');
    const btnNoDonate = document.getElementById('btnNoDonate');
    const btnBackDonate = document.getElementById('btnBackDonate');
    const donationStep1 = document.getElementById('donationStep1');
    const donationStep2 = document.getElementById('donationStep2');
    const donationMethod = document.getElementById('donationMethod');
    const bankDetails = document.getElementById('bankDetails');
    const qrisDetails = document.getElementById('qrisDetails');
    const donationForm = document.getElementById('donationForm');
    const successMessageMain = document.getElementById('successMessage');

    function closeModal() {
        if (donationModal) {
            donationModal.classList.remove('open');
            setTimeout(() => {
                if (!donationModal.classList.contains('open')) {
                    donationModal.classList.add('hidden');
                }
            }, 300);
        }
    }

    // Click outside to close
    if (donationModal) {
        donationModal.addEventListener('click', function (e) {
            if (e.target === donationModal) closeModal();
        });
    }

    if (btnNoDonate) {
        btnNoDonate.addEventListener('click', () => {
            closeModal();
            if (successMessageMain) {
                successMessageMain.classList.remove('hidden');
                successMessageMain.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }

    if (btnYesDonate) {
        btnYesDonate.addEventListener('click', () => {
            donationStep1.classList.add('hidden');
            donationStep2.classList.remove('hidden');
        });
    }

    if (btnBackDonate) {
        btnBackDonate.addEventListener('click', () => {
            donationStep2.classList.add('hidden');
            donationStep1.classList.remove('hidden');
        });
    }

    // Payment method toggle
    if (donationMethod) {
        donationMethod.addEventListener('change', (e) => {
            if (bankDetails) bankDetails.classList.add('hidden');
            if (qrisDetails) qrisDetails.classList.add('hidden');

            if (e.target.value === 'BSI' && bankDetails) {
                bankDetails.classList.remove('hidden');
            } else if (e.target.value === 'QRIS' && qrisDetails) {
                qrisDetails.classList.remove('hidden');
            }
        });
    }

    // Quick amount buttons hover effect
    document.querySelectorAll('.quick-amount').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.borderColor = 'rgba(212,168,71,0.4)';
            btn.style.color = '#d4a847';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.borderColor = 'rgba(212,168,71,0.15)';
            btn.style.color = '#9e8a82';
        });
    });

    // ─── Donation Form Submit ───
    if (donationForm) {
        donationForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitDonBtn = document.getElementById('submitDonationBtn');
            const origHTML = submitDonBtn.innerHTML;

            submitDonBtn.innerHTML = '<span>Memproses...</span>';
            submitDonBtn.disabled = true;

            try {
                const formData = new FormData(donationForm);
                const donUrl = donationForm.getAttribute('action') || '/LP-yatim/public/submit-donation';
                const response = await fetch(donUrl, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    const amount = document.getElementById('donationAmount').value;
                    const methodText = donationMethod.options[donationMethod.selectedIndex].text;
                    const waNumber = '628980155558';

                    const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });
                    const amountStr = formatter.format(amount);

                    const text = `Halo Admin, saya ingin mengkonfirmasi donasi saya:\n\nNominal: ${amountStr}\nMetode: ${methodText}\n\nBerikut saya lampirkan bukti transfernya.`;
                    window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(text)}`, '_blank');

                    closeModal();
                    if (successMessageMain) {
                        successMessageMain.classList.remove('hidden');
                        successMessageMain.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    showError(result.message || 'Terjadi kesalahan. Coba lagi.');
                    submitDonBtn.innerHTML = origHTML;
                    submitDonBtn.disabled = false;
                }
            } catch (err) {
                console.error(err);
                showError('Terjadi kesalahan koneksi.');
                submitDonBtn.innerHTML = origHTML;
                submitDonBtn.disabled = false;
            }
        });
    }

    // ─── Auto Open Donation Modal from Email / Link (?donate=1 or #donasi) ───
    try {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('donate') === '1' || window.location.hash === '#donasi' || window.location.hash === '#donate') {
            if (donationModal) {
                if (donationStep1) donationStep1.classList.add('hidden');
                if (donationStep2) donationStep2.classList.remove('hidden');
                donationModal.classList.remove('hidden');
                requestAnimationFrame(() => {
                    donationModal.classList.add('open');
                });
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        }
    } catch (e) {
        console.warn('URL parsing error:', e);
    }

    // ─── CSS for spin animation ───
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes slideUp { from { opacity:0; transform:translate(-50%, 20px); } to { opacity:1; transform:translate(-50%, 0); } }
    `;
    document.head.appendChild(style);
});
