<template>
    <q-page class="">
        <data-table
            :columns="role.columns"
            title="بيانات المعلمين"
            selection="multiple"
            router="teachers"
            :expand="true"
            :viewable="false"
            role="teacher"
        >
            <template #table-body="{ props }">
                <div class="q-pa-sm">
                    <q-table
                        dense
                        flat
                        bordered
                        title="المواد الدراسية"
                        :rows="props.row.materials"
                        :columns="MaterialColumns"
                        row-key="name"
                        hide-bottom
                    >
                        <template #body-cell-level="props">
                            <q-td>
                                <div class="row">
                                    <q-chip
                                        icon="person"
                                        square
                                        class="col-auto glossy"
                                        v-for="(item, id) in props.row.level"
                                        :key="id"
                                    >
                                        {{ item }}</q-chip
                                    >
                                </div>
                            </q-td>
                        </template>
                    </q-table>
                </div>
            </template>
        </data-table>
        <create-role />
        <edit-role />
        <show-role />
    </q-page>
</template>

<script setup lang="ts">
import { useTeachersIndex } from "@/stores/teachers/index";
import CreateRole from "./Create.vue";
import EditRole from "./Edit.vue";
import ShowRole from "./Show.vue";
const role = useTeachersIndex();

const MaterialColumns = [
    {
        name: "name",
        required: true,
        label: "اسم المادة الدراسية",
        align: "left",
        field: "name",
    },
    {
        name: "max_degree",
        label: "أعلى درجة",
        field: "max_degree",
        align: "left",
    },
    {
        name: "min_degree",
        label: "أقل درجة",
        field: "min_degree",
        align: "left",
    },
    { name: "details", align: "left", label: "التفاصيل", field: "details" },
    { name: "level", align: "left", label: "الفصول الدراسية", field: "level" },
    // { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
];
</script>
