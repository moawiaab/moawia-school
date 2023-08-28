<template>
    <q-page class="">
        <data-table
            :columns="student.columns"
            title="بيانات المستخدمين"
            selection="multiple"
            router="students"
            role="student"
        >
            <template #body-cell-name="props">
                <q-td :items="props.row">
                    {{ props.items.row.name }}
                </q-td>
            </template>

        </data-table>
        <create-student />
        <edit-student />
        <show-student />
    </q-page>
</template>

<script setup lang="ts">
import { useStudentsIndex } from "@/stores/students/index";
import CreateStudent from "./Create.vue";
import EditStudent from "./Edit.vue";
import ShowStudent from "./Show.vue";
const student = useStudentsIndex();

</script>
