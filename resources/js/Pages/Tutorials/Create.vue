<template>
    <q-dialog
        v-model="tutorial.dialog"
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
                    إضافة درس جديد {{ tutorial.entry.material_id }}
                </div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <!-- :options="tutorial.lists.materials" -->
                    <q-select
                        v-if="local"
                        clearable
                        filled
                        v-model="tutorial.entry.material_id"
                        label="الفصل الدراسي"
                        option-value="id"
                        :option-label="
                            (opt) =>
                                `الفصل : ${opt.level} - المادة : ${opt.material} -  المعلم : ${opt.teacher}`
                        "
                        :rules="rules.selected"
                        emit-value
                        map-options
                        @new-value="createValue"
                        :options="filterOptions"
                        @filter="filterFn"
                        input-debounce="0"
                        use-input
                    >
                        <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                                <q-item-section avatar>
                                    <q-icon name="receipt_long" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>{{
                                        scope.opt.level
                                    }}</q-item-label>
                                    <q-item-label caption>
                                        المادة : {{ scope.opt.material }} - معلم
                                        المادة :
                                        {{ scope.opt.teacher }}</q-item-label
                                    >
                                </q-item-section>
                            </q-item>
                        </template>
                    </q-select>
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

                    <div class="row q-mt-md">
                        <div class="col q-mr-sm">
                            <q-file
                                filled
                                accept="audio/*"
                                v-model="tutorial.entry.audio"
                                label="تحميل مقطع الصوت "
                                disable
                            />
                        </div>
                        <div class="col q-ml-sm">
                            <q-input
                                clearable
                                filled
                                v-model="tutorial.entry.url"
                                label="اسم الفيديو من اليوتيوب ان  وجد"
                            />
                        </div>
                    </div>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="حفظ البيانات"
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
import { watch, ref } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const tutorial = useTutorialsIndex();
tutorial.entry.details = "";
export default {
    props: { local: { type: Boolean, default: false } },
    setup(props) {
        const filterOptions = ref();
        watch(table, (e) => {
            if (e.newRow && props.local == true) {
                tutorial.$reset();
                tutorial.dialog = true;
                tutorial.fetchCreateData();

                filterOptions.value = tutorial.lists.materials;
                // console.log("tutorials")
            }
        });

        watch(tutorial, (e) => {
            if (table.newRow) {
                table.newRow = false;
            }
        });

        const onSubmit = () => {
            tutorial.storeData();
        };

        const onReset = () => {
            tutorial.entry.title = null;
            tutorial.entry.details = null;
            tutorial.entry.audio = null;
            tutorial.entry.url = null;
        };
        return {
            table,
            rules,
            tutorial,
            onSubmit,
            onReset,
            filterOptions,
            createValue(val, done) {
                if (val.length > 2) {
                    if (!tutorial.lists.materials.includes(val)) {
                        done(val, "add-unique");
                    }
                }
            },

            filterFn(val, update) {
                update(() => {
                    if (val === "") {
                        filterOptions.value = tutorial.lists.materials;
                    } else {
                        const needle = val.toLowerCase();
                        filterOptions.value = tutorial.lists.materials.filter(
                            (v) =>
                                v.level.toLowerCase().indexOf(needle) > -1 ||
                                v.material.toLowerCase().indexOf(needle) > -1 ||
                                v.teacher.toLowerCase().indexOf(needle) > -1
                        );
                    }
                });
            },
        };
    },
};
</script>

<style></style>
