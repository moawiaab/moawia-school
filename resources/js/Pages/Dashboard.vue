<template>
    <q-page class="">
        <div class="q-pa-sm">
            <div
                class="q-gutter-md row items-start"
                v-if="auth.userData.student"
            >
                <q-img
                    v-for="mode in student.entry.levelClass"
                    :key="mode.id"
                    src="/img/m.jpg"
                    style="max-width: 310px; height: 200px"
                    fit="fill"
                    @click="goToUrl(2)"
                >
                    <div class="absolute-bottom">
                        <div>كتاب : {{ mode.name }}</div>
                        <div
                            class="row"
                            v-for="(t, i) in mode.materials"
                            :key="i"
                        >
                            <div class="col-auto">
                                <q-btn
                                    dense
                                    flat
                                    glossy
                                    color="info"
                                    size="sm"
                                    :to="`/tutorials/${t.data.id}`"
                                    v-if="t.data"
                                >
                                    <!-- المدرس : {{ t.teacher }} -  {{t.id}} -->
                                    <q-chip
                                        dense
                                        square
                                        icon="link"
                                        color="info"
                                        class="text-white glossy"
                                        >المدرس : {{ t.teacher }}</q-chip
                                    >
                                </q-btn>
                                <q-chip
                                    v-else
                                    dense
                                    square
                                    icon="link"
                                    color="gary"
                                    class="glossy"
                                    >المدرس : {{ t.teacher }}</q-chip
                                >
                                <div class="">
                                    نسبة النجاح :
                                    {{
                                        parseFloat(
                                            (sum(t.answers, "askTrue") * 100) /
                                                sum(t.answers, "askAll")
                                        ).toFixed(1)
                                    }}
                                    %
                                </div>
                            </div>
                            <div class="col text-right">
                                <div class="">
                                    جميع الدروس :
                                    {{ t.tutorials }}
                                </div>
                                <div class="">
                                    الدروس المتبقية :
                                    {{ t.tutorialCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                </q-img>
            </div>

            <div class="example-row-equal-width" v-else>
                <div class="row">
                    <show-card
                        icon="mdi-account-school-outline"
                        :text="charts.num.student"
                        title="عدد الطلاب"
                        color="red"
                        subTitle="طالب"
                    />
                    <show-card
                        icon="mdi-account-tie-hat-outline"
                        :text="charts.num.teacher"
                        title="عدد المعلمين"
                        color="blue"
                        subTitle="معلم"
                    />
                    <show-card
                        icon="mdi-book-open-variant"
                        :text="charts.num.material"
                        title="المواد الدراسية"
                        color="green"
                        subTitle="مادة"
                    />
                    <show-card
                        icon="mdi-notebook-edit-outline"
                        :text="charts.num.tutorial"
                        title="عدد الدروس"
                        color="blue-grey"
                        subTitle="درس"
                    />
                </div>

                <q-separator />

                <div class="row" v-if="loading">
                    <div class="col-6">
                        <bar-chart
                            :chartData="charts.bar"
                            :chartOptions="options"
                        />
                    </div>
                    <div class="col-6">
                        <bar-chart
                            :chartData="charts.bar2"
                            :chartOptions="options"
                        />
                    </div>
                </div>
                <q-separator />

                <div class="row" v-if="loading">
                    <div class="col-6">
                        <RadarChart />
                    </div>
                    <div class="col">
                        <BubbleChart />
                    </div>
                </div>

                <div class="row" v-if="loading"></div>
            </div>
        </div>
        <!-- <pre>{{ student.entry.levelClass }}</pre> -->
    </q-page>
</template>

<script setup>
import ShowCard from "@/Components/Widgets/ShowCard.vue";
import BarChart from "@/Components/Charts/Bar.vue";
import BubbleChart from "@/Components/Charts/Bubble.vue";
import RadarChart from "@/Components/Charts/Radar.vue";
import { useAuth } from "@/stores/auth/index";
import { useStudentsShow } from "../stores/students/show";
import axios from "axios";
import { onMounted, ref } from "vue";

const student = useStudentsShow();
const auth = useAuth();

const loading = ref(false);
const charts = ref({
    num: {
        tutorial: 0,
        student: 0,
        teacher: 0,
        material: 0,
    },
    bar: [],
    bar2: [],
});

const goToUrl = (e) => {
    console.log("goToUrl", e);
};

onMounted(() => {
    if (!auth.userData) {
        auth.setRoles();
    } else {
        //! جلب البيانات في المستقبل عن تسجيل الدخول
        if (auth.userData.student) {
            student.fetchShowData(auth.userData.student);
        } else {
            loading.value = false;
            axios.get("dashboard").then((response) => {
                // charts.value = response.data
                // console.log(response.data);
                charts.value = response.data;
                loading.value = true;
                console.log(charts.value);
            });
            loading.value = false;
        }
    }
});

function sum(obj, data) {
    var sum = 0;
    let ab = obj.forEach((element) => {
        sum += element[data];
    });
    return isNaN(sum) ? 0 : sum.toFixed(1);
}

const options = {
    responsive: true,
    maintainAspectRatio: true,
};
</script>
<style scoped>
.q-img__content > div {
    padding: 2px 6px !important;
}
</style>
