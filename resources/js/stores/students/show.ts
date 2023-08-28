import { defineStore } from "pinia";
import axios from "axios";

const route = "/students";

export const useStudentsShow = defineStore("show-student-store", {
    state: () => ({
        entry: {},
        lists: {
            levels: [],
            level: [],
            trees : [],
        },
        loading: false,
        maximizedToggle: true,
        splitterModel: 30,

    }),
    getters: {
        // columns: () => StudentsColumns,
    },
    actions: {

        fetchShowData(id: number) {
            this.loading = true;
            axios
                .get(`${route}/${id}`)
                .then((response) => {
                    console.log("🚀 ~ file: show.ts:28 ~ .then ~ response:", response)
                    // this.lists = {
                    //     levels: [],
                    //     level: []
                    // };
                    // this.entry = {}
                    this.entry = response.data.data ?? [];
                    this.lists = response.data.meta ?? [];


                });
            this.loading = false
        },

        sum(obj: any, data: string) {
            var sum = 0;
            let ab = obj.forEach((element : any) => {
                sum += element[data];
            });
            return sum;
        }
    },
    persist: true
});
