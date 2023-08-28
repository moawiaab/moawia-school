<template>
    <q-dialog
        v-model="table.newRow"
        persistent
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card
            style="width: 800px; max-width: 70vw"
        >
            <q-card-section>
                <div class="text-h6">إنشاء معلم جديد</div>
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
                                    v-model="teacher.entry.name"
                                    label="اسم المعلم"
                                    lazy-rules
                                    :rules="rules.required"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="teacher.entry.email"
                                    label="البريد الالكتروني * "
                                    lazy-rules
                                    :rules="rules.required"
                                    type="email"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="teacher.entry.phone"
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
                                    filled
                                    clearable
                                    v-model="teacher.entry.password"
                                    label="كلمة السر"
                                    lazy-rules
                                    :rules="rules.required"
                                    type="password"
                                    :error-message="teacher.errors.password"
                                />
                                <q-input
                                    clearable
                                    filled
                                    v-model="
                                        teacher.entry.password_confirmation
                                    "
                                    label=" تأكيد كلمة السر"
                                    lazy-rules
                                    :rules="rules.required"
                                    type="password"
                                />

                                <q-input
                                    clearable
                                    filled
                                    v-model="teacher.entry.address"
                                    label="العنوان"
                                    lazy-rules
                                    :rules="rules.required"
                                />
                            </div>
                        </template>
                    </q-splitter>
                    <q-input
                        clearable
                        filled
                        v-model="teacher.entry.details"
                        label="التفاصيل"
                        lazy-rules
                        :rules="rules.required"
                    />
                </q-card-section>

                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="حفظ البيانات"
                        type="submit"
                        color="primary"
                        :loading="teacher.loading"
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
import { useTeachersIndex } from "../../stores/teachers/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const teacher = useTeachersIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.newRow) {
                teacher.$reset();
                teacher.fetchCreateData();
            }
        });

        const onSubmit = () => {
            teacher.storeData();
        };

        const onReset = () => {
            teacher.entry = {};
        };
        return { table, rules, teacher, onSubmit, onReset };
    },
};
</script>

<style></style>
