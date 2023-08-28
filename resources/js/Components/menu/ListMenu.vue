<template>
    <template v-for="(item, index) in items" :key="index">
        <!-- <q-tree v-if="item.children" >

        </q-tree> -->

        <list-item
            v-if="item.children && auth.can.includes(`${item.access}_access`)"
            :label="item.text"
            :icon="item.icon"
            :default-opened="item.to.includes($route.path)"
        >
            <template v-for="(i, id) in item.children" :key="id">
                <item v-if="auth.can.includes(`${i.access}_access`)" :data="i" />
            </template>
        </list-item>
        <template v-else>
            <item v-if="auth.can.includes(`${item.access}_access`)" :data="item" />
        </template>
    </template>
</template>

<script setup>
import Item from "./Item.vue";
import ListItem from "./ListItem.vue";

import {useAuth} from "@/stores/auth/index"

const auth = useAuth();

const items = [
    {
        text: "لوحة التحكم",
        icon: "mdi-home-outline",
        to: "/dashboard",
        access: "dashboard",
    },
    // {
    //     text: "الفروع",
    //     icon: "mdi-source-branch",
    //     to: "/accounts",
    //     access: "account",
    // },
    {
        text: "الطلاب",
        icon: "mdi-account-school-outline",
        to: "/students",
        access: "student",
    },
    {
        text: "المعلمين",
        icon: "mdi-account-tie-hat-outline",
        to: "/teachers",
        access: "teacher",
    },
    {
        text: "الفصول الدراسية",
        icon: "mdi-google-classroom",
        to: "/levels",
        access: "level",
    },
    {
        text: "المواد الدراسية",
        icon: "mdi-book-open-variant",
        to: "/materials",
        access: "material",
    },
    {
        text: " الدروس",
        icon: "mdi-notebook-edit-outline",
        to: "/tutorials",
        access: "tutorial",
    },
    // {
    //     to: ["/public-treasuries", "/private-lockers", "/stages", "expanses"],
    //     text: "المالية العامة",
    //     icon: "mdi-finance",
    //     access: "financial_management",
    //     children: [
    //         {
    //             to: "/public-treasuries",
    //             text: "الخزنة العامة",
    //             access: "public_treasury",
    //             icon: "mdi-door-closed-lock",
    //         },
    //         {
    //             text: "الخزانات الشخصية",
    //             to: "/private-lockers",
    //             access: "private_locker",
    //             icon: "mdi-lock-outline",
    //         },
    //         {
    //             to: "/stages",
    //             text: "السنة المالية",
    //             access: "stage",
    //             icon: "mdi-finance",
    //         },
    //         {
    //             text: "اسماء الموازنة",
    //             icon: "mdi-chart-bell-curve",
    //             to: "/budget-names",
    //             access: "budget_name",
    //         },
    //         {
    //             text: "الموازنة",
    //             icon: "mdi-chart-bell-curve",
    //             to: "/budgets",
    //             access: "budget",
    //         },
    //     ],
    // },
    {
        text: "المستخدمين",
        icon: "mdi-account-cog-outline",
        to: ["/users", "/roles", "/permissions"],
        access: "user_management",
        children: [
            {
                text: "المستخدمين",
                icon: "mdi-account-details-outline",
                to: "/users",
                access: "user",
            },
            {
                text: "الصلاحيات",
                icon: "mdi-account-lock-outline",
                to: "/roles",
                access: "role",
            },
            {
                text: "الأذونات",
                icon: "mdi-lock-outline",
                to: "/permissions",
                access: "permission",
            },
        ],
    },
];
</script>

<style></style>
