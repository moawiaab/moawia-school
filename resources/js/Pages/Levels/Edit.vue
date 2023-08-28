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
                    تعديل بيانات الصلاحية :
                    {{ table.row.title || level.entry.title }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="level.entry.name"
                        label="اسم الفصل"
                        lazy-rules
                        :rules="rules.required"
                    />

                    <q-input
                        clearable
                        filled
                        v-model="level.entry.details"
                        label="تفاصل الفصل"
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
</template>

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { useLevelsIndex } from "../../stores/levels/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const level = useLevelsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                level.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            level.updateData(table.row.id);
        };

        const onReset = () => {
            level.entry = {};
        };
        return { table, rules, level, onSubmit, onReset };
    },
};
</script>

<style></style>
