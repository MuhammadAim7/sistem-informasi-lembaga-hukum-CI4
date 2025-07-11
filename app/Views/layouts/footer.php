<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    const BASE_URL = "<?= base_url('/') ?>"; // <- Diperlukan agar JS tahu base URL server
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Animasi Fade-in Halaman
        document.body.style.opacity = 1;

        // 2. Fungsionalitas Modal Login/Register
        const loginModal = document.getElementById('loginModal');
        const openLoginBtn = document.getElementById('openLoginBtn');
        const closeButton = document.querySelector('.close-button');
        const tabButtons = document.querySelectorAll('.modal-tabs .tab-button'); // Lebih spesifik
        const authForms = document.querySelectorAll('.auth-form');
        const switchLinks = document.querySelectorAll('.switch-form a');

        // Membuka Modal
        openLoginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            // Reset form dan tampilkan tab login secara default saat dibuka
            document.getElementById('loginForm').reset();
            document.getElementById('registerForm').reset();
            switchTab('login');
        });

        // Menutup Modal dari Tombol Close
        closeButton.addEventListener('click', () => {
            loginModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        // Menutup Modal saat mengklik di luar konten modal
        window.addEventListener('click', (event) => {
            if (event.target === loginModal) {
                loginModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        // Fungsi untuk mengganti tab
        function switchTab(tabName) {
            tabButtons.forEach(btn => {
                if (btn.dataset.tab === tabName) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
            authForms.forEach(form => {
                if (form.id === tabName + 'Form') {
                    form.classList.add('active-form');
                } else {
                    form.classList.remove('active-form');
                }
            });
        }

        // Mengganti Tab Login/Register
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                switchTab(button.dataset.tab);
            });
        });

        // Mengganti Form dari link "Belum punya akun?" / "Sudah punya akun?"
        switchLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                switchTab(e.target.dataset.switch);
            });
        });


        // 3. Penanganan Form Login dan Register (AJAX)
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        // Fungsi untuk menampilkan pesan status (misal: sukses/gagal)
        function showStatusMessage(message, type = 'success') {
            const statusDiv = document.createElement('div');
            statusDiv.classList.add('status-message', type);
            statusDiv.textContent = message;
            statusDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: ${type === 'success' ? '#4CAF50' : '#f44336'};
                color: white;
                padding: 15px 20px;
                border-radius: 5px;
                z-index: 9999;
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                animation: fadeOut 5s forwards;
            `;
            document.body.appendChild(statusDiv);

        }

        // Penanganan Submit Form Register
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const fullName = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const username = document.getElementById('registerUsername') ? document.getElementById('registerUsername').value : ''; // Pastikan ada input username di HTML jika diperlukan
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Clear previous errors
            clearFormErrors(registerForm);

            try {
                const response = await fetch('<?= base_url('register') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest' // Penting untuk CI4 Request Validation
                    },
                    body: JSON.stringify({ full_name: fullName, email: email, username: username, password: password, confirm_password: confirmPassword })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    showStatusMessage(data.message, 'success');
                    registerForm.reset();
                    setTimeout(() => {
                        switchTab('login'); // Otomatis pindah ke tab login setelah register berhasil
                    }, 1000); // Tunggu 1 detik
                } else {
                    showStatusMessage(data.message || 'Registrasi gagal.', 'error');
                    if (data.errors) {
                        displayFormErrors(registerForm, data.errors);
                    }
                }
            } catch (error) {
                console.error('Error during registration:', error);
                showStatusMessage('Terjadi kesalahan koneksi.', 'error');
            }
        });

        // Penanganan Submit Form Login
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            // Clear previous errors
            clearFormErrors(loginForm);

            try {
                const response = await fetch('<?= base_url('login') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ email: email, password: password })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    showStatusMessage(data.message, 'success');
                    loginForm.reset();
                    // Redirect ke halaman dashboard yang sesuai
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    showStatusMessage(data.message || 'Login gagal.', 'error');
                    if (data.errors) {
                        displayFormErrors(loginForm, data.errors);
                    }
                }
            } catch (error) {
                console.error('Error during login:', error);
                showStatusMessage('Terjadi kesalahan koneksi.', 'error');
            }
        });

        // Fungsi untuk menampilkan error validasi di bawah input form
        function displayFormErrors(form, errors) {
            for (const field in errors) {
                const input = form.querySelector(`input#${field}`);
                if (input) {
                    let errorElement = input.nextElementSibling;
                    if (!errorElement || !errorElement.classList.contains('error-message')) {
                        errorElement = document.createElement('div');
                        errorElement.classList.add('error-message');
                        errorElement.style.color = 'red';
                        errorElement.style.fontSize = '0.9em';
                        errorElement.style.marginTop = '5px';
                        input.parentNode.insertBefore(errorElement, input.nextSibling);
                    }
                    errorElement.textContent = errors.field;
                }
            }
        }

        // Fungsi untuk menghapus error validasi sebelumnya
        function clearFormErrors(form) {
            const errorMessages = form.querySelectorAll('.error-message');
            errorMessages.forEach(msg => msg.remove());
        }

        // Initial setup for modal
        switchTab('login'); // Tampilkan tab login secara default saat halaman dimuat
    });
</script>
<script src="<?= base_url('js/script.js') ?>"></script> </body>
</html>