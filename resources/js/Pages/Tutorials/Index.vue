<template>
    <q-page class="">
        <data-table
            :columns="tutorial.columns"
            title="نافذة المواد الدراسية"
            selection="multiple"
            router="tutorials"
            :expand="true"
            :viewable="false"
            role="tutorial"
        >
            <template #table-body="{ props }">


            <q-list class="q-ma-md" separator>
                <q-item
                    v-for="(item, index) in props.row.answers"
                    :key="index"
                    class="q-gutter-sm"
                >
                    <q-item-section >
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
                    <!-- <q-item-section side>
                        <q-btn fab flat color="red" icon="delete" @click="tutorial.confirmDelete = true ; tutorial.itemId = item.id"/>
                    </q-item-section> -->
                </q-item>
            </q-list>

            </template>

            <template #options="{ props }">
                <q-btn
                    icon="link"
                    dense
                    flat
                    rounded
                    color="green"
                    :to="`/tutorials/details/${props.id}`"
                />
            </template>
        </data-table>
        <create-tutorial :local="true" />
        <edit-tutorial />
        <show-tutorial />
    </q-page>
</template>

<script setup lang="ts">
import { useTutorialsIndex } from "@/stores/tutorials/index";
import CreateTutorial from "./Create.vue";
import EditTutorial from "./Edit.vue";
import ShowTutorial from "./Show.vue";
const tutorial = useTutorialsIndex();

let status = 1;
</script>
