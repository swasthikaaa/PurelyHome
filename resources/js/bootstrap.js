import axios from 'axios';

window.axios = axios;

//  Base URL for API
axios.defaults.baseURL = '/api';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';

// Attach token automatically
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('auth_token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

export function getAuthHeaders() {
    const token = localStorage.getItem('auth_token');
    return token ? { Authorization: `Bearer ${token}`, Accept: 'application/json' } : {};
}

// Handle errors
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            localStorage.removeItem('auth_token');
            alert('❌ Session expired. Please login again.');
            window.location.href = '/login';
        } else if (error.response?.status === 403) {
            alert('⚠️ Access denied.');
        }
        return Promise.reject(error);
    }
);

export function showFlashMessage(message, type = 'success') {
    let div = document.getElementById('flashMessage');
    if (!div) {
        div = document.createElement('div');
        div.id = 'flashMessage';
        div.className = 'fixed top-4 right-4 px-4 py-2 rounded shadow-lg z-50 text-white';
        document.body.appendChild(div);
    }
    div.textContent = message;
    div.className = `fixed top-4 right-4 px-4 py-2 rounded shadow-lg z-50 text-white ${
        type === 'success' ? 'bg-green-600' : 'bg-red-600'
    }`;
    div.style.display = 'block';
    setTimeout(() => { div.style.display = 'none'; }, 4000);
}


