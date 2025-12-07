const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';

// Get auth token from localStorage
function getAuthToken() {
    return localStorage.getItem('auth_token');
}

// Set auth token in localStorage
function setAuthToken(token) {
    localStorage.setItem('auth_token', token);
}

// Remove auth token
function removeAuthToken() {
    localStorage.removeItem('auth_token');
}

// Make API request
async function apiRequest(endpoint, options = {}) {
    const token = getAuthToken();
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers,
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const config = {
        ...options,
        headers,
    };

    if (options.body && typeof options.body === 'object') {
        config.body = JSON.stringify(options.body);
    }

    try {
        const response = await fetch(`${API_BASE_URL}${endpoint}`, config);

        // Handle unauthorized (401) responses
        if (response.status === 401) {
            removeAuthToken();
            window.location.href = '/login';
            throw new Error('Session expired. Please login again.');
        }

        if (!response.ok) {
            let errorData;
            try {
                errorData = await response.json();
            } catch {
                errorData = { message: `HTTP error! status: ${response.status}` };
            }

            // Handle Laravel validation errors (422)
            if (response.status === 422 && errorData.errors) {
                const errorMessages = Object.values(errorData.errors).flat().join(', ');
                throw new Error(errorMessages);
            }

            // Handle other error responses
            throw new Error(errorData.message || errorData.error || `Request failed with status ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('API request failed:', error);
        throw error;
    }
}

// Auth API
export const authAPI = {
    login: async (email, password) => {
        const data = await apiRequest('/login', {
            method: 'POST',
            body: { email, password },
        });

        // Handle different response formats
        if (data.token) {
            setAuthToken(data.token);
        } else if (data.access_token) {
            setAuthToken(data.access_token);
        }

        return data;
    },

    register: async (userData) => {
        const data = await apiRequest('/register', {
            method: 'POST',
            body: userData,
        });

        // Handle different response formats
        if (data.token) {
            setAuthToken(data.token);
        } else if (data.access_token) {
            setAuthToken(data.access_token);
        }

        return data;
    },

    logout: async () => {
        try {
            await apiRequest('/logout', { method: 'POST' });
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            removeAuthToken();
        }
    },

    me: async () => {
        return await apiRequest('/user');
    },

    forgotPassword: async (email) => {
        return await apiRequest('/forgot-password', {
            method: 'POST',
            body: { email },
        });
    },

    resetPassword: async (token, email, password, password_confirmation) => {
        return await apiRequest('/reset-password', {
            method: 'POST',
            body: { token, email, password, password_confirmation },
        });
    }
};

// Profile API
export const profileAPI = {
    get: () => apiRequest('/profile'),
    update: (data) => apiRequest('/profile', {
        method: 'PUT',
        body: data,
    }),
    updatePassword: (currentPassword, newPassword, newPasswordConfirmation) =>
        apiRequest('/profile/password', {
            method: 'PUT',
            body: { current_password: currentPassword, password: newPassword, password_confirmation: newPasswordConfirmation },
        }),
};

// Wallet API
export const walletAPI = {
    getWallet: () => apiRequest('/wallet'),
    getBalance: () => apiRequest('/wallet/balance'),
    getHistory: () => apiRequest('/wallet/history'),
    sell: (cryptoSymbol, amount) => apiRequest('/wallet/sell', {
        method: 'POST',
        body: { crypto_symbol: cryptoSymbol, amount },
    }),
    deposit: (amount) => apiRequest('/wallet/deposit', {
        method: 'POST',
        body: { amount },
    }),
    withdraw: (amount) => apiRequest('/wallet/withdraw', {
        method: 'POST',
        body: { amount },
    }),
};

// Market API
export const marketAPI = {
    getAll: async () => {
        const data = await apiRequest('/market');
        return { cryptos: data.data || data || [] };
    },
    getTop: (limit = 10) => apiRequest(`/market/top?limit=${limit}`),
    getOne: (symbol) => apiRequest(`/market/${symbol}`),
    getTrending: () => apiRequest('/market/trending'),
    search: (query) => apiRequest(`/market/search?q=${query}`),
};

// Transaction API
export const transactionAPI = {
    getAll: (page = 1, perPage = 10) => apiRequest(`/transactions?page=${page}&per_page=${perPage}`),
    create: (type, cryptoSymbol, amount) => apiRequest('/transactions', {
        method: 'POST',
        body: { type, crypto_symbol: cryptoSymbol, amount },
    }),
    getStatistics: () => apiRequest('/transactions/statistics'),
    getById: (id) => apiRequest(`/transactions/${id}`),
};

// Price History API
export const priceHistoryAPI = {
    getAll: () => apiRequest('/price-history'),
    getBySymbol: (symbol, period = '24h') => apiRequest(`/price-history/${symbol}?period=${period}`),
    getChartData: (symbol, period = '7d') => apiRequest(`/price-history/${symbol}/chart?period=${period}`),
};

// Admin API
export const adminAPI = {
    // Clients
    getClients: async (page = 1, perPage = 10) => {
        const data = await apiRequest(`/admin/clients?page=${page}&per_page=${perPage}`);
        return { data: data.data || data || [], meta: data.meta };
    },
    getClientDetails: (clientId) => apiRequest(`/admin/clients/${clientId}`),
    createClient: (clientData) => apiRequest('/admin/clients', {
        method: 'POST',
        body: clientData,
    }),
    updateClient: (clientId, clientData) => apiRequest(`/admin/clients/${clientId}`, {
        method: 'PUT',
        body: clientData,
    }),
    deleteClient: (clientId) => apiRequest(`/admin/clients/${clientId}`, {
        method: 'DELETE',
    }),
    generateTempPassword: (clientId) => apiRequest(`/admin/clients/${clientId}/generate-password`, {
        method: 'POST',
    }),

    // Profile
    updateProfile: (data) => apiRequest('/admin/profile', {
        method: 'PUT',
        body: data,
    }),

    // Cryptocurrencies
    getCryptocurrencies: async (page = 1, perPage = 10) => {
        const data = await apiRequest(`/admin/cryptocurrencies?page=${page}&per_page=${perPage}`);
        return { cryptos: data.data || data || [], meta: data.meta };
    },
    createCryptocurrency: (cryptoData) => apiRequest('/admin/cryptocurrencies', {
        method: 'POST',
        body: cryptoData,
    }),
    updateCryptocurrency: (cryptoId, cryptoData) => apiRequest(`/admin/cryptocurrencies/${cryptoId}`, {
        method: 'PUT',
        body: cryptoData,
    }),
    deleteCryptocurrency: (cryptoId) => apiRequest(`/admin/cryptocurrencies/${cryptoId}`, {
        method: 'DELETE',
    }),

    // Statistics
    getStatistics: () => apiRequest('/admin/statistics'),
    getDashboardStats: () => apiRequest('/admin/dashboard-stats'),

    // Transactions
    getTransactions: async (page = 1, perPage = 10) => {
        const data = await apiRequest(`/admin/transactions?page=${page}&per_page=${perPage}`);
        return { data: data.data || data || [], meta: data.meta };
    },
    getTransactionStats: () => apiRequest('/admin/transactions/statistics'),
};

// Utility functions for auth state management
export const authUtils = {
    isAuthenticated: () => {
        const token = getAuthToken();
        if (!token) return false;

        // Basic token validation (you might want to add JWT expiration check)
        try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            return payload.exp > Date.now() / 1000;
        } catch {
            return false;
        }
    },

    getCurrentUser: async () => {
        if (!authUtils.isAuthenticated()) {
            return null;
        }
        try {
            const response = await authAPI.me();
            return response.user || response;
        } catch (error) {
            removeAuthToken();
            return null;
        }
    }
};

export { getAuthToken, setAuthToken, removeAuthToken };