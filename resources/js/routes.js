import Home from '../js/components/Home';
import Login from '../js/components/auth/Login';

export const routes = [
    {
        name: '/',
        path: '/',
        component: Home
    },
    {
        name: '/login',
        path: '/login',
        component: Login
    },
];
