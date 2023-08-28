<template>
    <q-dialog
        v-model="ask.dialog"
        persistent
        :maximized="ask.maximizedToggle"
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
                    @click="ask.maximizedToggle = false"
                    :disable="!ask.maximizedToggle"
                >
                    <q-tooltip
                        v-if="ask.maximizedToggle"
                        class="bg-white text-primary"
                        >Minimize</q-tooltip
                    >
                </q-btn>
                <q-btn
                    dense
                    flat
                    icon="crop_square"
                    @click="ask.maximizedToggle = true"
                    :disable="ask.maximizedToggle"
                >
                    <q-tooltip
                        v-if="!ask.maximizedToggle"
                        class="bg-white text-primary"
                        >Maximize</q-tooltip
                    >
                </q-btn>
                <q-btn dense flat icon="close" v-close-popup>
                    <q-tooltip class="bg-white text-primary">Close</q-tooltip>
                </q-btn>
            </q-bar>
            <q-card-section>
                <div class="text-h6">إضافة سؤال جديد : {{ ask.entry.id }}</div>
            </q-card-section>
            <q-separator />
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                <q-card-section class="q-p-sm">
                    <q-input
                        clearable
                        filled
                        v-model="ask.entry.ask"
                        label="السؤال "
                        placeholder="اكتب السؤال هنا من فضلك"
                        lazy-rules
                        :rules="rules.required"
                    />

                    <q-item-label class="q-ma-sm"
                        >تفاصيل عن السؤال</q-item-label
                    >
                    <q-editor
                        v-model="ask.entry.details"
                        :dense="$q.screen.lt.md"
                        placeholder="تفاصيل عن السؤال"
                        height="150"
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
                    <q-chip
                        clickable
                        square
                        label="إضافة اجابة جديدة"
                        @click="ask.addAnswers"
                    />
                    <q-list>
                        <q-item
                            v-for="(item, index) in ask.answers"
                            :key="index"
                        >
                            <q-item-section>
                                <q-input
                                    clearable
                                    filled
                                    v-model="item.answer"
                                    color="primary"
                                    lazy-rules
                                >
                                    <template v-slot:before>
                                        <q-icon
                                            name="close"
                                            @click="ask.removeItem(index)"
                                            class="cursor-pointer"
                                        />
                                    </template>
                                </q-input>
                            </q-item-section>

                            <q-item-section side>
                                <q-radio
                                    v-model="ask.entry.type"
                                    :val="item.id"
                                    label="الاجابة الصحيحة"
                                />
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>
                <q-separator />
                <q-card-actions align="right" class="bg-white text-teal">
                    <q-btn
                        flat
                        label="حفظ البيانات"
                        type="submit"
                        color="primary"
                        :loading="ask.loading"
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
import { useForms } from "../../Composables/rules";
import { useSingleAsk } from "../../stores/tutorials/aks";
import { useTutorialsIndex } from "../../stores/tutorials/index";
import { useRoute } from "vue-router";

const { rules: rulesData } = useForms();
const rules = rulesData;
const tutorial = useTutorialsIndex();
const ask = useSingleAsk();
ask.entry.details = "";
export default {
    setup() {
        const route = useRoute();
        const onSubmit = () => {
            ask.storeData()
                .then((result) => {
                    tutorial.fetchShowData(route.params.id);
                    ask.$reset();
                })
                .catch((err) => {});
        };

        const onReset = () => {
            ask.entry.title = null;
            ask.entry.details = null;
            ask.entry.audio = null;
            ask.entry.url = null;
        };
        return {
            rules,
            ask,
            onSubmit,
            onReset,
        };
    },
};
</script>

<style></style>
