<template>
    <div class="">
        <q-page class="">
            <data-table
                :columns="level.columns"
                title="نافذة الفصول الدراسية"
                selection="multiple"
                router="levels"
                :expand="true"
                role="level"
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
                            <template #body-cell-teacher="props">
                                <q-td>
                                    <div class="row">
                                        <q-chip
                                            icon="person"
                                            square
                                            class="col-auto glossy"
                                            v-for="(item, id) in props.row
                                                .teacher"
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

                <template #options="{ props }">
                    <!-- <pre>{{props}}</pre> -->
                    <q-btn
                        icon="create_new_folder"
                        dense
                        flat
                        rounded
                        color="grey"
                        @click="showDialog(props)"
                    />
                </template>
            </data-table>
            <create-level />
            <edit-level />
            <show-level />
        </q-page>

        <q-dialog
            v-model="level.dialog"
            persistent
            transition-show="scale"
            transition-hide="scale"
        >
            <q-card style="width: 400px; max-width: 60vw">
                <q-card-section>
                    <div class="text-h6">إضافة مادة الى الفصل الدراسي</div>
                </q-card-section>
                <q-separator />
                <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                    <q-card-section class="q-p-sm">
                        <q-select
                            clearable
                            filled
                            v-model="level.entryData.teacher_id"
                            :options="level.lists.teachers"
                            label="اسم المعلم"
                            option-value="id"
                            option-label="name"
                            :rules="rules.selected"
                            emit-value
                            map-options
                        />

                        <q-select
                            clearable
                            filled
                            v-model="level.entryData.material_id"
                            :options="level.lists.materials"
                            label="اسم المادة الدراسية"
                            option-value="id"
                            option-label="name"
                            :rules="rules.selected"
                            emit-value
                            map-options
                        />
                    </q-card-section>
                    <q-separator />
                    <q-card-actions align="right" class="bg-white text-teal">
                        <q-btn
                            flat
                            label="حفظ البيانات"
                            type="submit"
                            color="primary"
                            :loading="level.loading"
                        />
                        <q-btn
                            label="تفريغ الحقول"
                            type="reset"
                            color="warning"
                            flat
                            class="q-ml-sm"
                        />
                        <q-btn
                            flat
                            label="قفل النافذة"
                            v-close-popup
                            color="negative"
                        />
                    </q-card-actions>
                </q-form>
            </q-card>
        </q-dialog>
    </div>
</template>

<script setup lang="ts">
import { useLevelsIndex } from "@/stores/levels/index";
import CreateLevel from "./Create.vue";
import EditLevel from "./Edit.vue";
import ShowLevel from "./Show.vue";
import { useForms } from "../../Composables/rules";


const level = useLevelsIndex();
const { rules: rulesData } = useForms();
const rules = rulesData;

const showDialog = async (id: any) => {
    level.dialog = true;
    if (!level.lists.teachers || !level.lists.materials) {
        await level.fetchGetData();
    }

    console.log(level.lists);
    level.entryData.level_id = id.id;
    // level.setId(id);
};

const onSubmit = () => {
    level.sendData();
};

const onReset = () => {
    level.entryData.teacher_id = null;
    level.entryData.material_id = null;
};

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
    { name: "teacher", align: "left", label: "	اسم المعلم", field: "teacher" },
    // { name: "created_at", label: "تاريخ الإنشاء", field: "created_at", align: "left", sortable: true },
];
</script>
