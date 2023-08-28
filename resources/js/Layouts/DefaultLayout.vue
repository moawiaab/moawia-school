<template>
    <!-- <div class=""> -->
    <q-layout
        view="lhH LpR lff"
        container
        style="height: 100vh"
        class="bg-white"
    >
        <q-header class="bg-grey-1 text-grey-8 q-py-xs">
            <q-toolbar>
                <q-btn
                    flat
                    @click="drawerLeft = !drawerLeft"
                    round
                    dense
                    icon="menu"
                />
                <q-space />
                <q-btn
                    flat
                    @click="logout"
                    round
                    dense
                    icon="logout"
                    color="red"
                />
            </q-toolbar>
        </q-header>

        <!-- <q-footer>
      <q-toolbar>
        <q-toolbar-title>Footer</q-toolbar-title>
      </q-toolbar>
    </q-footer> -->

        <q-drawer
            v-model="drawerLeft"
            :width="260"
            :breakpoint="700"
            bordered
            show-if-above
            class="bg-grey-2"
        >
            <q-scroll-area class="fit">
                <q-list separator>
                    <div
                        class="row justify-center q-px-md q-pt-md"
                        style="background: #ecf8fe"
                    >
                        <q-avatar
                            size="100px"
                            style="border: 2px solid #f0f0f0"
                        >
                            <q-img
                                src="/img/logo.png"
                                width="100px"
                                height="100px"
                            />
                        </q-avatar>
                    </div>
                    <q-item class="bg-light-blue-1 q-pt-sm" disable dense>
                        <q-item-section class="q-pa-sm">
                            <q-item-label>
                                مرحباً : {{ auth.userData.name }}</q-item-label
                            >
                            <q-item-label caption>
                                <q-item-section>
                                    البريد : {{ auth.userData.email }}
                                </q-item-section>
                                الهاتف : {{ auth.userData.phone }}
                                <p v-if="auth.userData.levelName">
                                    المستوى الدراسي :
                                    {{ auth.userData.levelName }}
                                </p>
                            </q-item-label>
                        </q-item-section>
                    </q-item>
                    <!--
                    <q-item>
                        <q-item-section avatar>
                            <q-avatar>
                                <img src="/img/logo.png" />
                            </q-avatar>
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>
                                {{ auth.userData.name }}</q-item-label
                            >
                            <q-item-label caption>
                                {{ auth.userData.email }}</q-item-label
                            >
                        </q-item-section>
                    </q-item> -->
                    <q-separator />
                    <list-menu />
                    <!-- <q-separator /> -->
                    <template v-if="auth.userData.student">
                        <q-item to="/" v-ripple>
                            <q-item-section avatar>
                                <q-icon name="home"
                            /></q-item-section>
                            <q-item-section> لوحة التحكم </q-item-section>
                            <q-item-section side
                                ><q-icon name="link"
                            /></q-item-section>
                        </q-item>
                        <q-item class="bg-blue-4 text-white">
                            <q-item-label>المواد الدراسية</q-item-label>
                        </q-item>

                        <q-item
                            v-for="(item, index) in student.entry.levelClass"
                            :key="index"
                            dense
                        >
                            <q-item-label
                                >{{ index + 1 }} - {{ item.name }}</q-item-label
                            >
                        </q-item>
                    </template>
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <!-- <q-page> -->
            <router-view v-slot="{ Component }">
                <transition
                    appear
                    enter-active-class="animated zoomIn"
                    leave-active-class="animated zoomOut"
                    mode="out-in"
                >
                    <component :is="Component" />
                </transition>
            </router-view>
            <!-- </q-page> -->

            <q-page-scroller position="bottom-right">
                <q-btn
                    fab
                    icon="keyboard_arrow_up"
                    color="primary"
                    class="glossy"
                />
            </q-page-scroller>
        </q-page-container>
    </q-layout>
    <!-- </div> -->
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { Platform, Screen } from "quasar";
import ListMenu from "@/Components/menu/ListMenu.vue";
import { useStudentsShow } from "@/stores/students/show";
import { useAuth } from "@/stores/auth/index";

const student = useStudentsShow();
const auth = useAuth();

const drawerLeft = ref(Screen.width > 702 ? true : false);

const logout = () => {
    axios
        .request({
            baseURL: "/",
            url: "logout",
            method: "post",
        })
        .then(() => {
            console.log("logged out");
            location.reload();
        })
        .catch(() => {});
};
</script>
