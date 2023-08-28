<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="width: 800px; max-width: 70vw" title="إنشاء صلاحية جديدة ">
            <q-card-section>
                <div class="text-h6">إنشاء مستخدم جديد</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="role.entry.title"
                        label="اسم الصلاحية"
                        lazy-rules
                        :rules="rules.required"
                    />

                    <q-select
                        use-chips
                        multiple
                        clearable
                        filled
                        v-model="role.entry.permissions"
                        :options="role.lists.permissions"
                        label="الصلاحية"
                        option-value="value"
                        option-label="label"
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
                        :loading="role.loading"
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
import { useRolesIndex } from "../../stores/roles/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const role = useRolesIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.newRow) {
                role.$reset();
                role.fetchCreateData();
            }
        });

        const onSubmit = () => {
            role.storeData();
        };

        const onReset = () => {
            role.entry = {};
        };
        return { table, rules, role, onSubmit, onReset };
    },
};
</script>

<style></style>
