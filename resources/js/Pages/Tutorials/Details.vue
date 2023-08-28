<template>
    <q-page>
        <q-card>
            <q-card-section>
                <q-item-section>
                    <q-item-label class="text-h6">
                        عنوان الدرس : {{ tutorial.entry.title }}</q-item-label
                    >
                    <q-item-label caption
                        >تاريخ الإضافة :
                        {{ tutorial.entry.created_at }}</q-item-label
                    >
                </q-item-section>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-p-sm" v-if="tutorial.entry">
                <iframe
                    style="width: 100%; max-height: 400px; height: 350px"
                    v-if="tutorial.entry.url"
                    :src="`https://www.youtube-nocookie.com/embed/${tutorial.entry.url}`"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                ></iframe>
                <div class="q-mt-sm" v-html="tutorial.entry.details" />
            </q-card-section>
            <q-separator />
            <q-card-section align="center">
                <div class="row">
                    <div class="col-auto text-left">
                        <q-chip square>
                            الفصل الدراسي : {{ tutorial.entry.level }}</q-chip
                        >
                        <q-chip square>
                            اسم المادة : {{ tutorial.entry.material }}</q-chip
                        >
                        <q-chip square>
                            اسم المعلم : {{ tutorial.entry.teacher }}</q-chip
                        >
                        <q-chip square>
                            اسم المستخدم : {{ tutorial.entry.user }}</q-chip
                        >
                    </div>
                    <!-- <q-separator vertical /> -->
                    <div class="col"></div>
                    <div class="col-auto text-right">
                        <audio
                            style="width: 100%"
                            v-if="tutorial.entry.audio"
                            :src="tutorial.entry.audio"
                            controls
                        />
                        <div v-else class="text-right" style="width: 100%">
                            <!-- <q-btn label="تحميل مقطع الصوت" /> -->
                            <q-chip
                                clickable
                                square
                                icon="audio_file"
                                @click="tutorial.confirm = true"
                                disable
                            >
                                تحميل مقطع الصوت
                            </q-chip>
                        </div>
                    </div>
                </div>
            </q-card-section>
            <q-separator />
            <div class="row">
                <dev class="text-h6 q-ma-md col-auto"
                    >الأسئلة الخاصة بهذا الدرس
                </dev>
                <div class="col"></div>
                <div class="col-auto text-right">
                    <q-chip
                        label=" إضافة سؤال جديد لهذا الدرس"
                        square
                        clickable
                        class="glossy"
                        icon="add_circle"
                        @click="
                            ask.entry.tutorial_id = route.params.id;
                            ask.dialog = true;
                        "
                    />
                </div>
            </div>

            <q-list class="q-ma-md" separator>
                <q-item
                    v-for="(item, index) in tutorial.entry.answers"
                    :key="index"
                >
                    <q-item-section>
                        <q-item-label>{{ item.ask }} </q-item-label>
                        <q-item-label caption lines="2">
                            <div v-html="item.details" />
                        </q-item-label>
                        <q-item-label
                            caption
                            v-for="(a, i) in item.answers"
                            :key="i"
                        >
                            <q-radio
                                v-model="status"
                                :label="`${a.answer}`"
                                :val="a.status"
                                disabled
                                checked-icon="task_alt" unchecked-icon="panorama_fish_eye"
                            />
                        </q-item-label>
                    </q-item-section>
                    <q-item-section side>
                        <q-btn fab flat color="red" icon="delete" @click="tutorial.confirmDelete = true ; tutorial.itemId = item.id"/>
                    </q-item-section>
                </q-item>
            </q-list>
        </q-card>

        <create-ask />

        <q-dialog v-model="tutorial.confirm" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <div class="col q-mr-sm">
                        {{tutorial.entry.id}}
                        <q-file
                            filled
                            accept="audio/*"
                            v-model="tutorial.audio"
                            label="تحميل مقطع الصوت "
                        />
                    </div>
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn
                        flat
                        label="قفل النافذة"
                        v-close-popup
                        color="negative"
                    />
                    <q-btn
                        flat
                        label="تحميل الصوت"
                        color="primary"
                        @click="tutorial.storeAudio()"
                        :disable="tutorial.loading"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-dialog v-model="tutorial.confirmDelete" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <div class="col q-mr-sm">سيتم حذف السؤال من هذا الدرس</div>
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn
                        flat
                        label="قفل النافذة"
                        v-close-popup
                        color="negative"
                    />
                    <q-btn
                        flat
                        label="تأكيد الحذف"
                        color="primary"
                        @click="tutorial.deleteAsk()"
                        :disable="tutorial.loading"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { useTutorialsIndex } from "../../stores/tutorials/index";
import CreateAsk from "./CreateAsk.vue";
import { useSingleAsk } from "../../stores/tutorials/aks";

const route = useRoute();
const tutorial = useTutorialsIndex();
const ask = useSingleAsk();

let status = 1

onMounted(() => {
    // tutorial.setRoute("tutorials");
    tutorial.fetchShowData(route.params.id);
});
</script>

<style></style>
