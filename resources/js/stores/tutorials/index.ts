import { TutorialColumns } from '@/types/columns';
import { defineStore } from "pinia";
import axios from "axios";
import type { TutorialData } from "@/types";
import { Notify } from 'quasar';
import { useTables } from '../tables';

const route = "/tutorials";

export const useTutorialsIndex = defineStore("tutorial-store", {
    state: () => ({
        entry: <TutorialData>{},
        lists: {
            Tutorials: []
        },
        loading: false,
        dialog: false,
        itemId : null,
        confirmDelete : false,
        audio: null,
        maximizedToggle: true,
        confirm: false,
        errors: {
            id: "",
            title: "",
            url: "",
            details: "",
        },
    }),
    getters: {
        columns: () => TutorialColumns,
    },
    actions: {
        fetchCreateData() {
            axios.get(`${route}/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },

        //start in edit
        fetchEditData(id: Number) {
            axios.get(`${route}/${id}/edit`).then((response) => {
                this.entry = response.data.data ?? [];
                // this.lists = response.data.meta ?? [];
                // useTables().row = {}
            });
        },

        fetchShowData(id: string) {
            this.loading = true;
            axios
                .get(`${route}/${id}`)
                .then((response) => {
                    this.entry = response.data.data ?? [];
                    this.lists = response.data.meta ?? [];
                });
            this.loading = false
        },

        fetchShowOneData(id: string) {
            this.loading = true;
            axios
                .get(`${route}/${id}/one`)
                .then((response) => {
                    this.entry = response.data.data ?? [];
                    this.lists = response.data.meta ?? [];
                });
            this.loading = false
        },


        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, this.entry, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        }
                    })
                    .then((response) => {
                        Notify.create({
                            message: "تم إضافة الدرس بنجاح",
                            type: 'positive',

                        })
                        useTables().getData();
                        this.$reset()
                        // this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        this.loading = false;
                        reject(error);
                    });
            });
        },

        storeAudio() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route + '/media', { ...{ file: this.audio }, ...{ model_id: this.entry.id }, ...{ collection_name: 'tutorial_audio' } }, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        }
                    })
                    .then((response) => {
                        Notify.create({
                            message: "تم تحميل مقطع الصوت بنجاح",
                            type: 'positive',

                        })
                        this.fetchShowData(this.entry.id)
                        this.confirm = false
                        this.audio = null
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        this.loading = false;
                        reject(error);
                    });
            });
        },


        // send data to server in updated
        updateData(id: string) {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${id}`, this.entry)
                    .then((response) => {
                        Notify.create({
                            message: "تم تعديل بيانات الدرس بنجاح",
                            type: 'positive',

                        })
                        useTables().getData();
                        useTables().editRow = false
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        this.loading = false;
                        reject(error);
                    });
            });
        },


        deleteAsk() {
            axios
                .delete(`tutorials/${this.itemId}/delete`)
                .then((response) => {
                    Notify.create({
                        message: 'تم الحذف بنجاح!',
                        type: 'positive',

                    })

                    this.fetchShowData(this.entry.id)
                    this.confirmDelete = false;
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message || "",
                        type: "warning"
                    })
                });
        },
    }
});
