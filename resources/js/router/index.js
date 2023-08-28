import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import LoginLayout from "@/Layouts/LoginLayout.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: DefaultLayout,
        redirect: "/dashboard",
        children: [

            {
                path: "dashboard",
                name: "لوحة التحكم",
                component: () => import("@/Pages/Dashboard.vue"),
            },
            {
                path: "users",
                name: " المستخدمين",
                component: () => import("@/Pages/Users/Index.vue"),
            },
            {
                path: "materials",
                name: " المادة الدراسية",
                component: () => import("@/Pages/Materials/Index.vue"),
            },
            {
                path: "students",
                name: " الطلاب",
                component: () => import("@/Pages/Students/Index.vue"),
            },
            {
                path: "levels",
                name: " الفصول الدراسي",
                component: () => import("@/Pages/Levels/Index.vue"),
            },

            {
                path: "roles",
                name: " الصلاحيات",
                component: () => import("@/Pages/Roles/Index.vue"),
            },
            {
                path: "permissions",
                name: "الأذونات",
                component: () => import("@/Pages/Permissions/Index.vue"),
            },

            {
                path: "teachers",
                name: "المعلمين",
                component: () => import("@/Pages/Teachers/Index.vue"),
            },

            {
                path: "tutorials",
                name: "الدروس",
                component: () => import("@/Pages/Tutorials/Index.vue"),
            },

            {
                path: "tutorials/details/:id",
                name: "تفاصيل الدروس",
                component: () => import("@/Pages/Tutorials/Details.vue"),
            },

            {
                path: "tutorials/add-ask/:id",
                name: "إضافة سؤال",
                component: () => import("@/Pages/Tutorials/CreateAsk.vue"),
            },

            {
                path: "tutorials/:id",
                name: "تفاصيل الدرس للطلاب",
                component: () => import("@/Pages/Tutorials/OneDetail.vue"),
            },



        ],
    },
    {
        path: "/auth",
        name: "Login Layout",
        component: LoginLayout,
        redirect: "/login",
        children: [
            {
                path: "/login",
                name: "Login",
                component: () => import("@/Pages/Auth/Login.vue"),
            },
            {
                path: "/register",
                name: "Register",
                component: () => import("@/Pages/Auth/Register.vue"),
            },
        ],
    },
    {
        path: "/:catchAll(.*)*",
        component: () => import("@/Pages/ErrorNotFound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.afterEach((to, from) => {
    // console.log(to, from);
})
export default router;
