import Home from '../js/components/Home';
import Login from '../js/components/auth/Login';
import CreateCompany from '../js/components/dashboard/CreateCompany';
import EditCompany from '../js/components/dashboard/EditCompany';
import CreateEmployee from '../js/components/dashboard/CreateEmployee';
import Employees from '../js/components/dashboard/Employees';

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
    },
    {
        name: '/company/edit/:id',
        path: '/company/edit/:id',
        component: EditCompany
    },
    {
        name: '/employee/create',
        path: '/employee/create',
        component: CreateEmployee
    },
    {
        name: '/company/employees/:company_id',
        path: '/company/employees/:company_id',
        component: Employees
    }
];
