<template>
    <q-page class="">
        <data-table
            :columns="level.columns"
            title="نافذة المواد الدراسية"
            selection="multiple"
            router="materials"
            :expand="true"
            :viewable="false"
            role="material"
        >
            <template #table-body="{ props }">
                <div class="q-pa-sm">
                    <q-table
                        style="background-color: #f0f0f0"
                        dense
                        flat
                        bordered
                        title="المواد الدراسية"
                        :rows="props.row.materials"
                        :columns="MaterialColumns"
                        row-key="name"
                        hide-bottom
                    >
                        <template #body-cell-options="props">
                            <q-td class="text-right">
                                <q-btn
                                    icon="create_new_folder"
                                    dense
                                    flat
                                    rounded
                                    color="green"
                                    @click="
                                        tutorial.entry.material_id =
                                            props.row.id;
                                        tutorial.dialog = true;
                                    "
                                />
                                <q-btn
                                    icon="delete"
                                    dense
                                    flat
                                    rounded
                                    color="red"
                                    @click="deleteItem(props.row)"
                                />
                            </q-td>
                        </template>
                    </q-table>
                </div>
            </template>
        </data-table>
        <create-level />
        <edit-level />
        <show-level />

        <create-tutorial />
    </q-page>
</template>

<script setup lang="ts">
import { useMaterialsIndex } from "@/stores/materials/index";
import { useTutorialsIndex } from "@/stores/tutorials/index";
import CreateTutorial from "../Tutorials/Create.vue";
import CreateLevel from "./Create.vue";
import EditLevel from "./Edit.vue";
import ShowLevel from "./Show.vue";
const level = useMaterialsIndex();
const tutorial = useTutorialsIndex();

const MaterialColumns = [
    {
        name: "material",
        required: true,
        label: "اسم المادة الدراسية",
        align: "left",
        field: "material",
    },
    {
        name: "teacher",
        label: " اسم المعلم",
        field: "teacher",
        align: "left",
    },
    {
        name: "level",
        label: "الفصل الدرايس",
        field: "level",
        align: "left",
    },
    { name: "counts", align: "left", label: "عدد الدروس", field: "counts" },
    {
        name: "created_at",
        label: "تاريخ الإنشاء",
        field: "created_at",
        align: "left",
        sortable: true,
    },
    { name: "options", align: "right", label: "الاعدادات", field: "options" },
];
</script>
