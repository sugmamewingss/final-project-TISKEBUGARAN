// URL Utama mengarah ke API Gateway!
const API_URL = 'http://127.0.0.1:3000/api';

// Fungsi berjalan otomatis saat web pertama kali dibuka
window.onload = () => {
    // Cek apakah ada token yang tersimpan di memori browser
    const token = localStorage.getItem('jwt_token');
    if (token) {
        showDashboard();
        fetchProfile(token);
    }
};

// --- FUNGSI LOGIN ---
async function login() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorMsg = document.getElementById('error-msg');

    try {
        errorMsg.innerText = "Memproses...";
        // Tembak Gateway menggunakan Axios
        const response = await axios.post(`${API_URL}/auth/login`, {
            email: email,
            password: password
        });

        // Jika sukses, simpan token JWT ke Local Storage
        const token = response.data.data.authorization.token;
        localStorage.setItem('jwt_token', token);

        errorMsg.innerText = "";
        showDashboard();
        fetchProfile(token);
    } catch (error) {
        errorMsg.innerText = error.response?.data?.message || "Koneksi ke Gateway gagal!";
    }
}

// --- FUNGSI AMBIL PROFIL (Terproteksi JWT) ---
async function fetchProfile(token) {
    try {
        const response = await axios.get(`${API_URL}/auth/me`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        // Tampilkan nama user di layar
        document.getElementById('user-name').innerText = response.data.data.name;

        // [TAMBAHAN FITUR ADMIN] Tampilkan panel admin bila role === 'admin'.
        // Fungsi handleAdminUI didefinisikan di admin.js (file terpisah, additive).
        if (typeof handleAdminUI === 'function') handleAdminUI(response.data.data);
    } catch (error) {
        console.error("Token mungkin kadaluarsa", error);
        logout(); // Tendang user jika token tidak valid
    }
}

// --- FUNGSI AMBIL DATA MASTER (Terproteksi JWT) ---
async function fetchExercises() {
    const token = localStorage.getItem('jwt_token');
    const list = document.getElementById('exercise-list');
    list.innerHTML = '<i>Memuat data...</i>';

    try {
        const response = await axios.get(`${API_URL}/exercises`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        list.innerHTML = '';
        response.data.data.forEach(ex => {
            const li = document.createElement('li');
            // [TAMBAHAN] Tampilkan thumbnail gambar bila tersedia (image_url dari backend).
            // Jika tidak ada gambar, tampilan tetap sama seperti sebelumnya.
            const thumb = ex.image_url
                ? `<img src="${ex.image_url}" alt="${ex.name}" class="float-right ml-3 h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200">`
                : '';
            li.innerHTML = `${thumb}<strong>${ex.name}</strong> - <small>${ex.category}</small>`;
            list.appendChild(li);
        });
    } catch (error) {
        list.innerHTML = `<li style="color:red;">Gagal: ${error.response?.data?.message}</li>`;
    }
}

// --- FUNGSI LOGOUT ---
function logout() {
    // Hapus token dari memori browser
    localStorage.removeItem('jwt_token');
    // Atur ulang tampilan UI
    document.getElementById('login-section').classList.remove('hidden');
    document.getElementById('dashboard-section').classList.add('hidden');
    document.getElementById('exercise-list').innerHTML = '';
    document.getElementById('error-msg').innerText = '';

    // [TAMBAHAN FITUR ADMIN] Sembunyikan panel admin saat logout.
    // Fungsi resetAdminUI didefinisikan di admin.js (file terpisah, additive).
    if (typeof resetAdminUI === 'function') resetAdminUI();
}

// --- UTILITAS UI ---
function showDashboard() {
    document.getElementById('login-section').classList.add('hidden');
    document.getElementById('dashboard-section').classList.remove('hidden');
}
