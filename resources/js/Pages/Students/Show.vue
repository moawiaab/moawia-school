<template>
    <q-dialog
        v-model="table.showRow"
        :maximized="student.maximizedToggle"
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="min-width: 80%" title=" عرض بيانات الطالب">
            <q-bar>
                <q-space />

                <q-btn
                    dense
                    flat
                    icon="minimize"
                    @click="student.maximizedToggle = false"
                    :disable="!student.maximizedToggle"
                >
                    <q-tooltip
                        v-if="student.maximizedToggle"
                        class="bg-white text-primary"
                        >Minimize</q-tooltip
                    >
                </q-btn>
                <q-btn
                    dense
                    flat
                    icon="crop_square"
                    @click="student.maximizedToggle = true"
                    :disable="student.maximizedToggle"
                >
                    <q-tooltip
                        v-if="!student.maximizedToggle"
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
                    عرض بيانات الطالب :
                    {{ table.row.name || student.entry.name }}
                </div>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-pt-none">
                <q-splitter
                    v-model="student.splitterModel"
                    style="height: 100%"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-list separator>
                                <q-item>
                                    <q-item-label
                                        >اسم الطالب :
                                        {{ student.entry.name }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >البريد لالكتروني :
                                        {{ student.entry.email }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >رقم الهاتف :
                                        {{ student.entry.phone }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >تاريخ الميلاد :
                                        {{ student.entry.age }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        > العمر :
                                        {{ student.entry.ageNum }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label
                                        >الفصل الدراسي :
                                        {{ student.entry.level }}</q-item-label
                                    >
                                </q-item>
                                <q-item>
                                    <q-item-label lines="2">
                                        تفاصيل الطالب :
                                        {{
                                            student.entry.details
                                        }}</q-item-label
                                    >
                                </q-item>

                                <q-item>
                                    <q-item-label lines="2">
                                        عنوان الطالب :
                                        {{
                                            student.entry.address
                                        }}</q-item-label
                                    >
                                </q-item>

                                <!-- <q-item>
                                    <q-item-label>
                                        عدد المواد الدراسية :
                                        {{ student.entry.levelClass.length || 0 }}</q-item-label
                                    >
                                </q-item> -->

                                <q-item>
                                    <q-item-label
                                        >تاريخ الانشاء :
                                        {{
                                            student.entry.created_at
                                        }}</q-item-label
                                    >
                                </q-item>
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
                            <div
                                class="q-pa-md q-gutter-sm"
                                v-if="student.entry.trees"
                            >
                                <q-tree
                                    :nodes="student.entry.trees"
                                    accordion
                                    node-key="id"
                                    v-model:expanded="expanded"
                                >
                                    <template v-slot:default-body="prop">
                                        <div v-if="prop.node.tutorials">
                                            <q-chip square>
                                                جميع الدروس :
                                                {{
                                                    prop.node.tutorials
                                                }}</q-chip
                                            >
                                            <q-chip square>
                                                الدروس المتبقية :
                                                {{
                                                    prop.node.tutorialCount
                                                }}</q-chip
                                            >
                                            <q-chip square
                                                >نسبة النجاح :
                                                {{
                                                   parseFloat((sum(prop.node.answers, "askTrue") *
                                                        100) /
                                                    sum(prop.node.answers, "askAll")).toFixed(1)

                                                }}
                                                %</q-chip
                                            >
                                        </div>

                                        <div v-if="prop.node.asked">
                                            {{ prop.node.asked }}
                                        </div>
                                        <div v-if="prop.node.details" v-html="`التفاصيل : ${prop.node.details}`">
                                        </div>
                                        <div v-if="prop.node.answer">
                                            <q-chip v-if="prop.node.answer == 1" icon="task_alt" text-color="green" square label="تم أختيار الأجابة الصحيحة" />
                                            <q-chip v-if="prop.node.answer == 0" icon="clear" text-color="red" square label="تم أختيار إجابة خاطأ" />
                                            <q-chip v-if="!prop.node.answer" square label="لم يجب على هذا السؤال" />
                                        </div>

                                        <!-- <span
                                            v-else
                                            class="text-weight-light text-black"
                                            >This is some default content.</span
                                        > -->
                                    </template>
                                </q-tree>
                            </div>
                            <!-- <pre>{{student.entry.trees}}</pre> -->
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
import { useStudentsIndex } from "../../stores/students/index";
import { watch, ref } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const student = useStudentsIndex();
export default {
    setup() {
        watch(table, (e) => {
            if (e.showRow) {
                student.fetchShowData(table.row.id);
            }
        });

        function sum(obj, data) {
            var sum = 0;
            let ab = obj.forEach((element) => {
                sum += element[data];
            });
            return isNaN(sum) ? 0 : sum.toFixed(1);
        }

        return {
            table,
            rules,
            student,
            sum,
            expanded: ref(""),
            sum(obj, data) {
                var sum = 0;
                let ab = obj.forEach((element) => {
                    sum += element[data];
                });
                return isNaN(sum) ? 0 : sum.toFixed(1);
            },
        };
    },
};
</script>
<style scoped>
.q-img__content > div {
    padding: 2px 6px !important;
}
</style>
