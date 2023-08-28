<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="width: 500px; max-width: 70vw">
            <q-card-section>
                <div class="text-h6">إنشاء مادة دراسية جديدة</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="material.entry.name"
                        label="اسم المادة الدراسية"
                        lazy-rules
                        :rules="rules.required"
                    />

                    <q-input
                        clearable
                        filled
                        v-model="material.entry.details"
                        label="تفاصل المادة الدراسية"
                        lazy-rules
                        :rules="rules.required"
                    />
                    <q-input
                        clearable
                        filled
                        v-model="material.entry.max_degree"
                        label="أعلى درجة"
                        lazy-rules
                        :rules="rules.required"
                        type="number"
                    />
                    <q-input
                        clearable
                        filled
                        v-model="material.entry.min_degree"
                        label="أقل درجة"
                        lazy-rules
                        :rules="rules.required"
                        type="number"
                    />
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="حفظ البيانات"
                        type="submit"
                        color="primary"
                        :loading="material.loading"
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
import { useMaterialsIndex } from "../../stores/materials/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const material = useMaterialsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.newRow) {
                material.$reset();
                material.fetchCreateData();
            }
        });

        const onSubmit = () => {
            material.storeData();
        };

        const onReset = () => {
            material.entry = {};
        };
        return { table, rules, material, onSubmit, onReset };
    },
};
</script>

<style></style>
