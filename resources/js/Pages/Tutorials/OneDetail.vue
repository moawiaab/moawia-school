<template>
    <q-page>
        <q-card>
            <q-card-section>
                <q-item-section>
                    <q-item-label class="text-h6">
                        عنوان الدرس : {{ tutorial.entry.title }}</q-item-label
                    >
                    <q-item-label caption>
                        اسم المادة : {{ tutorial.entry.material }} , اسم المعلم
                        : {{ tutorial.entry.teacher }}
                    </q-item-label>
                </q-item-section>
            </q-card-section>
            <q-separator />
            <q-card-section class="q-p-sm">
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
                    </div>
                </div>
                <q-chip
                    clickable
                    square
                    icon="add"
                    @click="tutorial.confirm = true"
                >
                    حل الاختبار والانتقال الى الدرس التالي
                </q-chip>
            </q-card-section>
            <q-separator />
            <!-- <pre>
                {{ tutorial.entry }}
            </pre> -->
        </q-card>

        <q-dialog v-model="tutorial.confirm" persistent>
            <q-card style="min-width: 80%">
                <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
                    <q-card-section class="row items-center"> </q-card-section>

                    <div
                        v-for="(item, index) in tutorial.entry.answers"
                        :key="index"
                    >
                        <q-item>
                            <q-item-label lines="2"
                                >{{ index + 1 }} - {{ item.ask }}</q-item-label
                            >
                        </q-item>
                        <div>
                            <q-list>
                                <q-item
                                    v-for="(e, id) in item.answers"
                                    :key="id"

                                >
                                    <q-item-section>
                                        <q-item-label caption>
                                            <q-radio
                                                v-model="item.status"
                                                :label="`${id + 1} - ${
                                                    e.answer
                                                }`"
                                                :val="e.id"
                                                checked-icon="task_alt" unchecked-icon="panorama_fish_eye"
                                            />
                                        </q-item-label>
                                    </q-item-section>
                                </q-item>
                                <div class="q-mx-md text-red" v-if="item.error">
                                    {{ item.error }}
                                </div>
                                <q-separator />
                            </q-list>
                        </div>
                    </div>

                    <q-card-actions align="right" class="bg-white text-teal">
                        <q-btn
                            flat
                            label="ارسال البيانات"
                            type="submit"
                            color="primary"
                            :loading="ask.loading"
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
    </q-page>
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useTutorialsIndex } from "../../stores/tutorials/index";
import CreateAsk from "./CreateAsk.vue";
import { useSingleAsk } from "../../stores/tutorials/aks";
import { watch, ref } from "vue";

const route = useRoute();
const router = useRouter();
const tutorial = useTutorialsIndex();
const ask = useSingleAsk();

onMounted(() => {
    tutorial.fetchShowOneData(route.params.id);
});

const validate = () => {
    let errors = [];
    tutorial.entry.answers.map((e) => {
        if (!e.status) {
            errors.push(false);
            e.error = "اجب عن هذا السؤال من فضلك";
            return false;
        } else {
            errors.push(true);
            e.error = null;
        }
    });

    return errors;
};

const onSubmit = async () => {
    if (validate().includes(false)) {
        console.log("onSubmit failed", validate());
    } else {
        const data = await tutorial.entry.answers.map(i => [{id :i.id, status :i.status}])
        ask.storeAnswer(data).then((result) => {
            router.push("/dashboard")
            tutorial.confirm = false;
        }).catch((err) => {

        });
        console.log(data)
        console.log("onSubmit", validate());
    }
    // validate();
};

watch(tutorial, (e) => {
    if (e.entry.answers) {
        console.log(e);
        validate();
    }
});
</script>

<style></style>
