const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');
const cors = require('cors');
const morgan = require('morgan');

const app = express();
const PORT = 3000;
const LARAVEL_BACKEND = 'http://127.0.0.1:8000';

// 1. Aktifkan CORS agar client HTML/JS bisa mengakses Gateway
app.use(cors());

// 2. Aktifkan logger untuk melihat lalu lintas request di terminal
app.use(morgan('dev'));

// 3. Konfigurasi Proxy (Inti dari API Gateway)
app.use('/api', createProxyMiddleware({
    target: LARAVEL_BACKEND,
    changeOrigin: true,
    
    pathRewrite: (path, req) => {
        return '/api' + path; 
    },
    
    onProxyReq: (proxyReq, req, res) => {
        console.log(`[Gateway] Meneruskan request ke: ${LARAVEL_BACKEND}/api${req.url}`);
    },
    // ----------------------

    onError: (err, req, res) => {
        console.error('[Gateway Error]', err.message);
        res.status(502).json({
            status: 'error',
            message: 'Bad Gateway: Tidak dapat terhubung ke Backend.'
        });
    }
}));

// Route default jika ada yang mengakses root URL
app.get('/', (req, res) => {
    res.send('API Gateway Kebugaran Aktif 🚀');
});

// Jalankan Server
app.listen(PORT, () => {
    console.log(`🚀 API Gateway berjalan di http://localhost:${PORT}`);
    console.log(`🔗 Terhubung ke Backend Laravel di ${LARAVEL_BACKEND}`);
});