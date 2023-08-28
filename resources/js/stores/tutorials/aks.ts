import axios from "axios";
import { defineStore } from "pinia";
import { Notify } from 'quasar';
import { nanoid, random } from 'nanoid'
// import { useTutorialsIndex } from ".";
// import { useRoute } from "vue-router";

interface answerData {
    id: string | null;
    answer: string | null,
    status: number | null,
}
interface entryData {
    id: number | null;
    ask: string;
    details: string;
    type: string | null;
    tutorial_id: string;
}

const route = "tutorials/add-asks";
export const useSingleAsk = defineStore("single-tutorials-ask", {
    state: () => ({
        entry: <entryData>{},
        answers: <answerData[]>[],
        lists: {
            products: [],
        },
        loading: false,
        dialog: false,
        itemId : null,

        maximizedToggle: true,
        errors: {
            ask: "",
            details: "",
        },
    }),
    getters: {
        hasErrors: (state) => state.errors,
        status: () => 1,
    },
    actions: {
        // send data to server in created
        storeData() {
            // const route_id = useRoute();
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, { ...this.entry, answers: { ...this.answers } })
                    .then((response) => {
                        Notify.create({
                            message: "تم إضافة السؤال بنجاح",
                            type: 'positive',

                        })
                        // useTables().getData();
                        // useTutorialsIndex().fetchShowData(parseInt(route_id.params.id.toString()))
                        // this.$reset()
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        reject(error);
                    });
                this.loading = false;
            });
        },

        // send a notification

        storeAnswer(data : any) {
            // const route_id = useRoute();
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post("tutorials/answer", {data :data})
                    .then((response) => {
                        Notify.create({
                            message: "تم الإجابة عن الأسئلة بنجاح",
                            type: 'positive',

                        })
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        reject(error);
                    });
                this.loading = false;
            });
        },
        // send data to server in updated
        updateData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${this.entry.id}`, this.entry)
                    .then((response) => {
                        // usePageIndex().fetchIndexData();
                        Notify.create({
                            message: "تم إضافة الدرس بنجاح",
                            type: 'positive',

                        })
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        reject(error);
                    });
                this.loading = false;
            });
        },

        setupEntry(entry: any, lists: any): void {
            this.entry = entry;
            this.lists = lists;
        },

        addAnswers() {
            this.answers.push({ id: nanoid(), answer: "", status: 0 })
            if (!this.entry.type || this.answers.length == 1) return this.entry.type = this.answers[0].id
            // if (this.answers.length == 1) return this.entry.type = this.answers[0].id

        },

        removeItem(item: any) {
            if (this.answers[item].id === this.entry.type) {
                this.answers.splice(item, 1);
                // this.answers.filter((e) => { return this.entry.type = e.id })
                let itemSet = this.answers[Math.floor(Math.random() * this.answers.length)]
                if (itemSet) return this.entry.type = itemSet.id
            } else
                this.answers.splice(item, 1);

        },

    },
});
