import Dashboard from './components/Dashboard.vue';
import ListAppointments from './pages/appointments/ListAppointments.vue';
import AppointmentForm from './pages/appointments/AppointmentForm.vue';
import ListUsers from './pages/users/ListUsers.vue';
import UpdateSetting from './pages/settings/UpdateSetting.vue';
import UpdateProfile from './pages/profile/UpdateProfile.vue';

import ProductIndex from './pages/products/index.vue';
import ProductCreate from './pages/products/create.vue';
import ProductEdit from './pages/products/edit.vue';
import Test from './test.vue';

export default [

    {
        path: '/admin/test',
        name: 'admin.test',
        component: Test,
    },

    {
        path: '/admin/dashboard',

        name: 'admin.dashboard',

        component: Dashboard,
    },

    {
        path: '/admin/appointments',

        name: 'admin.appointments',

        component: ListAppointments,
    },

    {
        path: '/admin/appointments/create',

        name: 'admin.appointments.create',

        component: AppointmentForm,
    },
    
    {
        path: '/admin/users',

        name: 'admin.users',

        component: ListUsers,
    },
    
    {
        path: '/admin/settings',

        name: 'admin.settings',

        component: UpdateSetting,
    },
    
    {
        path: '/admin/profile',

        name: 'admin.profile',

        component: UpdateProfile,
    },

    {
        path: '/admin/products',
        name: 'admin.product',
        component: ProductIndex,
    },

    {
        path: '/admin/products/create',
        name: 'admin.product.create',
        component: ProductCreate,
    },

    {
        path: '/admin/products/edit/:id',
        name: 'admin.product.edit',
        component: ProductEdit,
    },
]