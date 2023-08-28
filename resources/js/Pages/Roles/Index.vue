<template>
    <q-page class="">
        <data-table
            :columns="role.columns"
            title="بيانات المستخدمين"
            selection="multiple"
            router="roles"
            :expand="true"
            :viewable="false"
            role="role"
        >
            <template #table-body="{ props }">
                <q-splitter v-model="role.splitterModel" style="height: 100%">
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-card-section>
                                الأذونات لهذه الصلاحية
                            </q-card-section>

                            <div class="row">
                                <q-chip
                                    icon="link"
                                    color="red"
                                    text-color="white"
                                    square
                                    class="col-auto glossy"
                                    v-for="{ id, details } in props.row
                                        .permissions"
                                    :key="id"
                                >
                                    {{ details }}</q-chip
                                >
                            </div>
                        </div>
                    </template>

                    <template v-slot:separator>
                        <q-avatar
                            color="primary"
                            text-color="white"
                            size="20px"
                            icon="drag_indicator"
                        />
                    </template>

                    <template v-slot:after>
                        <div class="q-pa-sm">
                            <q-card-section>
                                المستخدمين لهذه الصلاحية
                            </q-card-section>

                            <div class="row">
                                <q-chip
                                    icon="person"
                                    color="primary"
                                    text-color="white"
                                    square
                                    class="col-auto glossy"
                                    v-for="{ id, name } in props.row.users"
                                    :key="id"
                                >
                                    {{ name }}</q-chip
                                >
                            </div>
                        </div>
                    </template>
                </q-splitter>
            </template>
        </data-table>
        <create-role />
        <edit-role />
        <show-role />
    </q-page>
</template>

<script setup lang="ts">
import { useRolesIndex } from "@/stores/roles/index";
import CreateRole from "./Create.vue";
import EditRole from "./Edit.vue";
import ShowRole from "./Show.vue";
const role = useRolesIndex();
</script>
