async function secureFetch(url, options = {}) {
    const token = localStorage.getItem('accessToken');
    if (!options.headers) options.headers = {};
    options.headers['Authorization'] = 'Bearer ' + token;

    let response = await fetch(url, options);

    if (response.status === 401) {
        const refreshResponse = await fetch('/api/rauth/refreshToken', {
            method: 'POST',
            credentials: 'include'
        });

        if (refreshResponse.ok) {
            const data = await refreshResponse.json();
            localStorage.setItem('accessToken', data.accessToken);

            options.headers['Authorization'] = 'Bearer ' + data.accessToken;
            response = await fetch(url, options);
        } else {
            window.location.href = '/login';
            return;
        }
    }

    if (!response.ok) {
        throw new Error('Erreur HTTP ' + response.status);
    }

    return response.json();
}
