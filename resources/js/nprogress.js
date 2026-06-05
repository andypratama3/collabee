import NProgress from 'nprogress';
import 'nprogress/nprogress.css';

NProgress.configure({ showSpinner: false, minimum: 0.1 });

document.addEventListener('livewire:init', () => {
    Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
        NProgress.start();
        succeed(() => NProgress.done());
        fail(() => NProgress.done());
    });
});

window.axios.interceptors.request.use((config) => {
    NProgress.start();
    return config;
});

window.axios.interceptors.response.use(
    (response) => {
        NProgress.done();
        return response;
    },
    (error) => {
        NProgress.done();
        return Promise.reject(error);
    }
);

document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('livewire:navigate', (event) => {
        NProgress.start();
    });

    document.addEventListener('livewire:navigated', (event) => {
        NProgress.done();
    });
});
