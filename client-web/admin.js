// ====================================================================
//  admin.js  —  Panel Admin (fitur tambahan)
//  Dimuat SETELAH app.js. Tidak mengubah URL Axios maupun logika
//  localStorage/JWT milik app.js — hanya MENAMBAH fitur khusus admin.
//  Catatan: API_URL (gateway :3000) di-reuse dari app.js.
// ====================================================================

// Dipanggil dari app.js (fetchProfile) lewat hook bernama handleAdminUI.
// Tampilkan panel admin HANYA jika role user === 'admin'.
function handleAdminUI(user) {
    const panel = document.getElementById('admin-section');
    if (!panel) return;
    if (user && user.role === 'admin') {
        panel.classList.remove('hidden');
    } else {
        panel.classList.add('hidden');
    }
}

// Dipanggil dari app.js (logout) lewat hook bernama resetAdminUI.
function resetAdminUI() {
    const panel = document.getElementById('admin-section');
    if (panel) panel.classList.add('hidden');

    const form = document.getElementById('admin-exercise-form');
    if (form) form.reset();

    hideImagePreview();
    setAdminMsg('', null);
}

// --- Preview gambar sebelum di-upload ---
function previewExerciseImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('admin-image-preview');
    const img = document.getElementById('admin-image-preview-img');
    if (file && preview && img) {
        img.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
}

function hideImagePreview() {
    const preview = document.getElementById('admin-image-preview');
    if (preview) preview.classList.add('hidden');
}

// Helper untuk menampilkan pesan status (ok=true hijau, ok=false merah)
function setAdminMsg(text, ok) {
    const msg = document.getElementById('admin-msg');
    if (!msg) return;
    msg.innerText = text;
    msg.classList.remove('text-rose-500', 'text-lime-400', 'text-slate-400');
    msg.classList.add(ok === true ? 'text-lime-400' : ok === false ? 'text-rose-500' : 'text-slate-400');
}

// --- Submit gerakan baru (multipart, tetap lewat API Gateway :3000) ---
async function addExercise() {
    const token = localStorage.getItem('jwt_token'); // baca token (read-only)
    const name = document.getElementById('admin-name').value.trim();
    const category = document.getElementById('admin-category').value.trim();
    const description = document.getElementById('admin-description').value.trim();
    const imageInput = document.getElementById('admin-image');

    if (!name || !category) {
        setAdminMsg('Nama dan kategori wajib diisi.', false);
        return;
    }

    // FormData agar file gambar ikut terkirim sebagai multipart/form-data
    const formData = new FormData();
    formData.append('name', name);
    formData.append('category', category);
    formData.append('description', description);
    if (imageInput && imageInput.files[0]) {
        formData.append('image', imageInput.files[0]);
    }

    try {
        setAdminMsg('Menyimpan...', null);
        const response = await axios.post(`${API_URL}/exercises`, formData, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'multipart/form-data'
            }
        });

        setAdminMsg(response.data.message || 'Gerakan berhasil ditambahkan!', true);
        document.getElementById('admin-exercise-form').reset();
        hideImagePreview();

        // Segarkan daftar gerakan di dashboard (fungsi milik app.js)
        if (typeof fetchExercises === 'function') fetchExercises();
    } catch (error) {
        const firstError = error.response?.data?.errors
            ? Object.values(error.response.data.errors)[0][0]
            : null;
        setAdminMsg(firstError || error.response?.data?.message || 'Gagal menambahkan gerakan.', false);
    }
}
