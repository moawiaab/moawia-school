<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card
            style="width: 500px; max-width: 80vw"
        >
            <q-card-section>
                <div class="text-h6">
                    تعديل بيانات المستخدم :
                    {{ table.row.name || user.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-pt-none">
                    <div class="q-pa-sm">
                        <q-input
                            clearable
                            filled
                            v-model="user.entry.name"
                            label="اسم المستخدم"
                            lazy-rules
                            :rules="rules.required"
                        />
                        <q-input
                            clearable
                            filled
                            v-model="user.entry.email"
                            label="البريد الالكتروني * "
                            lazy-rules
                            :rules="rules.required"
                            type="email"
                        />
                        <q-input
                            clearable
                            filled
                            v-model="user.entry.phone"
                            label="رقم الهاتف"
                            lazy-rules
                            :rules="rules.required"
                            type="phone"
                        />

                        <q-select
                            clearable
                            filled
                            v-model="user.entry.role_id"
                            :options="user.lists.roles"
                            label="الصلاحية"
                            option-value="id"
                            option-label="title"
                            :rules="rules.selected"
                            emit-value
                            map-options
                        />
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="تعديل البيانات "
                        type="submit"
                        color="primary"
                        :loading="user.loading"
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
import { useUsersIndex } from "../../stores/users/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const user = useUsersIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                user.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            user.updateData(table.row.id);
        };

        const onReset = () => {
            user.entry = {};
        };
        return { table, rules, user, onSubmit, onReset };
    },
};
</script>

<style></style>
