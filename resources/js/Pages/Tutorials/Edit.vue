<template>
    <q-dialog
        v-model="table.editRow"
        persistent
        :maximized="tutorial.maximizedToggle"
        transition-show="scale"
        transition-hide="scale"
    >
        <q-card style="min-width: 80%">
            <q-bar>
                <q-space />

                <q-btn
                    dense
                    flat
                    icon="minimize"
                    @click="tutorial.maximizedToggle = false"
                    :disable="!tutorial.maximizedToggle"
                >
                    <q-tooltip
                        v-if="tutorial.maximizedToggle"
                        class="bg-white text-primary"
                        >Minimize</q-tooltip
                    >
                </q-btn>
                <q-btn
                    dense
                    flat
                    icon="crop_square"
                    @click="tutorial.maximizedToggle = true"
                    :disable="tutorial.maximizedToggle"
                >
                    <q-tooltip
                        v-if="!tutorial.maximizedToggle"
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
                    تعديل بيانات الصلاحية :
                    {{ table.row.title || tutorial.entry.title }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="tutorial.entry.title"
                        label="عنوان الدرس"
                        lazy-rules
                        :rules="rules.required"
                    />

                    <q-item-label class="q-ma-sm">محتوى الدرس </q-item-label>
                    <q-editor
                        v-model="tutorial.entry.details"
                        :dense="$q.screen.lt.md"
                        :toolbar="[
                            [
                                {
                                    label: $q.lang.editor.align,
                                    icon: $q.iconSet.editor.align,
                                    fixedLabel: true,
                                    list: 'only-icons',
                                    options: [
                                        'left',
                                        'center',
                                        'right',
                                        'justify',
                                    ],
                                },
                            ],
                            [
                                'bold',
                                'italic',
                                'strike',
                                'underline',
                                'subscript',
                                'superscript',
                            ],
                            ['token', 'hr', 'link', 'custom_btn'],
                            ['print', 'fullscreen'],
                            [
                                {
                                    label: $q.lang.editor.formatting,
                                    icon: $q.iconSet.editor.formatting,
                                    list: 'no-icons',
                                    options: [
                                        'p',
                                        'h1',
                                        'h2',
                                        'h3',
                                        'h4',
                                        'h5',
                                        'h6',
                                        'code',
                                    ],
                                },
                                {
                                    label: $q.lang.editor.fontSize,
                                    icon: $q.iconSet.editor.fontSize,
                                    fixedLabel: true,
                                    fixedIcon: true,
                                    list: 'no-icons',
                                    options: [
                                        'size-1',
                                        'size-2',
                                        'size-3',
                                        'size-4',
                                        'size-5',
                                        'size-6',
                                        'size-7',
                                    ],
                                },

                                'removeFormat',
                            ],
                            [
                                'quote',
                                'unordered',
                                'ordered',
                                'outdent',
                                'indent',
                            ],

                            ['undo', 'redo'],
                            ['viewsource'],
                        ]"
                    />

                    <q-input
                        class="q-mt-md"
                        clearable
                        filled
                        v-model="tutorial.entry.url"
                        label="اسم الفيديو من اليوتيوب ان  وجد"
                    />
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="تعديل البيانات "
                        type="submit"
                        color="primary"
                        :loading="tutorial.loading"
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
import { useTutorialsIndex } from "../../stores/tutorials/index";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const tutorial = useTutorialsIndex();

export default {
    setup() {
        watch(table, (e) => {
            if (e.editRow) {
                tutorial.fetchEditData(table.row.id);
            }
        });

        const onSubmit = () => {
            tutorial.updateData(table.row.id);
        };

        const onReset = () => {
            tutorial.entry = {};
        };
        return { table, rules, tutorial, onSubmit, onReset };
    },
};
</script>

<style></style>
