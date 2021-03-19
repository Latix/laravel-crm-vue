import Home from '../js/components/Home';
import Login from '../js/components/auth/Login';
import CreateCompany from '../js/components/dashboard/CreateCompany';
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
    {
        name: '/company/create',
        path: '/company/create',
        component: CreateCompany
    }
];
