<template>
    <q-dialog
        v-model="table.showRow"
        :maximized="user.maximizedToggle"
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="min-width: 80%" title="إنشاء مستخدم جديد">
            <q-bar>
                <q-space />

                <q-btn
                    dense
                    flat
                    icon="minimize"
                    @click="user.maximizedToggle = false"
                    :disable="!user.maximizedToggle"
                >
                    <q-tooltip
                        v-if="user.maximizedToggle"
                        class="bg-white text-primary"
                        >Minimize</q-tooltip
                    >
                </q-btn>
                <q-btn
                    dense
                    flat
                    icon="crop_square"
                    @click="user.maximizedToggle = true"
                    :disable="user.maximizedToggle"
                >
                    <q-tooltip
                        v-if="!user.maximizedToggle"
                        class="bg-white text-primary"
                        >Maximize</q-tooltip
                    >
                </q-btn>
                <q-btn dense flat icon="close" v-close-popup>
                    <q-tooltip class="bg-white text-primary">Close</q-tooltip>
                </q-btn>
            </q-bar>
            <q-card-section>
                <div class="text-h6">
                    عرض بيانات الفصل الدراسي :
                    {{ table.row.name || user.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter v-model="user.splitterModel" style="height: 100%">
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list>
                                <q-item>
                                    <q-item-label
                                        >اسم الفصل :
                                        {{ user.entryData.name }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        > تفاصيل الفصل :
                                        {{ user.entryData.details }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                                <q-item>
                                    <q-item-label
                                        >تاريخ الانشاء :
                                        {{
                                            user.entryData.created_at
                                        }}</q-item-label
                                    >
                                </q-item>
                                <q-separator inset />
                            </q-list>
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
                            <q-table
                                dense
                                flat
                                bordered
                                title="الطلاب بهذا الفصل"
                                :rows="user.lists.students"
                                :columns="StudentsLevels"
                                row-key="name"
                                hide-bottom
                            >
                            </q-table>
                        </div>
                    </template>
                </q-splitter>
            </q-card-section>
            <q-separator />
            <q-card-actions align="right" class="bg-white text-teal">
                <q-btn
                    flat
                    label="قفل النافذة"
                    v-close-popup
                    color="negative"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script>
import { useTables } from "../../stores/tables/index";
import { useForms } from "../../Composables/rules";
import { useLevelsIndex } from "@/stores/levels/index";
import { watch } from "vue";
import { StudentsLevels } from "@/types/columns";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const user = useLevelsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.showRow) {
                user.fetchShowData(table.row.id);
            }
        });
        return { table, rules, user, StudentsLevels };
    },
};
</script>

<style></style>
