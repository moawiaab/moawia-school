<template>
    <div>
        <q-table
            class="my-sticky-column-table"
            flat

            :style="`height : ${$q.screen.height - 150}px`"
            :title="title"
            ref="tableRef"
            :rows="table.data"
            :columns="columns"
            v-model:pagination="table.pagination"
            :loading="table.loading"
            :filter="filter"
            binary-state-sort
            @request="onRequest"
            :selected-rows-label="table.getSelected()"
            v-model:selected="table.selected"
            :visible-columns="table.visibleColumns"
        >
            <template v-slot:top-right>
                <q-input
                    dense
                    debounce="300"
                    v-model="filter"
                    placeholder="أبحث هنا"
                >
                    <template #prepend>
                        <q-icon name="search" />
                    </template>
                    <template v-slot:append>
                        <q-select
                            v-model="table.visibleColumns"
                            multiple
                            dense
                            options-dense
                            :display-value="$q.lang.table.columns"
                            emit-value
                            map-options
                            :options="columns"
                            option-value="name"
                            options-cover
                            style="min-width: 150px"
                        />

                        <q-select
                            v-model="filters"
                            dense
                            options-dense
                            emit-value
                            map-options
                            :options="trashedData"
                            option-value="id"
                            option-label="name"
                            options-cover
                            style="min-width: 150px"
                        />

                        <q-btn
                            color="primary"
                            icon="archive"
                            dense
                            flat
                            rounded
                            no-caps
                            @click="exportTable"
                        />
                    </template>
                </q-input>
            </template>

            <!-- start expand -->

            <template v-slot:header="props" v-if="expand">
                <q-tr :props="props">
                    <q-th auto-width />
                    <q-th
                        v-for="col in props.cols"
                        :key="col.name"
                        :props="props"
                        class="text-left"
                    >
                        {{ col.label }}
                    </q-th>
                    <q-th auto-width />
                </q-tr>
            </template>
            <template #body="props" v-if="expand">
                <q-tr :props="props">
                    <q-td auto-width>
                        <q-btn
                            size="sm"
                            color="accent"
                            round
                            dense
                            @click="props.expand = !props.expand"
                            :icon="props.expand ? 'remove' : 'add'"
                        />
                    </q-td>
                    <q-td
                        v-for="col in props.cols"
                        :key="col.name"
                        :props="props"
                        class="text-left"
                    >
                        {{ col.value }}
                    </q-td>

                    <q-td
                        v-if="props.row.deleted_at"
                        class="deletedItem text-right"
                    >
                        <q-btn
                            icon="undo"
                            dense
                            flat
                            rounded
                            color="green"
                            @click="table.restoreItem(props.row.id)"
                            v-if="
                                deletable && auth.can.includes(`${role}_delete`)
                            "
                        />
                        <q-btn
                            icon="delete"
                            dense
                            flat
                            rounded
                            color="red"
                            @click="deleteItem(props.row)"
                            v-if="
                                deletable && auth.can.includes(`${role}_delete`)
                            "
                        />
                    </q-td>
                    <q-td :items="props.row" class="text-right" v-else>
                        <!-- {{ props.row.name }} -->
                        <slot name="options" :props="props.row"/>
                        <q-btn
                            icon="visibility"
                            dense
                            flat
                            rounded
                            color="green"
                            @click="table.showItem(props.row)"
                            v-if="
                                viewable && auth.can.includes(`${role}_access`)
                            "
                        />
                        <q-btn
                            icon="edit"
                            dense
                            flat
                            rounded
                            color="info"
                            @click="table.editItem(props.row)"
                            v-if="editable && auth.can.includes(`${role}_edit`)"
                        />
                        <q-btn
                            icon="delete"
                            dense
                            flat
                            rounded
                            color="red"
                            @click="deleteItem(props.row)"
                            v-if="
                                deletable && auth.can.includes(`${role}_delete`)
                            "
                        />
                    </q-td>
                </q-tr>
                <q-tr v-show="props.expand" :props="props">
                    <q-td colspan="100%">
                        <div class="text-left">
                            <slot name="table-body" :props="props" />
                        </div>
                    </q-td>
                </q-tr>
            </template>

            <!-- end expand -->

            <template #body-cell-options="props">
                <q-td
                    v-if="props.row.deleted_at"
                    class="deletedItem text-right"
                >
                    <q-btn
                        icon="undo"
                        dense
                        flat
                        rounded
                        color="green"
                        @click="table.restoreItem(props.row.id)"
                        v-if="deletable && auth.can.includes(`${role}_delete`)"
                    />
                    <q-btn
                        icon="delete"
                        dense
                        flat
                        rounded
                        color="red"
                        @click="deleteItem(props.row)"
                        v-if="deletable && auth.can.includes(`${role}_delete`)"
                    />
                </q-td>
                <q-td :items="props.row" class="text-right" v-else>
                    <!-- {{ props.row.name }} -->
                    <slot name="options" :props="props.row"/>
                    <q-btn
                        icon="visibility"
                        dense
                        flat
                        rounded
                        color="green"
                        @click="table.showItem(props.row)"
                        v-if="viewable && auth.can.includes(`${role}_access`)"
                    />
                    <q-btn
                        icon="edit"
                        dense
                        flat
                        rounded
                        color="info"
                        @click="table.editItem(props.row)"
                        v-if="editable && auth.can.includes(`${role}_edit`)"
                    />
                    <q-btn
                        icon="delete"
                        dense
                        flat
                        rounded
                        color="red"
                        @click="deleteItem(props.row)"
                        v-if="deletable && auth.can.includes(`${role}_delete`)"
                    />
                </q-td>
            </template>

            <template v-for="(_, slot) of $slots" #[slot]="props">
                <slot :name="slot" :items="props" />
            </template>
        </q-table>

        <q-dialog v-model="table.confirm" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <q-avatar
                        icon="folder_delete"
                        color="primary"
                        text-color="white"
                    />
                    <span v-if="table.row.deleted_at" class="q-ml-sm">
                        هل تريد حذفه من الارشيف نهائيا
                    </span>
                    <span v-else class="q-ml-sm"
                        >هل تريد نقل البيانات الى سلة المهملات</span
                    >
                    <br />
                    <q-chip square> الرقم : {{ table.row.id || 0 }}</q-chip>
                    <q-chip square>
                        الاسم : {{ table.row.name || table.row.title }}</q-chip
                    >
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="إلغاء" color="red" v-close-popup />
                    <q-btn
                        flat
                        label="تأكيد الحذف"
                        color="primary"
                        @click="table.delete(table.row.id)"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-page-sticky position="bottom-right" :offset="[20, 20]">
            <f-abs :data="fabBtn" />
        </q-page-sticky>
    </div>
</template>

<script setup>
import { watch, computed } from "vue";
import { useTables } from "../../stores/tables/index";
import { onMounted, ref } from "vue";
import exportFile from "quasar/src/utils/export-file.js";
import useQuasar from "quasar/src/composables/use-quasar.js";
import { useAuth } from "@/stores/auth/index";

const table = useTables();
const auth = useAuth();
table.$reset();

const props = defineProps({
    columns: { type: Array },
    title: { type: String, default: "" },
    role: { type: String, default: "" },
    router: { type: String },
    expand: { type: Boolean, default: false },
    deletable: { type: Boolean, default: true },
    editable: { type: Boolean, default: true },
    viewable: { type: Boolean, default: true },
});

const tableRef = ref();
const filter = ref("");
const filters = ref("");

watch(filters, (e) => {
    table.filters.trashed = e;
    table.getData();
});

function onRequest(props, col) {
    const filter = props.filter;
    table.setFilter(filter);
    table.pagination = props.pagination;
    table.pagination.sortType = table.pagination.descending ? "asc" : "desc";
    table.getData();
}

onMounted(() => {
    table.setRouter(props.router);
    // get initial data from server (1st page)
    table.visibleColumns = props.columns.map((e) => e.name);
    tableRef.value.requestServerInteraction();
    console.log(
        "visibleColumns",
        table.visibleColumns,
        "columns = ",
        props.columns
    );
});

const deleteItem = (item) => {
    table.confirm = true;
    table.row = item;
    console.log(item);
};

const trashedData = [
    { name: "غير محذوف", id: "" },
    { name: "محذوف فقط", id: "only" },
    { name: "كل البيانات معا", id: "with" },
];
function wrapCsvValue(val, formatFn, row) {
    let formatted = formatFn !== void 0 ? formatFn(val, row) : val;

    formatted =
        formatted === void 0 || formatted === null ? "" : String(formatted);

    formatted = formatted.split('"').join('""');
    /**
     * Excel accepts \n and \r in strings, but some other CSV parsers do not
     * Uncomment the next two lines to escape new lines
     */
    // .split('\n').join('\\n')
    // .split('\r').join('\\r')

    return `"${formatted}"`;
}

const exportTable = () => {
    // naive encoding to csv format
    const content = [props.columns.map((col) => wrapCsvValue(col.label))]
        .concat(
            table.data.map((row) =>
                props.columns
                    .map((col) =>
                        wrapCsvValue(
                            typeof col.field === "function"
                                ? col.field(row)
                                : row[
                                      col.field === void 0
                                          ? col.name
                                          : col.field
                                  ],
                            col.format,
                            row
                        )
                    )
                    .join(",")
            )
        )
        .join("\r\n");

    const status = exportFile("table-export.csv", content, "text/csv");

    if (status !== true) {
        $q.notify({
            message: "Browser denied file download...",
            color: "negative",
            icon: "warning",
        });
    }
};

const fabBtn = [
    {
        color: "orange",
        icon: "add",
        label: "إنشاء صف جديد",
        onClick: () => (table.newRow = true),
        disable: table.newRow,
    },
    {
        color: "green",
        icon: "sync",
        label: "تحديث البيانات",
        onClick: () => {
            table.setRouter(props.router);
            table.getData();
        },
        disable: table.loading,
    },
    {
        color: "secondary",
        icon: "replay",
        label: " إعادة تحميل البيانات",
        onClick: () => {
            table.$reset();
            table.setRouter(props.router);
            table.visibleColumns = props.columns.map((e) => e.name);
            tableRef.value.requestServerInteraction();
            console.log(
                "visibleColumns",
                table.visibleColumns,
                "columns = ",
                props.columns
            );
            table.getData();
        },
        disable: table.loading,
    },
    {
        color: "accent",
        icon: "file_download",
        label: "تنزيل البيانات اكسل",
        onClick: () => exportTable(),
    },
    { color: "primary", icon: "home", label: "الذهاب الى الرئيسية", to: "/" },
];
</script>

<style>
tr:has(td.deletedItem) {
    background: #ffb3bc80 !important;
}
</style>
<style lang="sass">
.my-sticky-column-table
  max-width: 100%
  thead tr:last-child th:last-child,
  thead tr:first-child th:first-child
    /* bg color is important for th; just specify one */
    background-color: #ffffff
  td:last-child,
  td:first-child
    background-color: #ffffff

  th:first-child,
  td:first-child
    position: sticky
    left: 0
    z-index: 1
  th:last-child,
  td:last-child
    position: sticky
    right: 0
    z-index: 0
tr:has(td.deletedItem)
  td
    background: #ffb3bc80 !important
</style>
