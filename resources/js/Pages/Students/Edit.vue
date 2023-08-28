<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="width: 800px; max-width: 80vw">
            <q-card-section>
                <div class="text-h6">
                    تعديل بيانات المستخدم :
                    {{ table.row.name || student.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <q-splitter
                        v-model="table.splitterModel"
                        style="height: 100%"
                    >
                        <template v-slot:before>
                            <div class="q-pa-sm">
                                <q-input
                                    clearable
                                    filled
                                    v-model="student.entry.name"
                                    label="اسم الطالب"
                                    lazy-rules
                                    :rules="rules.required"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="student.entry.phone"
                                    label="رقم الهاتف"
                                    lazy-rules
                                    :rules="rules.required"
                                    type="phone"
                                />
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
                                <q-input
                                    clearable
                                    filled
                                    v-model="student.entry.age"
                                    label="تاريخ الميلاد"
                                    lazy-rules
                                    :rules="rules.required"
                                    type="date"
                                />
                                <q-select
                                    clearable
                                    filled
                                    v-model="student.entry.level_id"
                                    :options="student.lists.levels"
                                    label="الفصل الدراسي"
                                    option-value="id"
                                    option-label="name"
                                    :rules="rules.selected"
                                    emit-value
                                    map-options
                                />
                            </div>
                        </template>
                    </q-splitter>
                    <q-input
                        class="q-px-sm"
                        clearable
                        filled
                        v-model="student.entry.details"
                        label="تفاصيل عن الطالب"
                        lazy-rules
                        :rules="rules.required"
                    />
                    <q-input
                        class="q-px-sm"
                        clearable
                        filled
                        v-model="student.entry.address"
                        label="عنوان الطالب"
                        lazy-rules
                        :rules="rules.required"
                    />
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="تعديل البيانات "
                        type="submit"
                        color="primary"
                        :loading="student.loading"
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
</template>

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { useStudentsIndex } from "../../stores/students/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const student = useStudentsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                student.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            student.updateData(table.row.id);
        };

        const onReset = () => {
            student.entry = {};
        };
        return { table, rules, student, onSubmit, onReset };
    },
};
</script>

<style></style>
